<?php

use Illuminate\Support\Facades\Route;
use Modules\PopularProducts\Http\Controllers\Admin\PopularProductController;

Route::name('admin.popular-products.')->group(function () {
    Route::get('', [PopularProductController::class, 'index'])
        ->name('index');

    Route::get('/create', [PopularProductController::class, 'create'])
        ->name('create');

    Route::post('', [PopularProductController::class, 'store'])
        ->name('store');

    Route::get('/{id}/edit', [PopularProductController::class, 'edit'])
        ->name('edit');

    Route::put('/{id}', [PopularProductController::class, 'update'])
        ->name('update');

    Route::delete('/{id}', [PopularProductController::class, 'destroy'])
        ->name('destroy');

    Route::put('/{id}/restore', [PopularProductController::class, 'restore'])
        ->name('restore');
});
