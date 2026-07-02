<?php

namespace Azuriom\Plugin\WebhookManager\Listeners;

use Azuriom\Plugin\WebhookManager\Services\WebhookDispatcher;
use Illuminate\Auth\Events\Registered;

class UserRegisteredListener
{
    public function __construct(protected WebhookDispatcher $dispatcher)
    {
    }

    public function handle(Registered $event): void
    {
        $this->dispatcher->dispatch('user.registered', [
            'user' => [
                'name' => $event->user->name,
                'email' => $event->user->email,
            ],
        ]);
    }
}
