<?php

use Azuriom\Plugin\Achievement\Controllers\Admin\ObjectiveController;
use Azuriom\Plugin\Achievement\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your plugin. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" and "admin" middleware groups. Now create a great admin panel!
|
*/

Route::get('/', function () {
    return redirect()->route('achievement.admin.objectives.index');
})->name('index');
Route::resource('objectives', ObjectiveController::class)->except('show');

Route::get('/settings', [SettingController::class, 'index'])->name('settings');
Route::post('/settings', [SettingController::class, 'save'])->name('settings.save');
Route::post('/settings/reset-all', [SettingController::class, 'resetAll'])->name('settings.reset-all');
Route::post('/settings/reset-player', [SettingController::class, 'resetPlayer'])->name('settings.reset-player');
