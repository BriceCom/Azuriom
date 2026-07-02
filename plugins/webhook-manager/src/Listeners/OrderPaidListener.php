<?php

namespace Azuriom\Plugin\WebhookManager\Listeners;

use Azuriom\Plugin\Shop\Events\PaymentPaid;
use Azuriom\Plugin\WebhookManager\Services\WebhookDispatcher;

class OrderPaidListener
{
    public function __construct(protected WebhookDispatcher $dispatcher)
    {
    }

    public function handle(PaymentPaid $event): void
    {
        $payment = $event->payment->loadMissing('user', 'items');
        $items = $payment->items
            ->map(fn ($item) => [
                'name' => $item->name,
                'quantity' => $item->quantity,
                'price' => $item->formatPrice(),
            ])
            ->values();

        $this->dispatcher->dispatch('order.paid', [
            'user' => [
                'name' => $payment->user?->name,
                'email' => $payment->user?->email,
            ],
            'order' => [
                'id' => $payment->id,
                'total' => $payment->formatPrice(),
                'items' => $items->all(),
                'items_text' => ($items
                    ->map(fn (array $item) => trim(($item['name'] ?? '').' x'.($item['quantity'] ?? 0)))
                    ->filter()
                    ->implode(', ')) ?: '-',
            ],
        ]);
    }
}
