<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PriceMaker;
use App\Models\Product;
use App\Libraries\Jasonres;
use App\Libraries\PriceCalculator;

class PriceMakerController extends Controller
{
    public function retrieve (Request $request) {
        try {
            $price_maker = PriceMaker::where([
                'organization_id' => $request->organization_id,
                'id' => $request->id
            ])->first();
            if($price_maker){
                return Jasonres::success('', $price_maker);
            } else {
                return Jasonres::error('REQ002');
            }
        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }

    public function create (Request $request) {
        try {
            $price_maker = new PriceMaker;
            $product = Product::where([
                'organization_id' => $request->organization_id,
                'id' => $request->product_id
            ])->first();
            if($product){
                $price_maker->product_id = $product->id;
            } else {
                return Jasonres::error('REQ002');
            }
            $price_maker->description = $request->description;
            $price_maker->formula = $request->formula;
            $price_maker->result = PriceCalculator::parse($request->formula, $request->organization_id);
            $price_maker->organization_id = $request->organization_id;
            if($price_maker->save()){
                return Jasonres::success('Price maker successully created', $price_maker);
            } else {
                return Jasonres::error('SRV001');
            }
        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }

    public function update (Request $request) {
        try {
            $price_maker = PriceMaker::where([
                'organization_id' => $request->organization_id,
                'id' => $request->id
            ])->first();
            if($price_maker){
                $price_maker->description = isset($request->description)
                    ? $request->description
                    : $price_maker->description;
                if(isset($request->formula)){
                    $price_maker->formula = $request->formula;
                    $price_maker->result = PriceCalculator::parse($request->formula, $request->organization_id);
                }
                if(isset($request->product_id)){
                    $product = Product::where([
                        'organization_id' => $request->organization_id,
                        'id' => $request->product_id
                    ])->first();
                    if($product){
                        $price_maker->product_id = $product->id;
                    } else {
                        return Jasonres::error('REQ002');
                    }
                }
                if($price_maker->save()){
                    return Jasonres::success('Price maker successfully updated', $price_maker);
                } else {
                    return Jasonres::error('SRV001');
                }
            } else {
                return Jasonres::error('REQ002');
            }
        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }

    public function destroy (Request $request) {
        try {
            $price_maker = PriceMaker::where([
                'organization_id' => $request->organization_id,
                'id' => $request->id
            ]);
            if($price_maker->delete()){
                return Jasonres::success('Price maker successfully deleted');
            } else {
                return Jasonres::error('SRV001');
            }
        } catch ( Exception $e ) {
            return Jasonres::error('SRV001');
        }
    }
}
