<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PriceModifierController;

Route::middleware(['api'])->group( function () {
    Route::controller(PriceModifierController::class)->group( function () {
        Route::middleware(['has.permission:7,1'])->group( function () {
            Route::get('/{organization_id}/price_modifiers/', 'index');
            Route::get('/{organization_id}/price_modifiers/{id}', 'retrieve');
        });
        Route::middleware(['has.permission:7,2'])->group( function () {
            Route::post('/{organization_id}/price_modifiers/', 'create');
            Route::delete('/{organization_id}/price_modifiers/{id}', 'destroy');
            Route::put('/{organization_id}/price_modifiers/{id}', 'update');
        });
    });
});