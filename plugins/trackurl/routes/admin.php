<?php

use Azuriom\Plugin\Trackurl\Controllers\Admin\LinkController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your plugin. These
| routes are loaded by the RouteServiceProvider of your plugin within
| a group which contains the "admin" middleware group and your plugin name
| as prefix. Now create something great!
|
*/

Route::get('/', [LinkController::class, 'index'])->name('index');
Route::get('/create', [LinkController::class, 'create'])->name('create');
Route::post('/create', [LinkController::class, 'store'])->name('store');
Route::get('/{link}/edit', [LinkController::class, 'edit'])->name('edit');
Route::post('/{link}/update', [LinkController::class, 'update'])->name('update');
Route::delete('/{link}/delete', [LinkController::class, 'destroy'])->name('destroy');
Route::get('/{link}/stats', [LinkController::class, 'stats'])->name('stats');
Route::post('/{link}/toggle-block', [LinkController::class, 'toggleBlock'])->name('toggle-block');
