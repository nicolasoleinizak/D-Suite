<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;

Route::middleware(['api'])->group( function () {
    Route::controller(IncomeController::class)->group( function () {
        Route::get('/{organization_id}/incomes/{after?}{before?}', 'index');
    });
    Route::controller(ExpenseController::class)->group( function () {

    });
});