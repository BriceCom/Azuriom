<?php

use Azuriom\Plugin\Suggest\Controllers\Admin\CategoryController;
use Azuriom\Plugin\Suggest\Controllers\Admin\DiscordController;
use Azuriom\Plugin\Suggest\Controllers\Admin\SettingController;
use Azuriom\Plugin\Suggest\Controllers\Admin\StatisticsController;
use Azuriom\Plugin\Suggest\Controllers\Admin\SuggestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your plugin. These
| routes are loaded by the RouteServiceProvider of your plugin within
| a group which contains the "admin" middleware group and your plugin name
| as prefix. Now create something great!
|
*/

Route::get('/', [SuggestController::class, 'index'])->name('index');
Route::get('/archive', [SuggestController::class, 'archive'])->name('archive');
Route::get('/{suggestion}/edit', [SuggestController::class, 'edit'])->name('edit');
Route::post('/{suggestion}/update', [SuggestController::class, 'update'])->name('update');
Route::delete('/{suggestion}/delete', [SuggestController::class, 'destroy'])->name('destroy');
Route::post('/{suggestion}/status', [SuggestController::class, 'updateStatus'])->name('status.update');

// Categories routes
Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::get('/create', [CategoryController::class, 'create'])->name('create');
    Route::post('/create', [CategoryController::class, 'store'])->name('store');
    Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
    Route::post('/{category}/update', [CategoryController::class, 'update'])->name('update');
    Route::delete('/{category}/delete', [CategoryController::class, 'destroy'])->name('destroy');
});

// Settings routes
Route::middleware('can:suggest.settings')->prefix('settings')->group(function () {
    Route::get('/', [SettingController::class, 'show'])->name('settings');
    Route::post('/', [SettingController::class, 'save'])->name('settings.save');
});

// Discord webhook routes
Route::middleware('can:suggest.settings')->prefix('discord')->name('discord.')->group(function () {
    Route::get('/', [DiscordController::class, 'show'])->name('index');
    Route::post('/', [DiscordController::class, 'save'])->name('save');
    Route::post('/test', [DiscordController::class, 'test'])->name('test');
});

// Statistics routes
Route::middleware('can:suggest.settings')->group(function () {
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics');
});
