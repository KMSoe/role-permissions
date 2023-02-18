<?php

// Route::name()

use Illuminate\Support\Facades\Route;
use Modules\Banners\Http\Controllers\Admin\BannerController;

Route::name('admin.transactions.')->group(function () {
    Route::get('', [BannerController::class, 'index'])
        ->name('index');

    Route::delete('/{id}', [BannerController::class, 'destroy'])
        ->name('destroy');
});
