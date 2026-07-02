<?php

namespace Azuriom\Plugin\WebhookManager\Listeners;

use Azuriom\Plugin\WebhookManager\Services\WebhookDispatcher;

class TicketCreatedListener
{
    public function __construct(protected WebhookDispatcher $dispatcher)
    {
    }

    public function handle(object $ticket): void
    {
        if (method_exists($ticket, 'loadMissing')) {
            $relations = [];

            if (method_exists($ticket, 'author')) {
                $relations[] = 'author';
            }

            if (method_exists($ticket, 'user')) {
                $relations[] = 'user';
            }

            if (method_exists($ticket, 'category')) {
                $relations[] = 'category';
            }

            if ($relations !== []) {
                $ticket->loadMissing($relations);
            }
        }

        $user = $ticket->author ?? $ticket->user ?? null;
        $category = $ticket->category ?? null;

        $this->dispatcher->dispatch('ticket.created', [
            'user' => [
                'name' => $user?->name,
                'email' => $user?->email,
            ],
            'ticket' => [
                'subject' => $ticket->subject ?? $ticket->title ?? null,
                'id' => $ticket->id ?? null,
                'category' => $category?->name,
            ],
        ]);
    }
}
