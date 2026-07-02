<?php

namespace Azuriom\Plugin\WebhookManager\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\WebhookManager\Models\Webhook;
use Azuriom\Plugin\WebhookManager\Models\WebhookService;
use Azuriom\Plugin\WebhookManager\Requests\WebhookRequest;
use Azuriom\Plugin\WebhookManager\Services\EventRegistry;
use Azuriom\Plugin\WebhookManager\Services\WebhookDispatcher;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WebhookController extends Controller
{
    public function __construct(
        protected EventRegistry $events,
        protected WebhookDispatcher $dispatcher,
    ) {
    }

    /**
     * Display the list of configured webhooks.
     */
    public function index(): View
    {
        $webhooks = Webhook::query()
            ->with(['latestLog', 'service'])
            ->orderByDesc('id')
            ->paginate(20);

        return view('webhook-manager::admin.webhooks.index', [
            'webhooks' => $webhooks,
            'events' => $this->events->all(),
        ]);
    }

    /**
     * Show the webhook creation form.
     */
    public function create(): View
    {
        $services = WebhookService::query()->orderBy('name')->get();

        return view('webhook-manager::admin.webhooks.create', [
            'webhook' => new Webhook([
                'service_id' => $services->first()?->id,
                'is_active' => true,
                'timeout' => 5,
                'payload_template' => [
                    'content' => trans('webhook-manager::admin.webhooks.default_payload_content'),
                ],
            ]),
            'services' => $services,
            'events' => $this->events->all(),
            'variablesByEvent' => $this->events->variablesByEvent(),
            'payloadExamplesByEvent' => $this->payloadExamplesByEvent(),
            'headerRows' => [['name' => '', 'value' => '']],
        ]);
    }

    /**
     * Store a newly created webhook.
     */
    public function store(WebhookRequest $request): RedirectResponse
    {
        Webhook::create($request->validated());

        return to_route('webhook-manager.admin.webhooks.index')
            ->with('success', trans('webhook-manager::admin.webhooks.saved'));
    }

    /**
     * Show the edit form for a webhook.
     */
    public function edit(Webhook $webhook): View
    {
        $services = WebhookService::query()->orderBy('name')->get();

        return view('webhook-manager::admin.webhooks.edit', [
            'webhook' => $webhook,
            'services' => $services,
            'events' => $this->events->all(),
            'variablesByEvent' => $this->events->variablesByEvent(),
            'payloadExamplesByEvent' => $this->payloadExamplesByEvent(),
            'headerRows' => $this->headerRowsFromWebhook($webhook),
        ]);
    }

    /**
     * Update an existing webhook.
     */
    public function update(WebhookRequest $request, Webhook $webhook): RedirectResponse
    {
        $webhook->update($request->validated());

        return to_route('webhook-manager.admin.webhooks.index')
            ->with('success', trans('webhook-manager::admin.webhooks.saved'));
    }

    /**
     * Delete a webhook.
     */
    public function destroy(Webhook $webhook): RedirectResponse
    {
        $webhook->delete();

        return to_route('webhook-manager.admin.webhooks.index')
            ->with('success', trans('webhook-manager::admin.webhooks.deleted'));
    }

    /**
     * Send a sample request with the selected webhook configuration.
     */
    public function test(Webhook $webhook): RedirectResponse
    {
        $result = $this->dispatcher->test($webhook);

        if ($result['success']) {
            return to_route('webhook-manager.admin.webhooks.index')
                ->with('success', trans('webhook-manager::admin.webhooks.test_success', [
                    'status' => $result['status'],
                ]));
        }

        return to_route('webhook-manager.admin.webhooks.index')
            ->with('error', trans('webhook-manager::admin.webhooks.test_failed', [
                'error' => $result['body'] !== ''
                    ? $result['body']
                    : trans('webhook-manager::admin.webhooks.http_status', [
                        'status' => $result['status'],
                    ]),
            ]));
    }

    /**
     * @return array<int, array{name: string, value: string}>
     */
    protected function headerRowsFromWebhook(Webhook $webhook): array
    {
        $rows = [];

        foreach (($webhook->headers ?? []) as $name => $value) {
            $rows[] = [
                'name' => $name,
                'value' => $value,
            ];
        }

        return $rows !== [] ? $rows : [['name' => '', 'value' => '']];
    }

    /**
     * @return array<string, array<string, mixed>>
     */
    protected function payloadExamplesByEvent(): array
    {
        $examples = trans('webhook-manager::admin.webhooks.payload_examples');

        return is_array($examples) ? $examples : [];
    }
}
