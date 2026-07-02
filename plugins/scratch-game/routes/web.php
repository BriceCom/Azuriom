<?php

use Azuriom\Plugin\ScratchGame\Controllers\ScratchGameController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ScratchGameController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/history', [ScratchGameController::class, 'history'])->name('history');
    Route::post('/play/{card}', [ScratchGameController::class, 'play'])->name('play');
    Route::get('/result/{log}', [ScratchGameController::class, 'result'])->name('result');
    Route::post('/result/{log}/claim', [ScratchGameController::class, 'claim'])->name('claim');
});
