<?php

use Azuriom\Plugin\AlternativeCurrency\Controllers\Admin\CoinsController;
use Azuriom\Plugin\AlternativeCurrency\Controllers\Admin\GiveController;
use Azuriom\Plugin\AlternativeCurrency\Controllers\Admin\HistoryController;
use Azuriom\Plugin\AlternativeCurrency\Controllers\Admin\SettingsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your plugin. These
| routes are loaded by the RouteServiceProvider of your plugin within
| a group which contains the "web" middleware group and your plugin name
| as prefix. Now create something great!
|
*/

Route::middleware('can:alternative-currency.all')->group(function () {
    Route::resource('coins', CoinsController::class)->except('show');
    Route::resource('give', GiveController::class)->except('show');
    Route::get('history', [HistoryController::class, 'index'])->name('history.index');
    Route::resource('setting', SettingsController::class)->except('show');
});
