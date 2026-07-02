<?php

use Azuriom\Plugin\Quiz\Controllers\QuizHomeController;
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

Route::get('/', [QuizHomeController::class, 'index'])->name('home');
Route::post('/answer/{question}', [QuizHomeController::class, 'answer'])->name('answer')->middleware('auth');
Route::get('/leaderboard', [QuizHomeController::class, 'leaderboard'])->name('leaderboard');
