<?php

use Illuminate\Support\Facades\Route;
use Modules\Transactions\Http\Controllers\TransactionController;

Route::name('transactions.')->group(function () {
    Route::get('', [TransactionController::class, 'index'])
        ->name('index');

    Route::get('/create', [TransactionController::class, 'create'])
        ->name('create');

    Route::post('', [TransactionController::class, 'store'])
        ->name('store');

    Route::get('/{key}', [TransactionController::class, 'show'])
        ->name('show');
});
