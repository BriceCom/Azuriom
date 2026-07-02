<?php

namespace Azuriom\Plugin\FAQ\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Models\Permission;
use Azuriom\Plugin\FAQ\Models\Question;
use Illuminate\Database\Eloquent\Relations\Relation;

class FAQServiceProvider extends BasePluginServiceProvider
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
            'faq.admin' => 'faq::admin.permission',
        ]);

        Relation::morphMap(['faq.questions' => Question::class]);
    }

    /**
     * Returns the routes that should be able to be added to the navbar.
     *
     * @return array<string, string>
     */
    protected function routeDescriptions(): array
    {
        return [
            'faq.index' => trans('faq::messages.title'),
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
            'faq' => [
                'name' => trans('faq::admin.title'),
                'icon' => 'bi bi-info-circle',
                'permission' => 'faq.admin',
                'route' => 'faq.admin.questions.index',
            ],
        ];
    }
}
