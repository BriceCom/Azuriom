<?php

namespace Azuriom\Plugin\DedipassPayment\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Plugin\DedipassPayment\DediPassMethod;

class DedipassPaymentServiceProvider extends BasePluginServiceProvider
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

        payment_manager()->registerPaymentMethod('dedipass', DediPassMethod::class);
    }
}
