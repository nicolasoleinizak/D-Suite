<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrganizationController;

Route::controller(OrganizationController::class)->group( function () {
    Route::middleware(['api'])->group(function () {
        Route::post('organizations/', 'create');
        Route::middleware('has.permission:1,1')->group( function () {
            Route::get('organizations/{organization_id}', 'retrieve');
        });
        Route::middleware('has.permission:1,2')->group( function () {
            Route::put('organizations/{organization_id}', 'update');
            Route::delete('organizations/{organization_id}', 'destroy');
        });
        Route::middleware('is.superadmin')->group( function () {
            Route::get('organizations/', 'index');
        });
    });
});
