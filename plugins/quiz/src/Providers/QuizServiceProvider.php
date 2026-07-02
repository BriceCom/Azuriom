<?php

namespace Azuriom\Plugin\Quiz\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;

class QuizServiceProvider extends BasePluginServiceProvider
{
    /**
     * The plugin's global HTTP middleware stack.
     */
    protected array $middleware = [
        // \Azuriom\Plugin\Quiz\Middleware\ExampleMiddleware::class,
    ];

    /**
     * The plugin's route middleware groups.
     */
    protected array $middlewareGroups = [];

    /**
     * The plugin's route middleware.
     */
    protected array $routeMiddleware = [
        // 'example' => \Azuriom\Plugin\Quiz\Middleware\ExampleRouteMiddleware::class,
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
        // $this->registerMiddleware();

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
    }

    /**
     * Register the plugin's permissions.
     */
    protected function registerPermissions(): void
    {
        \Azuriom\Models\Permission::registerPermissions([
            'quiz.admin' => 'quiz::admin.permissions.admin',
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
            'quiz.home' => 'quiz::messages.title',
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
            'quiz' => [
                'name' => 'quiz::admin.title',
                'type' => 'dropdown',
                'icon' => 'bi bi-question-circle',
                'items' => [
                    'quiz.admin.questions.index' => 'quiz::admin.questions.title',
                    'quiz.admin.settings' => 'quiz::admin.settings.title',
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
