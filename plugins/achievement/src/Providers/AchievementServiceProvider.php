<?php

namespace Azuriom\Plugin\Achievement\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Models\Permission;
use Azuriom\Plugin\Achievement\Services\HookService;
use Azuriom\Plugin\Achievement\Services\ObjectiveService;

class AchievementServiceProvider extends BasePluginServiceProvider
{
    /**
     * Register any plugin services.
     */
    public function register(): void
    {
        $this->app->singleton(ObjectiveService::class);
        $this->app->singleton(HookService::class);
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

        $this->registerUserNavigation();

        $this->registerAdminNavigation();

//        $this->registerPermissions();
    }

    /**
     * Returns the routes that should be able to be added to the navbar.
     *
     * @return array<string, string>
     */
    protected function routeDescriptions(): array
    {
        return [
            'achievement.home' => 'achievement::messages.title',
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
            'achievement' => [
                'name' =>  trans('achievement::admin.nav.title'),
                'type' => 'dropdown',
                'icon' => 'bi bi-trophy',
                'route' => 'achievement.admin.*',
                'items' => [
                    'achievement.admin.objectives.index' => [
                        'name' => trans('achievement::admin.nav.objectives'),
                    ],
                    'achievement.admin.settings' => [
                        'name' => trans('achievement::admin.nav.settings'),
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
            'achievement' => [
                'route' => 'achievement.profile',
                'name' => trans('achievement::messages.profile.objectives'),
                'icon' => 'bi bi-trophy',
            ],
        ];
    }
}
