<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;

Route::controller(StockController::class)->group( function () {
    Route::middleware(['api'])->group( function () {
        Route::middleware(['has.permission:6,1'])->group( function () {
            Route::get('/{organization_id}/stock', 'index');
            Route::get('/{organization_id}/stock/{type}/{id}', 'retrieve');
        });
        Route::middleware(['has.permission:6,2'])->group( function () {
            Route::put('/{organization_id}/stock/{id}', 'update');
            Route::put('/{organization_id}/stock/', 'updateAll');
        });
    });
});