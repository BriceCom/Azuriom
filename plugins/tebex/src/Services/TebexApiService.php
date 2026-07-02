<?php

namespace Azuriom\Plugin\Tebex\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Crypt;

class TebexApiService
{
    private string $baseUrl = 'https://headless.tebex.io/api';
    private ?string $cachedToken = null;

    public function getConfiguredPublicKeyOrAbort(): string
    {
        if ($this->cachedToken) return $this->cachedToken;

        $key = setting('tebex.key');
        if (empty($key)) abort(500, 'Tebex key missing');

        return $this->cachedToken = $key;
    }

    private function getCredentials(): array
    {
        $encryptedPrivateKey = setting('tebex.private_key');
        $decryptedPrivateKey = '';

        if ($encryptedPrivateKey) {
            try {
                $decryptedPrivateKey = Crypt::decryptString($encryptedPrivateKey);
            } catch (\Exception $e) {
                $decryptedPrivateKey = '';
            }
        }

        return [
            'project_id' => setting('tebex.project_id'),
            'private_key' => $decryptedPrivateKey,
        ];
    }

    /**
     * Récupère les infos de la boutique (Nom, Devise, Domain...)
     * Endpoint: GET /accounts/:token
     */
    public function getAccountInfo(string $token): ?array
    {
        return cache()->remember('tebex.account_info', 3600, function () use ($token) {
            return $this->http(true)->get("{$this->baseUrl}/accounts/{$token}")->json();
        });
    }

    private function http(bool $isPublic = false): PendingRequest
    {
        $request = Http::withOptions([
            'verify' => app()->environment('production'),
            'timeout' => 15,
        ])->withHeaders([
            'Accept' => 'application/json',
            'User-Agent' => 'Azuriom/TebexPlugin',
        ]);

        if (! $isPublic) {
            $creds = $this->getCredentials();
            $request->withBasicAuth($creds['project_id'] ?? '', $creds['private_key'])
                ->withHeaders(['X-Tebex-Secret' => $creds['private_key']]);
        }

        return $request;
    }

    public function processCheckout(string $token, array $items, string $username, array $urls, ?string $creatorCode = null): string
    {
        $basket = $this->createBasketWithFallback($token, $urls, $username);

        if (! $basket) {
            throw new \RuntimeException(trans('tebex::admin.errors.basket_creation_failed'));
        }

        $basketIdent = $basket['ident'] ?? $basket['data']['ident'];
        session()->put('tebex.basket.ident', $basketIdent);

        $failures = $this->addPackagesToBasket($basketIdent, $items);

        if ($creatorCode !== null && $creatorCode !== '') {
            if (! $this->addCreatorCode($token, $basketIdent, $creatorCode)) {
                throw new \RuntimeException(trans('tebex::messages.cart.creator_code_failed'));
            }
        }

        if (! empty($failures)) {
            $authLink = $this->fetchAuthLink($token, $basketIdent, $urls['show']);
            if ($authLink) return $authLink;
        }

        $checkoutUrl = $basket['links']['checkout'] ?? ($basket['data']['links']['checkout'] ?? null);

        if ($checkoutUrl) return $checkoutUrl;

        $refreshedBasket = $this->getBasket($token, $basketIdent);
        return $refreshedBasket['links']['checkout'] ?? ($refreshedBasket['data']['links']['checkout'] ?? null)
            ?? route('tebex.cart.show');
    }

    public function addCreatorCode(string $token, string $basketIdent, string $creatorCode): bool
    {
        $response = $this->http()->post("{$this->baseUrl}/accounts/{$token}/baskets/{$basketIdent}/creator-codes", [
            'creator_code' => $creatorCode,
        ]);

        return $response->successful();
    }

    public function removeCreatorCode(string $token, string $basketIdent): bool
    {
        $response = $this->http()->post("{$this->baseUrl}/accounts/{$token}/baskets/{$basketIdent}/creator-codes/remove");

        return $response->successful();
    }

    public function updateBasketPackageQuantity(string $basketIdent, int $packageId, int $quantity): bool
    {
        $response = $this->http()->put("{$this->baseUrl}/baskets/{$basketIdent}/packages/{$packageId}", [
            'quantity' => $quantity,
        ]);

        return $response->successful();
    }

    public function removeBasketPackage(string $basketIdent, int $packageId): bool
    {
        $response = $this->http()->post("{$this->baseUrl}/baskets/{$basketIdent}/packages/remove", [
            'package_id' => $packageId,
        ]);

        return $response->successful();
    }

    public function createBasketWithFallback(string $token, array $urls, ?string $username): ?array
    {
        $payload = [
            'complete_url' => $urls['complete'],
            'cancel_url' => $urls['cancel'],
        ];

        if ($username) $payload['username'] = $username;

        $response = $this->http()->asJson()->post("{$this->baseUrl}/accounts/{$token}/baskets", $payload);
        if ($response->successful()) return $response->json();

        $responseForm = $this->http()->asForm()->post("{$this->baseUrl}/accounts/{$token}/baskets", $payload);
        if ($responseForm->successful()) return $responseForm->json();
        if ($username) {
            unset($payload['username']);
            $responseWithoutUsername = $this->http()->asForm()->post("{$this->baseUrl}/accounts/{$token}/baskets", $payload);

            if ($responseWithoutUsername->successful()) {
                return $responseWithoutUsername->json();
            }
        }

        return null;
    }

    public function addPackagesToBasket(string $basketIdent, array $items): array
    {
        $responses = Http::pool(function (Pool $pool) use ($basketIdent, $items) {
            foreach ($items as $item) {
                $pool->as('pkg_'.$item['package_id'])->post("{$this->baseUrl}/baskets/{$basketIdent}/packages", [
                    'package_id' => $item['package_id'],
                    'quantity' => $item['quantity']
                ]);
            }
        });

        $failures = [];
        foreach ($items as $item) {
            if ($responses['pkg_'.$item['package_id']]->failed()) {
                $failures[] = $item['package_id'];
            }
        }

        return $failures;
    }

    private function fetchAuthLink(string $token, string $basketIdent, string $returnUrl): ?string
    {
        $res = $this->getBasketAuthLinks($token, $basketIdent, $returnUrl);
        $links = $res['links'] ?? ($res['data']['links'] ?? []);

        return $links[0]['href']
            ?? ($links[0]['url']
                ?? ($res[0]['url'] ?? null));
    }

    public function getBasket(string $token, string $basketIdent): ?array
    {
        return $this->http(true)->get("{$this->baseUrl}/accounts/{$token}/baskets/{$basketIdent}")->json();
    }

    public function getBasketAuthLinks(string $token, string $basketIdent, string $returnUrl): ?array
    {
        return $this->http(true)->get("{$this->baseUrl}/accounts/{$token}/baskets/{$basketIdent}/auth", [
            'returnUrl' => $returnUrl
        ])->json();
    }

    public function getPackagesWithPricing(string $token, ?string $basketIdent = null): ?array
    {
        $query = $basketIdent ? ['basketIdent' => $basketIdent] : [];
        return $this->http(true)->get("{$this->baseUrl}/accounts/{$token}/packages", $query)->json();
    }

    public function getCategories(string $token, bool $withPackages = false): ?array
    {
        return $this->http(true)->get("{$this->baseUrl}/accounts/{$token}/categories", [
            'includePackages' => $withPackages ? '1' : '0'
        ])->json();
    }

    public function getSidebarModules(string $token): ?array
    {
        return $this->http(true)->get("{$this->baseUrl}/accounts/{$token}/sidebar")->json();
    }
}
