<?php

namespace Azuriom\Plugin\Hunt\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Models\ActionLog;
use Azuriom\Models\Permission;
use Azuriom\Plugin\Hunt\Models\Hunt;
use Azuriom\Plugin\Hunt\Models\HuntLog;
use Azuriom\Plugin\Hunt\Models\HuntReward;
use Illuminate\Support\Facades\View;

class HuntServiceProvider extends BasePluginServiceProvider
{
    /**
     * Register any plugin services.
     */
    public function register(): void
    {
        //
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
            'hunt.admin' => 'hunt::admin.permission',
        ]);

        ActionLog::registerLogModels([
            Hunt::class,
            HuntReward::class,
            HuntLog::class,
        ], 'hunt::admin.logs');

        ActionLog::registerLogs('hunt.settings.updated', [
            'icon' => 'search',
            'color' => 'info',
            'message' => 'hunt::admin.logs.settings',
        ]);

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
            'hunt.home' => 'hunt::messages.title',
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
            'hunt' => [
                'name' => trans('hunt::admin.nav.title'),
                'type' => 'dropdown',
                'icon' => 'bi bi-gift',
                'route' => 'hunt.admin.*',
                'permission' => 'hunt.admin',
                'items' => [
                    'hunt.admin.hunts.index' => trans('hunt::admin.nav.hunts'),
                    'hunt.admin.rewards.index' => trans('hunt::admin.nav.rewards'),
                    'hunt.admin.logs.index' => trans('hunt::admin.nav.logs'),
                    'hunt.admin.settings.index' => trans('hunt::admin.nav.settings'),
                ],
            ],
        ];
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
        if (!$this->shouldDisplay()) {
            return;
        }

        $currentHunt = Hunt::getCurrentHunt();
        if (!$currentHunt) {
            return;
        }

        if (!$view->offsetExists('huntDisplayInjected')) {
            $view->with('huntDisplayInjected', true);
            $display = view('hunt::partials._hunt_display')->render();
            $view->with('huntDisplayContent', $display);
        }
    }

    /**
     * Check if hunt should be displayed based on current route and settings.
     */
    protected function shouldDisplay(): bool
    {
        return \Azuriom\Plugin\Hunt\Controllers\Admin\SettingsController::shouldDisplayHunt(request()->getPathInfo());
    }

}
