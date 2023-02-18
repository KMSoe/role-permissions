<?php

use Illuminate\Support\Facades\Route;

Route::name('auth.')->group(function() {
    Route::post('/login-with-email', 'AuthController@loginWithEmail');
    Route::post('/login-with-phone', 'AuthController@loginWithPhone');
    Route::post('/register', 'AuthController@register');
    Route::post('/logout', 'AuthController@logout')->middleware(['auth:api']);
    Route::get('/user', 'AuthController@getUser')->middleware(['auth:api']);
    // Route::delete('/delete', 'AuthController@deleteUser')->middleware(['auth:api']);

    // SMS otp verify
    // Route::post('/sms-verify', 'AuthController@phoneOtpVerify');

    // Route::post('/change-password', 'AuthController@changePassword')->middleware(['auth:api']);

    //Google
    // Route::get('/login/google', 'AuthController@redirectToGoogle');
    // Route::get('/login/google/callback', 'AuthController@handleGoogleCallback');
    
    //Facebook
    // Route::get('/login/facebook', 'AuthController@redirectToFacebook');
    // Route::get('/login/facebook/callback', 'AuthController@handleFacebookCallback');
});