<?php

use Azuriom\Plugin\FAQ\Controllers\Admin\QuestionAttachmentController;
use Azuriom\Plugin\FAQ\Controllers\Admin\QuestionController;
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

Route::middleware('can:faq.admin')->group(function () {
    Route::post('questions/update-position', [QuestionController::class, 'updateOrder'])->name('questions.update-order');
    Route::resource('questions', QuestionController::class)->except('show');
    Route::resource('questions.attachments', QuestionAttachmentController::class)->only('store');

    Route::prefix('questions/attachments')->name('questions.attachments.')->group(function () {
        Route::post('/{pendingId}', [QuestionAttachmentController::class, 'pending'])->name('pending');
    });
});
