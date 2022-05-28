<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ExpenseController;

Route::middleware(['api'])->group( function () {
    Route::controller(IncomeController::class)->group( function () {
        Route::get('/{organization_id}/incomes/{id}', 'retrieve');
        Route::get('/{organization_id}/incomes/{after?}{before?}{page?}{limit?}', 'index');
        Route::post('/{organization_id}/incomes/', 'create');
        Route::put('/{organization_id}/incomes/{id}', 'update');
        Route::delete('/{organization_id}/incomes/{id}', 'destroy');
    });
    Route::controller(ExpenseController::class)->group( function () {
        Route::get('/{organization_id}/expenses/{id}', 'retrieve');
        Route::get('/{organization_id}/expenses/{after?}{before?}{page?}{limit?}', 'index');
        Route::post('/{organization_id}/expenses/', 'create');
        Route::put('/{organization_id}/expenses/{id}', 'update');
        Route::delete('/{organization_id}/expenses/{id}', 'destroy');
    });
});