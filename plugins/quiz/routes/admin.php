<?php

use Azuriom\Plugin\Quiz\Controllers\Admin\AdminController;
use Azuriom\Plugin\Quiz\Controllers\Admin\QuestionController;
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

Route::middleware('can:quiz.admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::resource('questions', QuestionController::class)->except('show');
    Route::get('/settings', [AdminController::class, 'showSettings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'saveSettings'])->name('settings.save');
});
