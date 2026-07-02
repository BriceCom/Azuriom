<?php

use Azuriom\Plugin\Tebex\Resources\Currencies;

/*
|--------------------------------------------------------------------------
| Helper functions
|--------------------------------------------------------------------------
|
| Here is where you can register helpers for your plugin. These
| functions are loaded by Composer and are globally available on the app !
| Just make sure you verify that a function doesn't exist before registering it
| to prevent any side effect.
|
*/

if (! function_exists('tebex_currency_symbol')) {
    function tebex_currency_symbol(string $currency = null)
    {
        return Currencies::symbol($currency ?? "USD");
    }
}

if (! function_exists('tebex_format_amount')) {
    /**
     * Format the given amount with the active currency.
     * Falls back to shop_format_amount if available.
     */
    function tebex_format_amount(float $amount, string $currency = null): string
    {
        if (function_exists('shop_format_amount')) {
            return shop_format_amount($amount);
        }

        return Currencies::formatAmount($amount, $currency ?? "USD");
    }
}
