<?php

use Illuminate\Support\Facades\Route;
use Modules\Articles\Http\Controllers\Admin\ArticleController;

Route::name('admin.articles.')->group(function () {
    Route::get('', [ArticleController::class, 'index'])
        ->name('index');

    Route::get('/create', [ArticleController::class, 'create'])
        ->name('create');

    Route::post('', [ArticleController::class, 'store'])
        ->name('store');

    Route::get('/{id}/edit', [ArticleController::class, 'edit'])
        ->name('edit');

    Route::put('/{id}', [ArticleController::class, 'update'])
        ->name('update');

    Route::delete('/{id}', [ArticleController::class, 'destroy'])
        ->name('destroy');

    Route::put('/{id}/restore', [ArticleController::class, 'restore'])
        ->name('restore');
});
