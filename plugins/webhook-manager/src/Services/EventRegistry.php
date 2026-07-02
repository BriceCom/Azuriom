<?php

namespace Azuriom\Plugin\WebhookManager\Services;

use Illuminate\Support\Arr;
use InvalidArgumentException;

class EventRegistry
{
    /**
     * Runtime custom events declared by third-party plugins.
     *
     * @var array<string, array{label: string, variables: array<int, string>, custom: bool}>
     */
    protected static array $customEvents = [];

    /**
     * Get all available events.
     *
     * @return array<string, array{label: string, variables: array<int, string>, custom: bool}>
     */
    public function all(): array
    {
        return array_replace($this->defaultEvents(), self::$customEvents);
    }

    /**
     * Get the variables list grouped by event.
     *
     * @return array<string, array<int, string>>
     */
    public function variablesByEvent(): array
    {
        $variables = [];

        foreach ($this->all() as $event => $metadata) {
            $variables[$event] = Arr::get($metadata, 'variables', []);
        }

        return $variables;
    }

    public function has(string $event): bool
    {
        return array_key_exists($event, $this->all());
    }

    public function isDefault(string $event): bool
    {
        return array_key_exists($event, $this->defaultEvents());
    }

    /**
     * Register a custom event from another plugin.
     *
     * @param  array{label?: string, variables?: array<int, string>}  $metadata
     */
    public function registerEvent(string $event, array $metadata = []): void
    {
        $event = trim($event);

        if ($event === '') {
            throw new InvalidArgumentException('The event name cannot be empty.');
        }

        $label = trim((string) Arr::get($metadata, 'label', $event));
        $variables = array_values(array_filter(
            Arr::get($metadata, 'variables', []),
            static fn (mixed $variable): bool => is_string($variable) && trim($variable) !== ''
        ));

        self::$customEvents[$event] = [
            'label' => $label !== '' ? $label : $event,
            'variables' => $variables,
            'custom' => true,
        ];
    }

    /**
     * Get the default shipped events.
     *
     * @return array<string, array{label: string, variables: array<int, string>, custom: bool}>
     */
    protected function defaultEvents(): array
    {
        return [
            'user.registered' => [
                'label' => trans('webhook-manager::admin.events.user_registered'),
                'variables' => [
                    'user.name',
                    'user.email',
                    'site.name',
                    'date',
                ],
                'custom' => false,
            ],
            'order.paid' => [
                'label' => trans('webhook-manager::admin.events.order_paid'),
                'variables' => [
                    'user.name',
                    'user.email',
                    'order.id',
                    'order.total',
                    'order.items',
                    'order.items_text',
                    'site.name',
                    'date',
                ],
                'custom' => false,
            ],
            'admin.login' => [
                'label' => trans('webhook-manager::admin.events.admin_login'),
                'variables' => [
                    'admin.name',
                    'admin.ip',
                    'site.name',
                    'date',
                ],
                'custom' => false,
            ],
            'user.voted' => [
                'label' => trans('webhook-manager::admin.events.user_voted'),
                'variables' => [
                    'user.name',
                    'user.email',
                    'vote.server_name',
                    'vote.site',
                    'site.name',
                    'date',
                ],
                'custom' => false,
            ],
            'ticket.created' => [
                'label' => trans('webhook-manager::admin.events.ticket_created'),
                'variables' => [
                    'user.name',
                    'user.email',
                    'ticket.subject',
                    'ticket.id',
                    'ticket.category',
                    'site.name',
                    'date',
                ],
                'custom' => false,
            ],
            'custom.*' => [
                'label' => trans('webhook-manager::admin.events.custom_all'),
                'variables' => [
                    'site.name',
                    'date',
                ],
                'custom' => true,
            ],
        ];
    }
}
