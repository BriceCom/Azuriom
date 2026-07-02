<?php

namespace Azuriom\Plugin\ScratchGame\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Models\ActionLog;
use Azuriom\Models\Permission;
use Azuriom\Plugin\ScratchGame\Models\ScratchCard;
use Azuriom\Plugin\ScratchGame\Models\ScratchLog;
use Azuriom\Plugin\ScratchGame\Models\ScratchReward;

class ScratchGameServiceProvider extends BasePluginServiceProvider
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
            'scratch-game.admin' => 'scratch-game::admin.permission',
        ]);

        ActionLog::registerLogModels([
            ScratchCard::class,
            ScratchReward::class,
            ScratchLog::class,
        ], 'scratch-game::admin.logs.title');
    }

    /**
     * Returns the routes that should be able to be added to the navbar.
     *
     * @return array<string, string>
     */
    protected function routeDescriptions(): array
    {
        return [
            'scratch-game.home' => 'scratch-game::messages.title',
        ];
    }

    /**
     * Return the admin navigations routes to register in the dashboard.
     *
     * @return array<string, array<string, mixed>>
     */
    protected function adminNavigation(): array
    {
        return [
            'scratch-game' => [
                'name' => trans('scratch-game::admin.nav.title'),
                'type' => 'dropdown',
                'icon' => 'bi bi-ticket-perforated',
                'route' => 'scratch-game.admin.*',
                'permission' => 'scratch-game.admin',
                'items' => [
                    'scratch-game.admin.cards.index' => trans('scratch-game::admin.nav.cards'),
                    'scratch-game.admin.rewards.index' => trans('scratch-game::admin.nav.rewards'),
                    'scratch-game.admin.logs.index' => trans('scratch-game::admin.nav.logs'),
                    'scratch-game.admin.settings.index' => trans('scratch-game::admin.nav.settings'),
                ],
            ],
        ];
    }
}
