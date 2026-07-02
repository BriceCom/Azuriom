<?php

namespace Azuriom\Plugin\FreeKassa\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Plugin\FreeKassa\FreeKassaMethod;

class FreeKassaServiceProvider extends BasePluginServiceProvider
{
    /**
     * Register any plugin services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any plugin services.
     *
     * @return void
     */
    public function boot()
    {

        $this->loadViews();

        $this->loadTranslations();

        payment_manager()->registerPaymentMethod('freekassa', FreeKassaMethod::class);
    }
}
