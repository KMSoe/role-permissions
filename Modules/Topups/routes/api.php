<?php

use Illuminate\Support\Facades\Route;
use Modules\Topups\Http\Controllers\Api\TopupController;

Route::name('api.topups.')->group(function () {
    Route::get('', [TopupController::class, 'index'])
        ->name('index');

    Route::get('/{key}', [TopupController::class, 'show'])
        ->name('show');

    Route::get('/create', [TopupController::class, 'create'])
        ->name('create');

    Route::post('', [TopupController::class, 'store'])
        ->name('store');
});
