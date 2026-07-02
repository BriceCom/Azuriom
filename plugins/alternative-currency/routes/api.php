<?php

use Azuriom\Plugin\AlternativeCurrency\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user/{id}', [ApiController::class, 'getMoneyOfUser']);

Route::post('/coin/add', [ApiController::class, 'addCoinToUser']);
Route::get('/coin/{id}', [ApiController::class, 'getCoin']);
