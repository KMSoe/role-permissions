<?php

use Illuminate\Support\Facades\Route;
use Modules\Products\Http\Controllers\ProductController;

Route::name('products.')->group(function () {
    Route::get('', [ProductController::class, 'index']);
    Route::get('/{slug}', [ProductController::class, 'show']);
});
