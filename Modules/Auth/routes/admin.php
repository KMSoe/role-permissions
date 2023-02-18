<?php

use Illuminate\Support\Facades\Route;

Route::name('admin.auth.')->group(function () {
    Route::get('/', 'AuthController@index')->name('index');
    Route::post('/', 'AuthController@store')->name('store');
    Route::get('/create', 'AuthController@create')->name('create');

    Route::get('/{auth}/edit', 'AuthController@edit')
        ->name('edit');

    Route::put('/{auth}', 'AuthController@update')
        ->name('update');

    Route::delete('/{auth}', 'AuthController@destroy')
        ->name('destroy');

    Route::put('/{auth}/restore', 'AuthController@restore')
        ->name('restore');
});
