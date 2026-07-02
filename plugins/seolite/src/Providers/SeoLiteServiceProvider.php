<?php

namespace Azuriom\Plugin\SeoLite\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Models\Permission;
use Azuriom\Plugin\SeoLite\Support\NextPlanRegistry;
use Illuminate\Support\Facades\View;

class SeoLiteServiceProvider extends BasePluginServiceProvider
{
    /**
     * The plugin's global HTTP middleware stack.
     */
    protected array $middleware = [
//        InjectedBasicProvider::class
    ];

    /**
     * The plugin's route middleware groups.
     */
    protected array $middlewareGroups = [];

    /**
     * The plugin's route middleware.
     */
    protected array $routeMiddleware = [
        // 'example' => \Azuriom\Plugin\SeoLite\Middleware\ExampleRouteMiddleware::class,

    ];

    /**
     * The policy mappings for this plugin.
     *
     * @var array<string, string>
     */
    protected array $policies = [
        // User::class => UserPolicy::class,
    ];

    /**
     * Register any plugin services.
     */
    public function register(): void
    {
//         $this->registerMiddleware();

        //
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

        $this->registerPermissions();

        $this->sharePlanFeatures();

        $this->registerDisplaySystem();
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
                'name' => trans($this->plugin->id.'::messages.admin_dashboard'),
                'type' => 'dropdown',
                'icon' => 'bi bi-search-heart',
                'route' => $this->plugin->id.'.admin.*',
                'permission' => 'seolite.view',
                'items' => [
                    $this->plugin->id . '.admin.index' => trans($this->plugin->id.'::messages.admin_dashboard'),
                    $this->plugin->id . '.admin.analyses.index' => trans($this->plugin->id.'::messages.analyses'),
                    $this->plugin->id . '.admin.analyses.articles' => trans($this->plugin->id.'::messages.articles'),
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

    /**
     * Register the permissions for the plugin.
     */
    protected function registerPermissions(): void
    {
        Permission::registerPermissions([
            'seolite.view' => 'seolite::admin.permissions.view',
        ]);
    }

    /**
     * Share SeoLite plan features across plugin views.
     */
    protected function sharePlanFeatures(): void
    {
        View::composer('seolite::*', function ($view) {
            $view->with('seoLiteNextPlans', NextPlanRegistry::all());
            $view->with('seoLiteNextPlansByPlan', NextPlanRegistry::grouped());
        });
    }


    /**
     * Register the display system to inject across all themes.
     */
    protected function registerDisplaySystem(): void
    {
        $layoutPatterns = [
            '*layouts.base',
        ];

        foreach ($layoutPatterns as $pattern) {
            View::composer($pattern, function ($view) {
                $this->injectDisplay($view);
            });
        }
    }

    /**
     * Inject display into a view.
     */
    protected function injectDisplay($view): void
    {
        if (!$view->offsetExists('seoDisplayXInjected')) {
            $view->with('seoDisplayXInjected', true);
            $display = view('seolite::components.providers.seolite')->render();
            $view->with('seoDisplayXInjected', $display);
        }
    }

}
