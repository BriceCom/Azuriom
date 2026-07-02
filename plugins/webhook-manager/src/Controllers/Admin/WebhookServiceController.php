<?php

namespace Azuriom\Plugin\WebhookManager\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\WebhookManager\Models\WebhookService;
use Azuriom\Plugin\WebhookManager\Requests\WebhookServiceRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WebhookServiceController extends Controller
{
    /**
     * Display a listing of webhook services.
     */
    public function index(): View
    {
        $services = WebhookService::query()
            ->withCount('webhooks')
            ->orderBy('name')
            ->paginate(20);

        return view('webhook-manager::admin.services.index', [
            'services' => $services,
            'types' => $this->translatedTypes(),
        ]);
    }

    /**
     * Show the form for creating a new webhook service.
     */
    public function create(): View
    {
        return view('webhook-manager::admin.services.create', [
            'service' => new WebhookService([
                'type' => WebhookService::TYPE_DISCORD,
                'default_color' => '#5865F2',
            ]),
            'types' => $this->translatedTypes(),
        ]);
    }

    /**
     * Store a newly created webhook service.
     */
    public function store(WebhookServiceRequest $request): RedirectResponse
    {
        WebhookService::create($request->validated());

        return to_route('webhook-manager.admin.services.index')
            ->with('success', trans('webhook-manager::admin.services.saved'));
    }

    /**
     * Show the form for editing the specified webhook service.
     */
    public function edit(WebhookService $service): View
    {
        return view('webhook-manager::admin.services.edit', [
            'service' => $service,
            'types' => $this->translatedTypes(),
        ]);
    }

    /**
     * Update the specified webhook service in storage.
     */
    public function update(WebhookServiceRequest $request, WebhookService $service): RedirectResponse
    {
        $service->update($request->validated());

        return to_route('webhook-manager.admin.services.index')
            ->with('success', trans('webhook-manager::admin.services.saved'));
    }

    /**
     * Remove the specified webhook service from storage.
     */
    public function destroy(WebhookService $service): RedirectResponse
    {
        if ($service->webhooks()->exists()) {
            return to_route('webhook-manager.admin.services.index')
                ->with('error', trans('webhook-manager::admin.services.delete_blocked'));
        }

        $service->delete();

        return to_route('webhook-manager.admin.services.index')
            ->with('success', trans('webhook-manager::admin.services.deleted'));
    }

    /**
     * @return array<string, string>
     */
    protected function translatedTypes(): array
    {
        $types = [];

        foreach (WebhookService::types() as $type) {
            $types[$type] = trans('webhook-manager::admin.services.types.'.$type);
        }

        return $types;
    }
}
