<?php

namespace Azuriom\Plugin\WebhookManager\Listeners;

use Azuriom\Plugin\WebhookManager\Services\WebhookDispatcher;
use Illuminate\Auth\Events\Login;

class AdminLoginListener
{
    public function __construct(protected WebhookDispatcher $dispatcher)
    {
    }

    public function handle(Login $event): void
    {
        $user = $event->user;

        if (! method_exists($user, 'hasAdminAccess') || ! $user->hasAdminAccess()) {
            return;
        }

        $this->dispatcher->dispatch('admin.login', [
            'admin' => [
                'name' => $user->name,
                'ip' => request()?->ip() ?? $user->last_login_ip,
            ],
        ]);
    }
}
