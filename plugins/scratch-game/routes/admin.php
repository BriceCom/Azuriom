<?php

use Azuriom\Plugin\ScratchGame\Controllers\Admin\CardController;
use Azuriom\Plugin\ScratchGame\Controllers\Admin\LogController;
use Azuriom\Plugin\ScratchGame\Controllers\Admin\RewardController;
use Azuriom\Plugin\ScratchGame\Controllers\Admin\SettingsController;
use Illuminate\Support\Facades\Route;

Route::middleware('can:scratch-game.admin')->group(function () {
    Route::get('/', function () {
        return redirect()->route('scratch-game.admin.cards.index');
    })->name('index');

    Route::resource('cards', CardController::class)->except('show');
    Route::post('/cards/{card}/toggle-enabled', [CardController::class, 'toggleEnabled'])->name('cards.toggleEnabled');

    Route::resource('rewards', RewardController::class)->except('show');
    Route::post('/rewards/{reward}/toggle-enabled', [RewardController::class, 'toggleEnabled'])->name('rewards.toggleEnabled');

    Route::get('/logs', [LogController::class, 'index'])->name('logs.index');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
});
