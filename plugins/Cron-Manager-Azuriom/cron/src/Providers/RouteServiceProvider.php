<?php

namespace Azuriom\Plugin\Cron\Providers;

use Azuriom\Extensions\Plugin\BaseRouteServiceProvider;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode;
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends BaseRouteServiceProvider
{
    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function loadRoutes()
    {
        Route::prefix($this->plugin->id)
            ->withoutMiddleware([
                PreventRequestsDuringMaintenance::class,
                CheckForMaintenanceMode::class,
            ])
            ->name($this->plugin->id . '.')
            ->group(plugin_path($this->plugin->id . '/routes/web.php'));

        Route::middleware('admin-access')
            ->prefix('admin/'.$this->plugin->id)
            ->name($this->plugin->id.'.admin.')
            ->group(plugin_path($this->plugin->id.'/routes/admin.php'));
    }
}
