<?php

namespace Azuriom\Plugin\DailyReward\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Models\ActionLog;
use Azuriom\Models\Permission;
use Azuriom\Plugin\DailyReward\Models\DailyRewardDay;
use Azuriom\Plugin\DailyReward\Models\DailyRewardReward;

class DailyRewardServiceProvider extends BasePluginServiceProvider
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

        $this->registerUserNavigation();

        Permission::registerPermissions([
            'daily-reward.admin' => 'daily-reward::admin.permissions.admin',
            'daily-reward.settings' => 'daily-reward::admin.permissions.settings',
            'daily-reward.days' => 'daily-reward::admin.permissions.days',
            'daily-reward.rewards' => 'daily-reward::admin.permissions.rewards',
            'daily-reward.logs' => 'daily-reward::admin.permissions.logs',
        ]);

        ActionLog::registerLogModels([
            DailyRewardDay::class,
            DailyRewardReward::class,
        ], 'daily-reward::admin.logs');

        ActionLog::registerLogs([
            'daily-reward.settings.updated' => [
                'icon' => 'gift',
                'color' => 'info',
                'message' => 'daily-reward::admin.logs.settings.updated',
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
            'daily-reward.index' => trans('daily-reward::messages.title'),
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
            'daily-reward' => [
                'name' => trans('daily-reward::admin.nav.title'),
                'type' => 'dropdown',
                'icon' => 'bi bi-gift',
                'route' => 'daily-reward.admin.*',
                'permission' => 'daily-reward.admin',
                'items' => [
                    'daily-reward.admin.settings' => [
                        'name' => trans('daily-reward::admin.nav.settings'),
                        'permission' => 'daily-reward.settings',
                    ],
                    'daily-reward.admin.days.index' => [
                        'name' => trans('daily-reward::admin.nav.days'),
                        'permission' => 'daily-reward.days',
                    ],
                    'daily-reward.admin.rewards.index' => [
                        'name' => trans('daily-reward::admin.nav.rewards'),
                        'permission' => 'daily-reward.rewards',
                    ],
                    'daily-reward.admin.claims.index' => [
                        'name' => trans('daily-reward::admin.nav.claims'),
                        'permission' => 'daily-reward.logs',
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
            'daily-reward' => [
                'route' => 'daily-reward.index',
                'name' => trans('daily-reward::messages.title'),
                'icon' => 'bi bi-gift',
            ],
        ];
    }
}
