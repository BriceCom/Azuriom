<?php

namespace Azuriom\Plugin\WebhookManager\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\WebhookManager\Models\Webhook;
use Azuriom\Plugin\WebhookManager\Models\WebhookLog;
use Azuriom\Plugin\WebhookManager\Services\EventRegistry;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LogController extends Controller
{
    public function __construct(protected EventRegistry $events)
    {
    }

    /**
     * Display webhook delivery logs.
     */
    public function index(Request $request): View
    {
        $selectedEvent = (string) $request->input('event', '');

        $logs = WebhookLog::query()
            ->with('webhook.service')
            ->when($request->filled('webhook_id'), fn ($query) => $query->where('webhook_id', $request->integer('webhook_id')))
            ->when($selectedEvent !== '', fn ($query) => $query->where('event', $selectedEvent))
            ->orderByDesc('sent_at')
            ->paginate(25)
            ->withQueryString();

        return view('webhook-manager::admin.logs.index', [
            'logs' => $logs,
            'webhooks' => Webhook::query()->orderBy('name')->get(['id', 'name']),
            'events' => $this->events->all(),
            'selectedWebhookId' => $request->integer('webhook_id'),
            'selectedEvent' => $selectedEvent,
        ]);
    }
}
