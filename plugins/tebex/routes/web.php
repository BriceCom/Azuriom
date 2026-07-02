<?php

use Illuminate\Support\Facades\Route;
use Azuriom\Plugin\Tebex\Controllers\TebexHomeController;
use Azuriom\Plugin\Tebex\Controllers\CartController;

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
Route::get('/categories/{id}', [TebexHomeController::class, 'show'])->name('categories.show');

Route::prefix('cart')->name('cart.')->group(function () {

    Route::get('/', [CartController::class, 'show'])->name('show');
    Route::delete('/', [CartController::class, 'clear'])->name('clear');
    Route::post('/username', [CartController::class, 'setUsername'])->name('username');

    Route::post('/auth', [CartController::class, 'auth'])->name('auth');
    Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');

    Route::get('/payment-complete', [CartController::class, 'paymentComplete'])->name('payment.complete');
    Route::get('/payment-failed', [CartController::class, 'paymentFailed'])->name('payment.failed');
});

Route::prefix('packages')->name('packages.')->group(function() {

    Route::post('/', [CartController::class, 'add'])->name('add');
    Route::put('/', [CartController::class, 'update'])->name('update');
    Route::delete('/', [CartController::class, 'remove'])->name('remove');
});
