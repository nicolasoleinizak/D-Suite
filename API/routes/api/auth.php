<?php

use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function(){

    Route::group([
    
        'middleware' => 'api',
        'namespace' => 'App\Http\Controllers',

    ], function ($router) {

        Route::post('/login', 'login');
        Route::post('/me', 'me');
        Route::post('/logout', 'logout');

    });
});