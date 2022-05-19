<?php

use App\Http\Controllers\UserController;

Route::controller(UserController::class)->group(function(){

    Route::middleware(['api']) ->group( function () {
        Route::post('/me', 'getUserInfo');
        Route::get('me/permissions/{organization_id}', 'getPermissions');
    });

    Route::post('/register', 'register');

    Route::middleware(['has.permission:1,2'])->group(function(){
        Route::put('/permissions', 'updatePermissions');
    });
    
});