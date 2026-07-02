<?php

namespace Azuriom\Plugin\Tebex\Services;

use Illuminate\Contracts\Session\Session;

class CartSessionService
{
    public const SESSION_KEY = 'tebex.cart';

    public function __construct(private Session $session) {}

    public function getCart(): array
    {
        return $this->session->get(self::SESSION_KEY, [
            'items' => [],
            'created_at' => now()->toIso8601String(),
            'ip_address' => request()->ip(),
        ]);
    }

    private function save(array $cart): void
    {
        $cart['updated_at'] = now()->toIso8601String();
        $this->session->put(self::SESSION_KEY, $cart);
    }

    public function clear(): void
    {
        $this->session->forget(self::SESSION_KEY);
    }

    public function count(): int
    {
        return count($this->getCart()['items'] ?? []);
    }

    public function items(): array
    {
        $items = $this->getCart()['items'] ?? [];
        return collect($items)->map(fn($qty, $id) => [
            'package_id' => (int) $id,
            'quantity' => (int) $qty
        ])->values()->all();
    }

    public function addItem(int $packageId, int $quantity = 1): array
    {
        $cart = $this->getCart();
        $currentQty = $cart['items'][$packageId] ?? 0;

        $newQty = $currentQty + $quantity;

        if ($newQty <= 0) {
            unset($cart['items'][$packageId]);
        } else {
            $cart['items'][$packageId] = $newQty;
        }

        $this->save($cart);
        return $this->snapshot();
    }

    public function setItemQuantity(int $packageId, int $quantity): array
    {
        $cart = $this->getCart();

        if ($quantity <= 0) {
            unset($cart['items'][$packageId]);
        } else {
            $cart['items'][$packageId] = $quantity;
        }

        $this->save($cart);
        return $this->snapshot();
    }

    public function removeItem(int $packageId): array
    {
        $cart = $this->getCart();
        unset($cart['items'][$packageId]);
        $this->save($cart);
        return $this->snapshot();
    }

    public function snapshot(): array
    {
        return [
            'items' => $this->items(),
            'count' => $this->count(),
            'ip_address' => request()->ip(),
            'username' => auth()->user()?->name,
            'email' => auth()->user()?->email,
        ];
    }
}
