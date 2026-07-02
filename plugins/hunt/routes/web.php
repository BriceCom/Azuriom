<?php

use Azuriom\Plugin\Hunt\Controllers\HuntController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here you can register all web routes for the hunt plugin.
|
*/

Route::get('/', [HuntController::class, 'index'])->name('home');
Route::get('/data', [HuntController::class, 'getHuntData'])->name('data');
Route::post('/claim', [HuntController::class, 'claim'])->name('claim');
Route::get('/{hunt}', [HuntController::class, 'show'])->name('show');
