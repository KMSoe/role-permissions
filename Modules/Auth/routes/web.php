<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::name('auth.')->group(function () {
    Route::get('/login', 'AuthController@login')->name('login');
    Route::post('/login', 'AuthController@storeLogin')->name('login.store');

    Route::get('/register', 'AuthController@register')->name('register');
    Route::post('/register', 'AuthController@storeRegister')->name('register.store');

    Route::get('/users/{id}/email-verify', 'AuthController@emailVerify')->name('email.verify');
    Route::post('/email-verify', 'AuthController@storeEmailVerify')->name('email.verify.store'); 

    // Forgot Password
    Route::get('/forgot-password', 'AuthController@forgotPassword')->name('forgot.password');
    Route::post('/forgot-password', 'AuthController@storeForgotPassword')->name('forgot.password.store');

    Route::post('/logout', 'AuthController@logout')->name('logout');

    Route::get('/change-password', 'AuthController@getChangePassword')->name('change.password');
    Route::post('/change-password', 'AuthController@storeChangePassword')->name('change.password.store');

    //Google
    Route::get('/login/google', 'AuthController@redirectToGoogle')->name('login.google');
    Route::get('/login/google/callback', 'AuthController@handleGoogleCallback');

    //Facebook
    Route::get('/login/facebook', 'AuthController@redirectToFacebook')->name('login.facebook');
    Route::get('/login/facebook/callback', 'AuthController@handleFacebookCallback');
});
