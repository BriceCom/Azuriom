<?php

namespace Azuriom\Plugin\Trackurl\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Models\ActionLog;
use Azuriom\Models\Permission;
use Azuriom\Plugin\Trackurl\Models\Link;

class TrackurlServiceProvider extends BasePluginServiceProvider
{
    /**
     * The plugin's global HTTP middleware stack.
     */
    protected array $middleware = [
        \Azuriom\Plugin\Trackurl\Middleware\RefMiddleware::class,
    ];

    /**
     * The plugin's route middleware groups.
     */
    protected array $middlewareGroups = [];

    /**
     * The plugin's route middleware.
     */
    protected array $routeMiddleware = [
        // 'example' => \Azuriom\Plugin\Trackurl\Middleware\ExampleRouteMiddleware::class,
    ];

    /**
     * The policy mappings for this plugin.
     *
     * @var array<string, string>
     */
    protected array $policies = [
        // \Azuriom\Plugin\Trackurl\Models\Link::class => \Azuriom\Plugin\Trackurl\Policies\LinkPolicy::class,
    ];

    /**
     * Register any plugin services.
     */
    public function register(): void
    {
        $this->registerMiddleware();
    }

    /**
     * Bootstrap any plugin services.
     */
    public function boot(): void
    {
        // $this->registerPolicies();

        $this->loadViews();

        $this->loadTranslations();

        $this->loadMigrations();

        $this->registerRouteDescriptions();

        $this->registerAdminNavigation();

        $this->registerUserNavigation();

        $this->registerActionLogs();

         $this->registerPermissions();
    }


    /**
     * Register the permissions for the plugin.
     */
    protected function registerPermissions(): void
    {
        Permission::registerPermissions([
            'trackurl.view' => 'trackurl::admin.permissions.view'
        ]);
    }

    /**
     * Register the action logs for this plugin.
     */
    protected function registerActionLogs(): void
    {
        // Register the Link model for standard CRUD logs
        ActionLog::registerLogModel(Link::class, 'trackurl::admin.logs');

        // Register custom actions for blocking/unblocking links
        ActionLog::registerLogs([
            'trackurl-links.blocked' => [
                'icon' => 'lock',
                'color' => 'danger',
                'message' => 'trackurl::admin.logs.links.blocked',
                'model' => Link::class,
            ],
            'trackurl-links.unblocked' => [
                'icon' => 'unlock',
                'color' => 'success',
                'message' => 'trackurl::admin.logs.links.unblocked',
                'model' => Link::class,
            ],
        ]);
    }

    /**
     * Returns the routes that should be able to be added to the navbar.
     *
     * @return array<string, string>
     */
    protected function routeDescriptions(): array
    {
        return [
            'trackurl.index' => trans('trackurl::messages.title')
        ];
    }

    /**
     * Return the admin navigations routes to register in the dashboard.
     *
     * @return array<string, array<string, string>>
     */
    protected function adminNavigation(): array
    {
        return [
            $this->plugin->id => [
                'name' => trans($this->plugin->id."::admin.plugin.name"),
                'type' => 'dropdown',
                'icon' => 'bi-link',
                'route' => $this->plugin->id.'.admin.*',
                'permission' => 'trackurl.view',
                'items' => [
                    $this->plugin->id . '.admin.index' => trans($this->plugin->id.'::admin.links.title'),
                    $this->plugin->id . '.admin.create' => trans($this->plugin->id.'::admin.links.create'),
                ],
            ],
        ];
    }

    /**
     * Return the user navigations routes to register in the user menu.
     *
     * @return array<string, array<string, string>>
     */
    protected function userNavigation(): array
    {
        return [
            //
        ];
    }
}
