<?php

use App\Http\Controllers\UserController;

Route::controller(UserController::class)->group(function(){
    Route::group([
        'middleware' => 'api',
        'namespace' => 'App\Http\Controllers',
    ], function(){
        Route::post('/user', 'getUserParameters');
        Route::post('/permissions/{organization_id}', 'getPermissions');
    });
    Route::post('/register', 'register');
});