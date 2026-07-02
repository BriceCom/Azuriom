<?php

use Azuriom\Plugin\SpinWheel\Models\Laps;
use Illuminate\Support\Carbon;


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
 
if (! function_exists('displayPercentage')) { 
    function displayPercentage() {
        return setting('spin.homePercentage', true);
    }    
}
