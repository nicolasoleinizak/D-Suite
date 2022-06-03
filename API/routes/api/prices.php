<?php 

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Libraries\PriceHandle\PriceCalculator;
use App\Http\Controllers\PriceMakerController;

Route::middleware(['api'])->group( function () {
    Route::post('/{organization_id}/price_calculator/', function(Request $request){
        return PriceCalculator::parse($request->formula, $request->organization_id);
    });
    Route::controller(PriceMakerController::class)->group( function () {
        Route::middleware(['has.permission:7,1'])->group( function () {
            Route::get('/{organization_id}/price_maker/{id}', 'retrieve');
        });
        Route::middleware(['has.permission:7,2'])->group( function () {
            Route::post('/{organization_id}/price_maker/', 'create');
            Route::put('/{organization_id}/price_maker/{id}', 'update');
        });
    });
});