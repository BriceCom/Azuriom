<?php

namespace Azuriom\Plugin\Tasks\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Models\Permission;

class TasksServiceProvider extends BasePluginServiceProvider
{
    /**
     * The plugin's global HTTP middleware stack.
     */
    protected array $middleware = [
        // \Azuriom\Plugin\Tasks\Middleware\ExampleMiddleware::class,
    ];

    /**
     * The plugin's route middleware groups.
     */
    protected array $middlewareGroups = [];

    /**
     * The plugin's route middleware.
     */
    protected array $routeMiddleware = [
        // 'example' => \Azuriom\Plugin\Tasks\Middleware\ExampleRouteMiddleware::class,
    ];

    /**
     * The policy mappings for this plugin.
     *
     * @var array<string, string>
     */
    protected array $policies = [
        // \Azuriom\Plugin\Tasks\Models\Task::class => \Azuriom\Plugin\Tasks\Policies\TaskPolicy::class,
    ];

    /**
     * Register any plugin services.
     */
    public function register(): void
    {
        // $this->registerMiddleware();

        // Register the Discord webhook service
        $this->app->singleton(\Azuriom\Plugin\Tasks\Services\DiscordWebhookService::class);
    }

    /**
     * Bootstrap any plugin services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        $this->loadViews();

        $this->loadTranslations();

        $this->loadMigrations();

        $this->registerRouteDescriptions();

        $this->registerAdminNavigation();

        $this->registerUserNavigation();

        $this->registerPermissions();
    }

    /**
     * Register the permissions for the plugin.
     */
    protected function registerPermissions(): void
    {
        Permission::registerPermissions([
            'tasks.view' => 'tasks::admin.permissions.view',
            'tasks.create' => 'tasks::admin.permissions.create',
            'tasks.update' => 'tasks::admin.permissions.update',
            'tasks.delete' => 'tasks::admin.permissions.delete',
            'tasks.settings' => 'tasks::admin.permissions.settings',
            'tasks.tags.create' => 'tasks::admin.permissions.tags.create',
            'tasks.statuses.create' => 'tasks::admin.permissions.statuses.create'
        ]);
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
            $this->plugin->id => [
                'name' => trans($this->plugin->id."::admin.plugin.name"),
                'type' => 'dropdown',
                'icon' => 'bi-list-task',
                'route' => $this->plugin->id.'.admin.*',
                'permission' => 'tasks.view',
                'items' => [
                    $this->plugin->id . '.admin.index' => trans($this->plugin->id.'::admin.index.title'),
                    $this->plugin->id . '.admin.create' => trans($this->plugin->id.'::admin.tasks.create'),
                    $this->plugin->id . '.admin.tags.index' => trans($this->plugin->id.'::admin.tags.title'),
                    $this->plugin->id . '.admin.statuses.index' => trans($this->plugin->id.'::admin.statuses.title'),
                    $this->plugin->id . '.admin.statistics' => [
                        'name' => trans($this->plugin->id.'::admin.statistics.name'),
                        'permission' => 'tasks.settings',
                    ],
                    $this->plugin->id . '.admin.settings' => [
                        'name' => trans($this->plugin->id.'::admin.settings.title'),
                        'permission' => 'tasks.settings',
                    ],
                    $this->plugin->id . '.admin.discord.index' => [
                        'name' => trans($this->plugin->id.'::admin.settings.discord.title'),
                        'permission' => 'tasks.settings',
                    ],
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
