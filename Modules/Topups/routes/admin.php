<?php

use Illuminate\Support\Facades\Route;
use Modules\Topups\Http\Controllers\Admin\TopupController;

Route::name('admin.topups.')->group(function () {
    Route::get('', [TopupController::class, 'index'])
        ->name('index');

    Route::get('/{key}', [TopupController::class, 'show'])
        ->name('show');

    Route::post('/{id}/finish', [TopupController::class, 'finishTopup'])
        ->name('finishTopup');
});
