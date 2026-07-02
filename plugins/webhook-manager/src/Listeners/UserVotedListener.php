<?php

namespace Azuriom\Plugin\WebhookManager\Listeners;

use Azuriom\Plugin\WebhookManager\Services\WebhookDispatcher;

class UserVotedListener
{
    public function __construct(protected WebhookDispatcher $dispatcher)
    {
    }

    public function handle(object $vote): void
    {
        if (method_exists($vote, 'loadMissing')) {
            $vote->loadMissing('user', 'site');
        }

        $user = $vote->user ?? null;
        $site = $vote->site ?? null;

        $this->dispatcher->dispatch('user.voted', [
            'user' => [
                'name' => $user?->name,
                'email' => $user?->email,
            ],
            'vote' => [
                'server_name' => $site?->name,
                'site' => $site?->url ?? $site?->name,
            ],
        ]);
    }
}
