<?php

use Illuminate\Support\Facades\Route;
use App\Controllers\ResourceController;
use App\Controllers\ResourcesCategoryController;

Route::middleware(['api'])->group( function () {
    Route::controller([ResourceController::class])->group( function () {
        Route::middleware(['has.permission:4,1'])->group( function () {
            Route::get('/{organization_id}/resources/', 'index');
            Route::get('/{organization_id}/resources/{id}', 'retrieve');
        });
        Route::middleware(['has.permission:4,2'])->group( function () {
            Route::post('/{organization_id}/resources/', 'create');
            Route::put('/{organization_id}/resources/{id}', 'update');
            Route::delete('/{organization_id}/resources/{id}', 'destroy');
        });
    });
    Route::controller([ResourcesCategoryController::class])->group( function () {
        Route::middleware(['has.permission:4,1'])->group( function () {
            Route::get('/{organization_id}/resources_categories/', 'index');
            Route::get('/{organization_id}/resources_categories/{id}', 'retrieve');
        });
        Route::middleware(['has.permission:4,2'])->group( function () {
            Route::post('/{organization_id}/resources_categories/', 'create');
            Route::put('/{organization_id}/resources_categories/{id}', 'update');
            Route::delete('/{organization_id}/resources_categories/{id}', 'destroy');
        });
    });
});