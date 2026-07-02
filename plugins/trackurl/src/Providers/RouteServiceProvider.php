<?php

namespace Azuriom\Plugin\Trackurl\Providers;

use Azuriom\Extensions\Plugin\BaseRouteServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends BaseRouteServiceProvider
{
    /**
     * Define the routes for the application.
     */
    public function loadRoutes(): void
    {
        Route::middleware('web')
            ->prefix($this->plugin->id)
            ->name($this->plugin->id.'.')
            ->group(plugin_path($this->plugin->id.'/routes/web.php'));

        Route::middleware('admin-access')
            ->prefix('admin/'.$this->plugin->id)
            ->name($this->plugin->id.'.admin.')
            ->group(plugin_path($this->plugin->id.'/routes/admin.php'));

        Route::middleware(['web', 'api'])
            ->prefix('api/'.$this->plugin->id)
            ->name($this->plugin->id.'.api.')
            ->group(plugin_path($this->plugin->id.'/routes/api.php'));
    }
}
