<?php

namespace Azuriom\Plugin\WebhookManager\Services;

use Azuriom\Plugin\WebhookManager\Models\Webhook;
use Azuriom\Plugin\WebhookManager\Models\WebhookService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Throwable;

class WebhookDispatcher
{
    public function __construct(
        protected VariableResolver $resolver,
        protected EventRegistry $events,
    ) {
    }

    /**
     * Dispatch all active webhooks matching the given event.
     *
     * @param  array<int|string, mixed>  $context
     */
    public function dispatch(string $event, array $context = []): void
    {
        $webhooks = $this->matchingWebhooks($event);

        foreach ($webhooks as $webhook) {
            $this->sendWebhook($webhook, $event, $context);
        }
    }

    /**
     * Dispatch one webhook in test mode.
     *
     * @param  array<int|string, mixed>|null  $context
     * @return array{success: bool, status: int, body: string}
     */
    public function test(Webhook $webhook, ?array $context = null): array
    {
        $context ??= $this->resolver->sampleContext($webhook->event);

        return $this->sendWebhook($webhook, $webhook->event, $context);
    }

    /**
     * @param  array<int|string, mixed>  $context
     * @return array{success: bool, status: int, body: string}
     */
    protected function sendWebhook(Webhook $webhook, string $event, array $context): array
    {
        $service = $webhook->service;

        if ($service === null) {
            return $this->logFailure($webhook, $event, [], [], 'Missing webhook service configuration.');
        }

        $resolvedContext = $this->resolver->enrichContext($event, $context);
        $payload = $this->resolver->resolvePayload($webhook->payload_template ?? [], $resolvedContext);
        $payload = $this->applyServiceIdentity($service, $payload);
        $headers = $this->resolver->resolveHeaders($webhook->headers, $resolvedContext);

        $payloadJson = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        if ($payloadJson === false) {
            $payloadJson = '{}';
        }

        if ($webhook->secret !== null && $webhook->secret !== '') {
            $headers['X-Webhook-Signature'] = hash_hmac('sha256', $payloadJson, $webhook->secret);
        }

        $status = 0;
        $body = '';
        $success = false;

        try {
            $response = Http::timeout(max(1, $webhook->timeout))
                ->withHeaders($headers)
                ->acceptJson()
                ->post($service->url, $payload);

            $status = $response->status();
            $body = (string) $response->body();
            $success = $response->successful();
        } catch (Throwable $exception) {
            report($exception);
            $body = $exception->getMessage();
        }

        return $this->storeLog($webhook, $event, $payload, $headers, $status, $body, $success);
    }

    /**
     * @param  array<int|string, mixed>  $payload
     * @return array<int|string, mixed>
     */
    protected function applyServiceIdentity(WebhookService $service, array $payload): array
    {
        if (! $service->isDiscord()) {
            return $payload;
        }

        if (! empty($service->bot_name) && ! array_key_exists('username', $payload)) {
            $payload['username'] = $service->bot_name;
        }

        if (! empty($service->bot_avatar) && ! array_key_exists('avatar_url', $payload)) {
            $payload['avatar_url'] = $service->bot_avatar;
        }

        if (empty($service->default_color)) {
            return $payload;
        }

        $defaultColor = $this->hexToDiscordColor($service->default_color);

        if (is_array($payload['embed'] ?? null)
            && (! array_key_exists('color', $payload['embed']) || $payload['embed']['color'] === null || $payload['embed']['color'] === '')
        ) {
            $payload['embed']['color'] = $defaultColor;
        }

        if (! is_array($payload['embeds'] ?? null)) {
            return $payload;
        }

        foreach ($payload['embeds'] as $index => $embed) {
            if (! is_array($embed)) {
                continue;
            }

            if (array_key_exists('color', $embed) && $embed['color'] !== null && $embed['color'] !== '') {
                continue;
            }

            $payload['embeds'][$index]['color'] = $defaultColor;
        }

        return $payload;
    }

    protected function hexToDiscordColor(string $hexColor): int
    {
        return hexdec(ltrim($hexColor, '#'));
    }

    /**
     * @param  array<int|string, mixed>  $payload
     * @param  array<string, string>  $headers
     * @return array{success: bool, status: int, body: string}
     */
    protected function storeLog(Webhook $webhook, string $event, array $payload, array $headers, int $status, string $body, bool $success): array
    {
        $webhook->logs()->create([
            'event' => $event,
            'payload_sent' => $payload,
            'headers_sent' => $this->maskSensitiveHeaders($headers),
            'response_status' => $status,
            'response_body' => Str::limit($body, 64000, ''),
            'sent_at' => now(),
        ]);

        return [
            'success' => $success,
            'status' => $status,
            'body' => $body,
        ];
    }

    /**
     * @param  array<int|string, mixed>  $payload
     * @param  array<string, string>  $headers
     * @return array{success: bool, status: int, body: string}
     */
    protected function logFailure(Webhook $webhook, string $event, array $payload, array $headers, string $message): array
    {
        return $this->storeLog($webhook, $event, $payload, $headers, 0, $message, false);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, \Azuriom\Plugin\WebhookManager\Models\Webhook>
     */
    protected function matchingWebhooks(string $event)
    {
        $isCustomEvent = ! $this->events->isDefault($event);

        return Webhook::query()
            ->with('service')
            ->active()
            ->where(function ($query) use ($event, $isCustomEvent) {
                $query->where('event', $event);

                if ($isCustomEvent) {
                    $query->orWhere('event', 'custom.*');
                }
            })
            ->get();
    }

    /**
     * @param  array<string, string>  $headers
     * @return array<string, string>
     */
    protected function maskSensitiveHeaders(array $headers): array
    {
        $maskedHeaders = [];

        foreach ($headers as $key => $value) {
            $keyLower = Str::lower($key);
            $isSensitive = Str::contains($keyLower, [
                'authorization',
                'signature',
                'secret',
                'token',
                'key',
            ]);

            if (! $isSensitive) {
                $maskedHeaders[$key] = $value;

                continue;
            }

            $prefix = Str::substr($value, 0, 6);
            $maskedHeaders[$key] = $prefix === '' ? '***' : $prefix.'***';
        }

        return $maskedHeaders;
    }
}
