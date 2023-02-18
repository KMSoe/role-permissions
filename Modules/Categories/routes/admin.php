<?php

use Illuminate\Support\Facades\Route;
use Modules\Categories\Http\Controllers\Admin\CategoryController;

Route::name('admin.categories.')->group(function () {
    Route::get('', [CategoryController::class, 'index'])
        ->name('index');

    Route::get('/create', [CategoryController::class, 'create'])
        ->name('create');

    Route::post('', [CategoryController::class, 'store'])
        ->name('store');

    Route::get('/{id}/edit', [CategoryController::class, 'edit'])
        ->name('edit');

    Route::put('/{id}', [CategoryController::class, 'update'])
        ->name('update');

    Route::delete('/{id}', [CategoryController::class, 'destroy'])
        ->name('destroy');

    Route::put('/{id}/restore', [CategoryController::class, 'restore'])
        ->name('restore');
});
