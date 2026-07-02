<?php

use Azuriom\Plugin\DailyReward\Controllers\Admin\ClaimController;
use Azuriom\Plugin\DailyReward\Controllers\Admin\DayController;
use Azuriom\Plugin\DailyReward\Controllers\Admin\RewardController;
use Azuriom\Plugin\DailyReward\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

Route::middleware('can:daily-reward.settings')->group(function () {
    Route::get('/', [SettingController::class, 'show'])->name('settings');
    Route::post('/', [SettingController::class, 'save'])->name('settings.save');
});

Route::middleware('can:daily-reward.days')->group(function () {
    Route::resource('days', DayController::class)->except('show');
});

Route::middleware('can:daily-reward.rewards')->group(function () {
    Route::resource('rewards', RewardController::class)->except('show');
});

Route::middleware('can:daily-reward.logs')->group(function () {
    Route::get('/claims', [ClaimController::class, 'index'])->name('claims.index');
});
