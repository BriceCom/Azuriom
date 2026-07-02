<?php

use Azuriom\Plugin\Tasks\Controllers\Admin\AdminController;
use Azuriom\Plugin\Tasks\Controllers\Admin\TagController;
use Azuriom\Plugin\Tasks\Controllers\Admin\StatusController;
use Azuriom\Plugin\Tasks\Controllers\Admin\SettingController;
use Azuriom\Plugin\Tasks\Controllers\Admin\StatisticsController;
use Azuriom\Plugin\Tasks\Controllers\Admin\DiscordController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your plugin. These
| routes are loaded by the RouteServiceProvider of your plugin within
| a group which contains the "web" and "admin" middleware groups and
| your plugin name as prefix. Now create something great!
|
*/

// Main task routes
Route::middleware('can:tasks.view')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
});
Route::middleware('can:tasks.create')->group(function () {
    Route::get('/create', [AdminController::class, 'create'])->name('create');
    Route::post('/create', [AdminController::class, 'store'])->name('store');
});

// Tags routes
Route::prefix('tags')->name('tags.')->group(function () {
    Route::get('/', [TagController::class, 'index'])->name('index');

    // Tag creation routes
    Route::middleware('can:tasks.tags.create')->group(function () {
        Route::get('/create', [TagController::class, 'create'])->name('create');
        Route::post('/create', [TagController::class, 'store'])->name('store');
    });

    // Tag update routes
    Route::middleware('can:tasks.update')->group(function () {
        Route::get('/{tag}/edit', [TagController::class, 'edit'])->name('edit');
        Route::post('/{tag}/update', [TagController::class, 'update'])->name('update');
    });

    // Tag deletion route
    Route::middleware('can:tasks.delete')->group(function () {
        Route::delete('/{tag}/delete', [TagController::class, 'destroy'])->name('destroy');
    });
});

// Statuses routes
Route::prefix('statuses')->name('statuses.')->group(function () {
    Route::get('/', [StatusController::class, 'index'])->name('index');

    // Status creation routes
    Route::middleware('can:tasks.statuses.create')->group(function () {
        Route::get('/create', [StatusController::class, 'create'])->name('create');
        Route::post('/create', [StatusController::class, 'store'])->name('store');
    });

    // Status update routes
    Route::middleware('can:tasks.update')->group(function () {
        Route::get('/{status}/edit', [StatusController::class, 'edit'])->name('edit');
        Route::post('/{status}/update', [StatusController::class, 'update'])->name('update');
    });

    // Status deletion route
    Route::middleware('can:tasks.delete')->group(function () {
        Route::delete('/{status}/delete', [StatusController::class, 'destroy'])->name('destroy');
    });
});

// Settings and statistics routes (require settings permission)
Route::middleware('can:tasks.settings')->group(function () {
    // Settings routes
    Route::get('/settings', [SettingController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

    // Discord webhook routes
    Route::prefix('discord')->name('discord.')->group(function () {
        Route::get('/', [DiscordController::class, 'index'])->name('index');
        Route::post('/', [DiscordController::class, 'update'])->name('update');
        Route::post('/test', [DiscordController::class, 'testWebhook'])->name('test');
    });

    // Statistics route
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics');
});


// Task view route
Route::middleware('can:tasks.view')->group(function () {
    Route::get('/{id}', [AdminController::class, 'show'])->name('show');
});

// Task management routes (require update permission)
Route::middleware('can:tasks.update')->group(function () {
    Route::get('/{task}/edit', [AdminController::class, 'edit'])->name('edit');
    Route::post('/{task}/update', [AdminController::class, 'update'])->name('update');
    Route::post('/{task}/status', [AdminController::class, 'updateStatus'])->name('status.update');

    // Checklist routes
    Route::post('/{task}/checklist/create', [AdminController::class, 'storeChecklist'])->name('checklist.store');
    Route::post('/{task}/checklist/{checklist}/update', [AdminController::class, 'updateChecklist'])->name('checklist.update');
    Route::delete('/{task}/checklist/{checklist}/delete', [AdminController::class, 'destroyChecklist'])->name('checklist.destroy');

    // Assignee routes
    Route::post('/{task}/assignee/add', [AdminController::class, 'addAssignee'])->name('assignee.add');
    Route::delete('/{task}/assignee/{user}/remove', [AdminController::class, 'removeAssignee'])->name('assignee.remove');

    // Comment routes
    Route::post('/{task}/comment/create', [AdminController::class, 'storeComment'])->name('comment.store');
    Route::post('/{task}/comment/{comment}/update', [AdminController::class, 'updateComment'])->name('comment.update');
    Route::delete('/{task}/comment/{comment}/delete', [AdminController::class, 'destroyComment'])->name('comment.destroy');
});

// Task deletion and restoration routes
Route::middleware('can:tasks.delete')->group(function () {
    Route::delete('/{task}/delete', [AdminController::class, 'destroy'])->name('destroy');
    Route::post('/{id}/restore', [AdminController::class, 'restore'])->name('restore');
    Route::delete('/{id}/force-delete', [AdminController::class, 'forceDelete'])->name('force-delete');
});
