<?php

use Azuriom\Plugin\DailyReward\Controllers\DailyRewardController;
use Azuriom\Plugin\DailyReward\Controllers\LeaderboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DailyRewardController::class, 'index'])->name('index');
Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');

Route::middleware('auth')->group(function () {
    Route::post('/claim', [DailyRewardController::class, 'claim'])->name('claim');
});
