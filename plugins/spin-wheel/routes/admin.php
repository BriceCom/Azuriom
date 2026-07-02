<?php

use Illuminate\Support\Facades\Route;
use Azuriom\Plugin\SpinWheel\Controllers\Api\ApiController;
use Azuriom\Plugin\SpinWheel\Controllers\Admin\RewardsController;
use Azuriom\Plugin\SpinWheel\Controllers\Admin\SettingsController;
use Azuriom\Plugin\SpinWheel\Controllers\Admin\StatisticsController;

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

Route::middleware('can:spin-wheel.admin')->group(function () {
    Route::resource('settings', SettingsController::class);
    Route::resource('rewards', RewardsController::class);

    Route::get('statistics', [StatisticsController::class, 'index'])->name('statistics.index');
    Route::delete('statistics', [StatisticsController::class, 'destroy'])->name('statistics.destroy');

    Route::get('/webhook', [ApiController::class, 'sendWebhook'])->name("send-webhook");
});
