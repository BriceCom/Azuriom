<?php

namespace Azuriom\Plugin\Cron\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Models\Permission;

class CronServiceProvider extends BasePluginServiceProvider
{
    /**
     * The plugin's global HTTP middleware stack.
     *
     * @var array
     */
    protected array $middleware = [
        //
    ];

    /**
     * The plugin's route middleware groups.
     *
     * @var array
     */
    protected array $middlewareGroups = [
        //
    ];

    /**
     * The plugin's route middleware.
     *
     * @var array
     */
    protected array $routeMiddleware = [
        //
    ];

    /**
     * The policy mappings for this plugin.
     *
     * @var array
     */
    protected array $policies = [
    ];

    /**
     * Register any plugin services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any plugin services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViews();

        $this->loadTranslations();

        $this->loadMigrations();

        $this->registerRouteDescriptions();

        $this->registerAdminNavigation();

        $this->registerUserNavigation();

        $this->registerPermissions();
    }

    protected function registerPermissions()
    {
        Permission::registerPermissions([
            'cron.admin' => 'cron::messages.admin.permission',
        ]);
    }

    /**
     * Returns the routes that should be able to be added to the navbar.
     *
     * @return array
     */
    protected function routeDescriptions(): array
    {
        return [
            //
        ];
    }

    /**
     * Return the admin navigations routes to register in the dashboard.
     *
     * @return array
     */
    protected function adminNavigation(): array
    {
        return [
            'cron' => [
                'name' => trans('cron::messages.admin.title'),
                'icon' => 'bi bi-clock',
                'route' => 'cron.admin.index',
                'permission' => 'cron.admin',
            ],
        ];
    }
}
