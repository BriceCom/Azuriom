<?php

namespace Azuriom\Plugin\WebhookManager\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Models\ActionLog;
use Azuriom\Models\Permission;
use Azuriom\Plugin\Shop\Events\PaymentPaid;
use Azuriom\Plugin\WebhookManager\Listeners\AdminLoginListener;
use Azuriom\Plugin\WebhookManager\Listeners\OrderPaidListener;
use Azuriom\Plugin\WebhookManager\Listeners\TicketCreatedListener;
use Azuriom\Plugin\WebhookManager\Listeners\UserRegisteredListener;
use Azuriom\Plugin\WebhookManager\Listeners\UserVotedListener;
use Azuriom\Plugin\WebhookManager\Models\Webhook;
use Azuriom\Plugin\WebhookManager\Models\WebhookService;
use Azuriom\Plugin\WebhookManager\Services\EventRegistry;
use Azuriom\Plugin\WebhookManager\Services\VariableResolver;
use Azuriom\Plugin\WebhookManager\Services\WebhookDispatcher;
use Azuriom\Plugin\WebhookManager\Services\WebhookManagerManager;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Event;

class WebhookManagerServiceProvider extends BasePluginServiceProvider
{
    /**
     * Register any plugin services.
     */
    public function register(): void
    {
        $this->app->singleton(EventRegistry::class);
        $this->app->singleton(VariableResolver::class);
        $this->app->singleton(WebhookDispatcher::class);
        $this->app->singleton(WebhookManagerManager::class);
    }

    /**
     * Bootstrap any plugin services.
     */
    public function boot(): void
    {
        $this->loadViews();

        $this->loadTranslations();

        $this->loadMigrations();

        $this->registerRouteDescriptions();

        $this->registerAdminNavigation();

        Permission::registerPermissions([
            'webhook-manager.admin' => 'webhook-manager::admin.permissions.admin',
        ]);

        ActionLog::registerLogModels([
            Webhook::class,
            WebhookService::class,
        ], 'webhook-manager::admin.logs.action_models');

        $this->registerEventListeners();
    }

    /**
     * Returns the routes that should be able to be added to the navbar.
     *
     * @return array<string, string>
     */
    protected function routeDescriptions(): array
    {
        return [];
    }

    /**
     * Return the admin navigations routes to register in the dashboard.
     *
     * @return array<string, array<string, string>>
     */
    protected function adminNavigation(): array
    {
        return [
            'webhook-manager' => [
                'name' => trans('webhook-manager::admin.nav.title'),
                'type' => 'dropdown',
                'icon' => 'bi bi-broadcast-pin',
                'route' => 'webhook-manager.admin.*',
                'permission' => 'webhook-manager.admin',
                'items' => [
                    'webhook-manager.admin.services.index' => trans('webhook-manager::admin.nav.services'),
                    'webhook-manager.admin.webhooks.index' => trans('webhook-manager::admin.nav.webhooks'),
                    'webhook-manager.admin.logs.index' => trans('webhook-manager::admin.nav.logs'),
                ],
            ],
        ];
    }

    protected function registerEventListeners(): void
    {
        Event::listen(Registered::class, UserRegisteredListener::class);
        Event::listen(Login::class, AdminLoginListener::class);
        Event::listen(PaymentPaid::class, OrderPaidListener::class);

        $this->app->booted(function () {
            $this->registerVoteBridge();
            $this->registerTicketBridge();
        });
    }

    protected function registerVoteBridge(): void
    {
        $voteModel = 'Azuriom\\Plugin\\Vote\\Models\\Vote';

        if (! class_exists($voteModel)) {
            return;
        }

        $listener = $this->app->make(UserVotedListener::class);

        $voteModel::created(static fn ($vote) => $listener->handle($vote));
    }

    protected function registerTicketBridge(): void
    {
        $supportTicketModel = 'Azuriom\\Plugin\\Support\\Models\\Ticket';

        if (! class_exists($supportTicketModel)) {
            return;
        }

        $listener = $this->app->make(TicketCreatedListener::class);

        $supportTicketModel::created(static fn ($ticket) => $listener->handle($ticket));
    }
}
