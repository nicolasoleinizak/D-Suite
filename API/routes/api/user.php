<?php

use App\Http\Controllers\UserController;

Route::controller(UserController::class)->group(function(){
    Route::middleware(['api']) ->group( function () {
        Route::post('/user', 'getUserParameters');
        Route::post('/permissions/{organization_id}', 'getPermissions');
    });
    Route::post('/register', 'register');
});