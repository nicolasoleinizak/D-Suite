<?php

namespace App\Libraries\PriceHandle;
use App\Models\PriceMaker;

class PricesUpdater{
    private $price_makers;
    private $affected_products;
    private $cycle;
    private $organization_id;

    public function __construct ($price_makers, $cycle, $organization_id) {
        $this->price_makers = $price_makers;
        $this->cycle = $cycle;
        $this->organization_id = $organization_id;
    }

    public function update(){
        $cursor = 0;
        $remaining_price_makers = $this->price_makers;
        while(count($remaining_price_makers) > 0){
            if($remaining_price_makers[$cursor]->last_eval_cycle == $this->cycle){
                array_splice($remaining_price_makers, $cursor, 1);
            } else {
                $is_calculable = $this->is_calculable($remaining_price_makers[$cursor]->formula);
                if($is_calculable){
                    $price = PriceCalculator::parse($remaining_price_makers[$cursor]->formula, $this->organization_id);
                    $price_maker = PriceMaker::find($remaining_price_makers[$cursor]->id);
                    $price_maker->result = $price;
                    $price_maker->save();
                    array_splice($remaining_price_makers, $cursor, 1);
                } else {
                    $cursor++;
                }
                if($cursor >= count($remaining_price_makers)){
                    $cursor = 0;
                }
            }
        }
        $price_makers_resume = [];
        foreach($this->price_makers as $maker){
            array_push($price_makers_resume, 
            [
                'class' => 'Product',
                'id' => $maker->id
            ]);
        }
        $prices_checker = new PricesChecker($price_makers_resume, $this->organization_id, $this->cycle);
        $prices_checker->update();
    }

    /*  Evaluates if a formula has some reference 
        that also must be calculated on this instance
    */
    private function is_calculable ($formula) {
        $product_ids = array_column($this->price_makers, 'product_id');
        $product_identifiers = array_map( function ($item) {
            return "#Product:".$item;
        }, $product_ids);
        foreach($product_identifiers as $product_identifier){
            if(preg_match('/'.$product_identifier.'/', $formula)){
                return false;
            }
        }
        return true;
    }
}