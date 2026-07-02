<?php

use Azuriom\Plugin\Suggest\Controllers\SuggestController;
use Azuriom\Plugin\Suggest\Controllers\SuggestionCommentController;
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

Route::get('/', [SuggestController::class, 'index'])->name('index');

Route::middleware('auth')->group(function () {
    Route::get('/create', [SuggestController::class, 'create'])->name('create');
    Route::post('/create', [SuggestController::class, 'store'])->name('store');

    Route::post('/{suggestion}/comments', [SuggestionCommentController::class, 'store'])->name('comments.store');
    Route::delete('/{suggestion}/comments/{comment}', [SuggestionCommentController::class, 'destroy'])->name('comments.destroy');

    Route::post('/{suggestion}/comments/{comment}/vote', [SuggestionCommentController::class, 'vote'])->name('comments.vote');
    Route::post('/{suggestion}/comments/{comment}/unvote', [SuggestionCommentController::class, 'unvote'])->name('comments.unvote');

    Route::delete('/{suggestion}/delete', [SuggestController::class, 'destroy'])->name('destroy');
    Route::post('/{suggestion}/update', [SuggestController::class, 'update'])->name('update');

    Route::post('/{suggestion}/vote', [SuggestController::class, 'vote'])->name('vote');
    Route::post('/{suggestion}/unvote', [SuggestController::class, 'unvote'])->name('unvote');
});

Route::get('/{suggestion}', [SuggestController::class, 'show'])->name('show');
