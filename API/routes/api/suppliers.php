<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SupplierController;

Route::controller(SupplierController::class)->group(function(){

    /**
     * The 'api' middlewares requires an authenticated user
     * The 'has.permissions' middleware requires two parameters with two points separation:
     * - The id of the module to access
     * - The level of access required (1 for reading, 2 for writing, or 0 for no permission req. -not recomended)
     * This middlewares doesn't check if the product belongs to the specified organization, 
     * is important to check it on the controller
     */

    Route::middleware(['api'])->group(function () {
        Route::middleware(['has.permission:5,1'])->group(function () {
            Route::get('/{organization_id}/suppliers', 'index');
            Route::get('/{organization_id}/suppliers/{id}', 'retrieve');
        });
        Route::middleware(['has.permission:5,1'])->group(function () {
            Route::post('/{organization_id}/suppliers/', 'create');
            Route::put('/{organization_id}/suppliers/{id}', 'update');
            Route::delete('/{organization_id}/suppliers/{id}', 'destroy');
        });
    });
});