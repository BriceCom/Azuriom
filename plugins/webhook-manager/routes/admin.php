<?php

use Azuriom\Plugin\WebhookManager\Controllers\Admin\LogController;
use Azuriom\Plugin\WebhookManager\Controllers\Admin\WebhookController;
use Azuriom\Plugin\WebhookManager\Controllers\Admin\WebhookServiceController;
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

Route::middleware('can:webhook-manager.admin')->group(function () {
    Route::redirect('/', '/admin/webhook-manager/webhooks')->name('index');

    Route::resource('services', WebhookServiceController::class)->except('show');

    Route::resource('webhooks', WebhookController::class)->except('show');
    Route::post('webhooks/{webhook}/test', [WebhookController::class, 'test'])
        ->name('webhooks.test');

    Route::get('logs', [LogController::class, 'index'])
        ->name('logs.index');
});
