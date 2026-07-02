<?php

use Illuminate\Support\Facades\Route;
use Azuriom\Plugin\SpinWheel\Controllers\Api\ApiController;
use Azuriom\Plugin\SpinWheel\Controllers\SpinWheelHomeController;

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
Route::get('/', [SpinWheelHomeController::class, 'index'])->name('index');
Route::get('/rewards', [ApiController::class, 'index'])->name("rewards");

Route::middleware(['can:spin-wheel.user', 'auth'])->group(function () {
    Route::get('/check', [ApiController::class, 'check'])->name("check");
    Route::get('/play', [ApiController::class, 'play'])->name("play");
});  