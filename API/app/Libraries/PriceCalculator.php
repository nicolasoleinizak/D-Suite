<?php

namespace App\Libraries;
use App\Models\Resource;
use App\Models\PriceModifier;
use App\Models\Product;
use Webit\Util\EvalMath\EvalMath;

class PriceCalculator{
    public static function parse (string $formula, $organization_id) {
        $parsed_formula = preg_replace_callback('/\[\w+:\d+]/', function ($i) use ($organization_id) {
            if(preg_match('/\[(Resource):(\d+)\]/', $i[0], $matches)){
                return Resource::where([
                    'organization_id' => $organization_id,
                    'id' => $matches[2]
                ])->first()->price;
            }
            else if(preg_match('/\[(Product):(\d+)\]/', $i[0], $matches)){
                return Product::where([
                    'organization_id' => $organization_id,
                    'id' => $matches[2]
                ])->first()->price;
            }
            else if(preg_match('/\[(PriceModifier):(\d+)\]/', $i[0], $matches)){
                return PriceModifier::where([
                    'organization_id' => $organization_id,
                    'id' => $matches[2]
                ])->first()->value;
            }
        }, $formula);
        $m = new EvalMath;
        return $m->evaluate($parsed_formula);
    }
}