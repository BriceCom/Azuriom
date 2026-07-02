<?php

namespace Azuriom\Plugin\WebhookManager\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use JsonSerializable;
use Stringable;

class VariableResolver
{
    /**
     * Add shared variables and normalize context structure.
     *
     * @param  array<int|string, mixed>  $context
     * @return array<string, mixed>
     */
    public function enrichContext(string $event, array $context): array
    {
        $normalizedContext = $this->normalizeContext($context);

        $common = [
            'event' => $event,
            'site' => [
                'name' => site_name(),
            ],
            'date' => now()->toDateTimeString(),
        ];

        return array_replace_recursive($common, $normalizedContext);
    }

    /**
     * Resolve all placeholders in the given payload template.
     *
     * @param  array<int|string, mixed>  $template
     * @param  array<int|string, mixed>  $context
     * @return array<int|string, mixed>
     */
    public function resolvePayload(array $template, array $context): array
    {
        return $this->resolveValue($template, $context);
    }

    /**
     * Resolve all placeholders in the given headers.
     *
     * @param  array<string, string>|null  $headers
     * @param  array<int|string, mixed>  $context
     * @return array<string, string>
     */
    public function resolveHeaders(?array $headers, array $context): array
    {
        if ($headers === null) {
            return [];
        }

        $resolved = [];

        foreach ($headers as $name => $value) {
            $resolvedName = trim((string) $this->resolveValue($name, $context));
            $resolvedValue = trim((string) $this->resolveValue($value, $context));

            if ($resolvedName === '' || $resolvedValue === '') {
                continue;
            }

            $resolved[$resolvedName] = $resolvedValue;
        }

        return $resolved;
    }

    /**
     * Return a sample context used by the "Test webhook" button.
     *
     * @return array<string, mixed>
     */
    public function sampleContext(string $event): array
    {
        return match ($event) {
            'user.registered' => [
                'user' => [
                    'name' => 'PlayerOne',
                    'email' => 'playerone@example.com',
                ],
            ],
            'order.paid' => [
                'user' => [
                    'name' => 'PlayerOne',
                    'email' => 'playerone@example.com',
                ],
                'order' => [
                    'id' => 42,
                    'total' => '19.99 EUR',
                    'items' => [
                        ['name' => 'VIP Rank', 'quantity' => 1],
                        ['name' => 'Crate Keys', 'quantity' => 5],
                    ],
                    'items_text' => 'VIP Rank x1, Crate Keys x5',
                ],
            ],
            'admin.login' => [
                'admin' => [
                    'name' => 'AdminUser',
                    'ip' => request()?->ip() ?? '127.0.0.1',
                ],
            ],
            'user.voted' => [
                'user' => [
                    'name' => 'PlayerOne',
                    'email' => 'playerone@example.com',
                ],
                'vote' => [
                    'server_name' => 'Lobby',
                    'site' => 'https://example-vote.tld',
                ],
            ],
            'ticket.created' => [
                'user' => [
                    'name' => 'PlayerOne',
                    'email' => 'playerone@example.com',
                ],
                'ticket' => [
                    'subject' => 'Need help with ranks',
                    'id' => 1337,
                    'category' => 'Support',
                ],
            ],
            default => [
                'custom' => [
                    'var1' => 'value1',
                    'var2' => 'value2',
                ],
            ],
        };
    }

    /**
     * @param  mixed  $value
     * @param  array<int|string, mixed>  $context
     * @return mixed
     */
    protected function resolveValue(mixed $value, array $context): mixed
    {
        if (is_array($value)) {
            $resolved = [];

            foreach ($value as $key => $item) {
                $resolvedKey = is_string($key)
                    ? (string) $this->resolveValue($key, $context)
                    : $key;
                $resolved[$resolvedKey] = $this->resolveValue($item, $context);
            }

            return $resolved;
        }

        if (! is_string($value)) {
            return $value;
        }

        if (! Str::contains($value, '{')) {
            return $value;
        }

        if (preg_match('/^\{([a-zA-Z0-9_.-]+)\}$/', $value, $matches) === 1) {
            return $this->normalizeResolvedValue($this->getVariableValue($matches[1], $context));
        }

        return preg_replace_callback('/\{([a-zA-Z0-9_.-]+)\}/', function (array $matches) use ($context) {
            $resolved = $this->getVariableValue($matches[1], $context);

            if ($resolved === null) {
                return '';
            }

            if (is_scalar($resolved) || $resolved instanceof Stringable) {
                if (is_bool($resolved)) {
                    return $resolved ? 'true' : 'false';
                }

                return (string) $resolved;
            }

            return json_encode($this->normalizeResolvedValue($resolved), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }, $value);
    }

    /**
     * @param  array<int|string, mixed>  $context
     * @return array<string, mixed>
     */
    protected function normalizeContext(array $context): array
    {
        $normalized = [];

        foreach ($context as $key => $value) {
            if (is_string($key) && Str::contains($key, '.')) {
                Arr::set($normalized, $key, $value);
                continue;
            }

            if (is_string($key)) {
                $normalized[$key] = $value;
            }
        }

        return array_replace_recursive($normalized, $context);
    }

    /**
     * @param  array<int|string, mixed>  $context
     */
    protected function getVariableValue(string $variable, array $context): mixed
    {
        if (array_key_exists($variable, $context)) {
            return $context[$variable];
        }

        return data_get($context, $variable);
    }

    /**
     * @param  mixed  $resolved
     * @return mixed
     */
    protected function normalizeResolvedValue(mixed $resolved): mixed
    {
        if ($resolved instanceof Carbon) {
            return $resolved->toDateTimeString();
        }

        if ($resolved instanceof Stringable) {
            return (string) $resolved;
        }

        if ($resolved instanceof JsonSerializable) {
            return $resolved->jsonSerialize();
        }

        if (is_array($resolved)) {
            $normalized = [];

            foreach ($resolved as $key => $value) {
                $normalized[$key] = $this->normalizeResolvedValue($value);
            }

            return $normalized;
        }

        return $resolved;
    }
}
