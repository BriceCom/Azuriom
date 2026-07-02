<?php

namespace Azuriom\Plugin\AlternativeCurrency\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Models\Permission;

class AlternativeCurrencyServiceProvider extends BasePluginServiceProvider
{
    /**
     * The plugin's global HTTP middleware stack.
     */
    protected array $middleware = [];

    /**
     * The plugin's route middleware groups.
     */
    protected array $middlewareGroups = [
        'api' => [
            \Azuriom\Plugin\AlternativeCurrency\Middleware\VerifyApiToken::class,
        ],
    ];

    /**
     * The plugin's route middleware.
     */
    protected array $routeMiddleware = [];

    /**
     * The policy mappings for this plugin.
     *
     * @var array<string, string>
     */
    protected array $policies = [];

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

        Permission::registerPermissions([
            $this->plugin->id.'.admin' => $this->plugin->id.'::admin.permissions.admin',
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
            //
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
                'icon' => 'bi-coin',
                'permission' => $this->plugin->id.'.admin',
                'route' => $this->plugin->id.'.admin.*',
                'items' => [
                    $this->plugin->id.'.admin.setting.index' => "Paramètres",
                    $this->plugin->id.'.admin.coins.index' => "Coins",
                    $this->plugin->id.'.admin.give.index' => "Donner des coins",
                    $this->plugin->id.'.admin.history.index' => "Historique",
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
