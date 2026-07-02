<?php

namespace Tests\Concerns;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

trait BootsHuntPluginForTests
{
    private static bool $huntAutoloadRegistered = false;

    protected function bootHuntPluginForTests(): void
    {
        $this->registerHuntAutoload();
        $this->runHuntMigrations();
        $this->registerHuntClaimRoute();
    }

    private function registerHuntAutoload(): void
    {
        if (self::$huntAutoloadRegistered) {
            return;
        }

        spl_autoload_register(function (string $class): void {
            $prefix = 'Azuriom\\Plugin\\Hunt\\';

            if (! str_starts_with($class, $prefix)) {
                return;
            }

            $relative = str_replace('\\', '/', substr($class, strlen($prefix)));
            $path = base_path('plugins/hunt/src/'.$relative.'.php');

            if (is_file($path)) {
                require_once $path;
            }
        });

        self::$huntAutoloadRegistered = true;
    }

    private function runHuntMigrations(): void
    {
        Artisan::call('migrate', [
            '--path' => base_path('plugins/hunt/database/migrations'),
            '--realpath' => true,
        ]);
    }

    private function registerHuntClaimRoute(): void
    {
        if (Route::has('test.hunt.claim')) {
            return;
        }

        Route::middleware('web')
            ->post('/hunt/claim', [\Azuriom\Plugin\Hunt\Controllers\HuntController::class, 'claim'])
            ->name('test.hunt.claim');
    }
}

