<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrganizationController;

Route::controller(ProductController::class)->group( function () {
    Route::middleware(['api'])->group(function () {
        Route::middleware('has.permission:1,1')->group( function () {
            Route::get('organization/{id}', 'retrieve');
            Route::delete('organizacion/{id}', 'destroy');
        });
        Route::middleware('has.permission:1,2')->group( function () {
            Route::post('organization/', 'create');
            Route::put('organization/{id}', 'update');
        });
    });
});
