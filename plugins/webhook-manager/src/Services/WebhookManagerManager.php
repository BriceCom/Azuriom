<?php

namespace Azuriom\Plugin\WebhookManager\Services;

class WebhookManagerManager
{
    public function __construct(
        protected EventRegistry $registry,
        protected WebhookDispatcher $dispatcher,
    ) {
    }

    /**
     * Register a custom event exposed to the Webhook Manager UI.
     *
     * @param  array{label?: string, variables?: array<int, string>}  $metadata
     */
    public function registerEvent(string $event, array $metadata = []): void
    {
        $this->registry->registerEvent($event, $metadata);
    }

    /**
     * Dispatch an event payload to matching webhooks.
     *
     * @param  array<int|string, mixed>  $context
     */
    public function dispatch(string $event, array $context = []): void
    {
        $this->dispatcher->dispatch($event, $context);
    }

    /**
     * Get all registered events.
     *
     * @return array<string, array{label: string, variables: array<int, string>, custom: bool}>
     */
    public function events(): array
    {
        return $this->registry->all();
    }
}
