<?php

namespace Azuriom\Plugin\WebhookManager\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void registerEvent(string $event, array{label?: string, variables?: array<int, string>} $metadata = [])
 * @method static void dispatch(string $event, array<int|string, mixed> $context = [])
 * @method static array<string, array{label: string, variables: array<int, string>, custom: bool}> events()
 *
 * @see \Azuriom\Plugin\WebhookManager\Services\WebhookManagerManager
 */
class WebhookManager extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return \Azuriom\Plugin\WebhookManager\Services\WebhookManagerManager::class;
    }
}
