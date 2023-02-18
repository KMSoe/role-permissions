<?php

use Illuminate\Support\Facades\Route;
use Modules\Products\Http\Controllers\Api\ProductController;

Route::name('api.products.')->group(function () {
    Route::get('', [ProductController::class, 'index']);
    Route::get('/{slug}', [ProductController::class, 'show']);
});
