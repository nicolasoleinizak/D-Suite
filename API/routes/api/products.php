<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;

Route::controller(ProductController::class)->group(function(){
    /**
     * The 'api' middlewares requires an authenticated user
     * The 'has.permissions' middleware requires two parameters with two points separation:
     * - The id of the module to access
     * - The level of access required (1 for reading, 2 for writing, or 0 for no permission req. -no recomended)
     */
    Route::middleware(['api', 'has.permission:2,1'])->group(function () {
        Route::get('/{organization_id}/products', 'index');
        Route::get('/{organization_id}/products/{product_id}', 'retrieve');
    });
});