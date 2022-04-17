<?php

use Illuminate\Support\Facades\Route;

Route::group([

    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',

], function ($router) {

    Route::post('/login', 'AuthController@login');
    Route::post('/me', 'AuthController@me');
    Route::post('/user', 'UserController@get');

});