<?php

use Illuminate\Support\Facades\Route;
use Modules\Products\Http\Controllers\Admin\ProductController;

Route::name('admin.products.')->group(function () {
    Route::get('', [ProductController::class, 'index'])
        ->name('index');

    Route::get('/create', [ProductController::class, 'create'])
        ->name('create');

    Route::post('', [ProductController::class, 'store'])
        ->name('store');

    Route::get('/{id}/edit', [ProductController::class, 'edit'])
        ->name('edit');

    Route::put('/{id}', [ProductController::class, 'update'])
        ->name('update');

    Route::delete('/{id}', [ProductController::class, 'destroy'])
        ->name('destroy');

    Route::put('/{id}/restore', [ProductController::class, 'restore'])
        ->name('restore');
});
