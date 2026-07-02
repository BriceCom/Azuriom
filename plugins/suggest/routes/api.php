<?php

use Azuriom\Plugin\Suggest\Controllers\Api\CommentController;
use Azuriom\Plugin\Suggest\Controllers\Api\SuggestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your plugin. These
| routes are loaded by the RouteServiceProvider of your plugin within
| a group which contains the "api" middleware group and your plugin name
| as prefix. Now create something great!
|
*/

Route::get('/', [SuggestController::class, 'index']);
Route::get('/{suggestion}', [SuggestController::class, 'show']);

Route::middleware('auth:web')->group(function () {
    Route::post('/{suggestion}/vote', [SuggestController::class, 'vote']);
    Route::post('/{suggestion}/unvote', [SuggestController::class, 'unvote']);

    Route::post('/{suggestion}/comments/{comment}/vote', [CommentController::class, 'vote']);
    Route::post('/{suggestion}/comments/{comment}/unvote', [CommentController::class, 'unvote']);
});
