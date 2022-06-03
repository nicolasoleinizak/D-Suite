<?php

namespace App\Libraries\PriceHandle;
use App\Models\Resource;
use App\Models\PriceModifier;
use App\Models\PriceMaker;
use Webit\Util\EvalMath\EvalMath;
use App\Exceptions\BadFormulaException;

// REMPLAZAR FORMATO [PRODUCT:1] por #Product:1#

class PriceCalculator{
    public static function parse (string $formula, $organization_id) {
        $parsed_formula = preg_replace_callback('/\#\w+:\d+/', function ($i) use ($organization_id) {
            if(preg_match('/\#(Resource):(\d+)/', $i[0], $matches)){
                $price_modifier = Resource::where([
                    'organization_id' => $organization_id,
                    'id' => $matches[2]
                ])->first();
                if($price_modifier){
                    return $price_modifier->price;
                } else {
                    throw new BadFormulaException('Error in some resource reference');
                }
            }
            else if(preg_match('/\#(Product):(\d+)/', $i[0], $matches)){
                $price_modifier = PriceMaker::where([
                    'organization_id' => $organization_id,
                    'id' => $matches[2]
                ])->first();
                if($price_modifier){
                    return $price_modifier->result;
                } else {
                    throw new BadFormulaException('Error in some product reference');
                }
            }
            else if(preg_match('/\#(PriceModifier):(\d+)/', $i[0], $matches)){
                $price_modifier = PriceModifier::where([
                    'organization_id' => $organization_id,
                    'id' => $matches[2]
                ])->first();
                if($price_modifier){
                    return $price_modifier->value;
                } else {
                    throw new BadFormulaException('Error in some price modifier reference');
                }
            }
        }, $formula);
        $m = new EvalMath;
        return $m->evaluate($parsed_formula);
    }
}