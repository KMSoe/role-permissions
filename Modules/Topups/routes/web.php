<?php

use Illuminate\Support\Facades\Route;
use Modules\Topups\Http\Controllers\TopupController;

Route::name('topups.')->group(function () {
    Route::get('', [TopupController::class, 'index'])
        ->name('index');

    Route::get('/create', [TopupController::class, 'create'])
        ->name('create');

    Route::post('', [TopupController::class, 'store'])
        ->name('store');

    Route::get('/{key}', [TopupController::class, 'show'])
        ->name('show');
});
