<?php

use Azuriom\Plugin\Achievement\Controllers\ObjectiveController;
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

Route::get('/', [ObjectiveController::class, 'index'])->name('home');
Route::get('/profile', [ObjectiveController::class, 'profile'])->middleware('auth')->name('profile');
Route::post('/objectives/{objective}/claim', [ObjectiveController::class, 'claimReward'])->middleware('auth')->name('objectives.claim');
