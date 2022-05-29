<?php 

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Libraries\PriceCalculator;

Route::middleware(['api'])->group( function () {
    Route::post('/{organization_id}/price_calculator/', function(Request $request){
        return PriceCalculator::parse($request->formula, $request->organization_id);
    });
});