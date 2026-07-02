<?php

use Azuriom\Plugin\Hunt\Controllers\Admin\HuntController;
use Azuriom\Plugin\Hunt\Controllers\Admin\RewardController;
use Azuriom\Plugin\Hunt\Controllers\Admin\LogController;
use Azuriom\Plugin\Hunt\Controllers\Admin\SettingsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here you can register all admin routes for the hunt plugin.
|
*/

Route::get('/', [HuntController::class, 'index'])->name('hunts.index');
Route::get('/create', [HuntController::class, 'create'])->name('hunts.create');
Route::post('/', [HuntController::class, 'store'])->name('hunts.store');

Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
Route::get('/logs/statistics', [LogController::class, 'statistics'])->name('logs.statistics');
Route::get('/logs/{log}', [LogController::class, 'show'])->name('logs.show');

Route::resource('rewards', RewardController::class)->except('show');
Route::post('/rewards/bulk-toggle', [RewardController::class, 'bulkToggle'])->name('rewards.bulkToggle');
Route::post('/rewards/{reward}/toggle-enabled', [RewardController::class, 'toggleEnabled'])->name('rewards.toggleEnabled');
Route::post('/rewards/{reward}/clone', [RewardController::class, 'clone'])->name('rewards.clone');

Route::get('/settings', [SettingsController::class, 'show'])->name('settings.index');
Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');


Route::get('/{hunt}', [HuntController::class, 'show'])->name('hunts.show');
Route::get('/{hunt}/edit', [HuntController::class, 'edit'])->name('hunts.edit');
Route::put('/{hunt}', [HuntController::class, 'update'])->name('hunts.update');
Route::delete('/{hunt}', [HuntController::class, 'destroy'])->name('hunts.destroy');
Route::post('/{hunt}/archive', [HuntController::class, 'archive'])->name('hunts.archive');
Route::post('/{hunt}/restore', [HuntController::class, 'restore'])->name('hunts.restore');
