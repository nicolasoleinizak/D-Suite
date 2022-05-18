<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LicenseController;

Route::controller(LicenseController::class)->group( function () {
    Route::middleware(['is.superadmin'])->group( function () {
        Route::put('{organization_id}/licenses/{module_id}', 'update');
    });
});