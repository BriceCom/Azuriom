<?php

namespace Azuriom\Plugin\Suggest\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Models\Permission;
use Azuriom\Plugin\Suggest\Models\Suggestion;
use Azuriom\Plugin\Suggest\Observers\SuggestionObserver;

class SuggestServiceProvider extends BasePluginServiceProvider
{
    /**
     * The plugin's global HTTP middleware stack.
     */
    protected array $middleware = [
        // \Azuriom\Plugin\Suggest\Middleware\ExampleMiddleware::class,
    ];

    /**
     * The plugin's route middleware groups.
     */
    protected array $middlewareGroups = [];

    /**
     * The plugin's route middleware.
     */
    protected array $routeMiddleware = [
        // 'example' => \Azuriom\Plugin\Suggest\Middleware\ExampleRouteMiddleware::class,
    ];

    /**
     * The policy mappings for this plugin.
     *
     * @var array<string, string>
     */
    protected array $policies = [
        \Azuriom\Plugin\Suggest\Models\Suggestion::class => \Azuriom\Plugin\Suggest\Policies\SuggestionPolicy::class,
        \Azuriom\Plugin\Suggest\Models\SuggestionComment::class => \Azuriom\Plugin\Suggest\Policies\SuggestionCommentPolicy::class,
    ];

    /**
     * Register any plugin services.
     */
    public function register(): void
    {
        // $this->registerMiddleware();

        //
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


    protected function registerPermissions()
    {
        Permission::registerPermissions([
            'suggest.delete' => 'suggest::admin.permissions.delete',
            'suggest.edit' => 'suggest::admin.permissions.edit',
            'suggest.settings' => 'suggest::admin.permissions.settings',
            'suggest.comments.delete' => 'suggest::admin.permissions.comments.delete'
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
            'suggest.index' => trans('suggest::messages.title')
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
                'icon' => 'bi-lightbulb',
                'route' => $this->plugin->id.'.admin.*',
                'items' => [
                    $this->plugin->id . '.admin.index' => trans($this->plugin->id.'::admin.index.title'),
                    $this->plugin->id . '.admin.categories.index' => trans($this->plugin->id.'::admin.categories.title'),
                    $this->plugin->id . '.admin.statistics' => [
                        'name' => trans($this->plugin->id.'::admin.statistics.title'),
                        'permission' => 'suggest.settings',
                    ],
                    $this->plugin->id . '.admin.discord.index' => [
                        'name' => trans($this->plugin->id.'::admin.discord.title'),
                        'permission' => 'suggest.settings',
                    ],
                    $this->plugin->id . '.admin.settings' => [
                        'name' => trans($this->plugin->id.'::admin.settings.title'),
                        'permission' => 'suggest.settings',
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
