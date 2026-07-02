<?php

use Illuminate\Support\Facades\Route;
use Azuriom\Plugin\Tebex\Controllers\TebexHomeController;
use Azuriom\Plugin\Tebex\Controllers\CartController;
use Azuriom\Plugin\Tebex\Controllers\PackageController;

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

Route::get('/', [TebexHomeController::class, 'index'])->name('index');
Route::get('/categories/{category}', [TebexHomeController::class, 'category'])->name('category');

// Package routes
Route::resource('packages', PackageController::class)->only('show');

Route::prefix('packages/{package}')->name('packages.')->middleware('auth')->group(function () {
    Route::post('/buy', [PackageController::class, 'buy'])->name('buy');
    Route::get('/options', [PackageController::class, 'showVariables']);
    Route::post('/options', [PackageController::class, 'buy'])->name('variables');
});

// Cart routes
Route::prefix('cart')->name('cart.')->middleware('auth')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/', [CartController::class, 'update'])->name('update');
    Route::match(['GET', 'POST'], '/remove/{package}', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
    Route::post('/payment', [CartController::class, 'payment'])->name('payment');
    Route::post('/username', [CartController::class, 'updateUsername'])->name('username');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
});
