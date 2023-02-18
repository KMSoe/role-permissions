<?php

use Illuminate\Support\Facades\Route;

use Modules\Articles\Http\Controllers\ArticleController;

Route::name('articles.')->group(function () {
    Route::get('', [ArticleController::class, 'index'])
        ->name('index');

    Route::get('{slug}', [ArticleController::class, 'show'])
        ->name('index');
});