<?php

namespace Azuriom\Plugin\SpinWheel\Providers;

use Azuriom\Models\Permission;
use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Models\User;
use Azuriom\Plugin\SpinWheel\Observers\UserObserver;

class SpinWheelServiceProvider extends BasePluginServiceProvider
{
    /**
     * The plugin's global HTTP middleware stack.
     *
     * @var array
     */
    protected array $middleware = [
        // \Azuriom\Plugin\SpinWheel\Middleware\ExampleMiddleware::class,
    ];

    /**
     * The plugin's route middleware groups.
     *
     * @var array
     */
    protected array $middlewareGroups = [];

    /**
     * The plugin's route middleware.
     *
     * @var array
     */
    protected array $routeMiddleware = [
        // 'example' => \Azuriom\Plugin\SpinWheel\Middleware\ExampleRouteMiddleware::class,
    ];

    /**
     * The policy mappings for this plugin.
     *
     * @var array
     */
    protected array $policies = [
        // User::class => UserPolicy::class,
    ];

    /**
     * Register any plugin services.
     *
     * @return void
     */
    public function register()
    {
        // $this->registerMiddleware();

        //
    }

    /**
     * Bootstrap any plugin services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->registerPolicies();

        $this->loadViews();

        $this->loadTranslations();

        $this->loadMigrations();

        $this->registerRouteDescriptions();

        $this->registerAdminNavigation();

        $this->registerUserNavigation();

        Permission::registerPermissions([
            $this->plugin->id.'.admin' => $this->plugin->id.'::admin.permission.admin',
            $this->plugin->id.'.user' => $this->plugin->id.'::admin.permission.user',
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
            $this->plugin->id.'.index' => $this->plugin->id.'::admin.plugin.name',
        ];
    }



    /**
     * Return the admin navigations routes to register in the dashboard.
     *
     * @return array
     */
    protected function adminNavigation()
    {
        return [
            $this->plugin->id => [
                'name' => trans($this->plugin->id."::admin.plugin.name"),
                'type' => 'dropdown',
                'icon' => 'bi-award',
                'route' => $this->plugin->id.'.admin.*',
                'permission' => $this->plugin->id.'.admin',
                'items' => [
                    $this->plugin->id . '.admin.settings.index' => trans('spin-wheel::admin.pages.settings.title'),
                    $this->plugin->id . '.admin.statistics.index' => trans('spin-wheel::admin.pages.statistics.title'),
                    $this->plugin->id . '.admin.rewards.index' => trans('spin-wheel::admin.pages.rewards.index.title'),
                ],
            ],
        ];
    }
}
