<?php

namespace App\Libraries\PriceHandle;
use App\Models\PriceMaker;

class PricesChecker{
    private $affected_price_makers = [];
    private $updated_items_identifiers = [];
    private $cycle;
    private $organization_id;

    /**
     * It takes an array of updated items, an organization id, and a cycle (optional) and returns an
     * array of price makers that are affected by the updated items
     * 
     * @param updated_items An array of objects that have been updated.
     * @param organization_id The id of the organization that the price maker belongs to.
     * @param cycle the cycle that the price maker is in
     */
    public function __construct ($updated_items, $organization_id, $cycle = '') {
        $this->organization_id = $organization_id;
        if($cycle == ''){
            $this->cycle = rand(0,10000);
        } else {
            $this->cycle = $cycle;
        }
        foreach($updated_items as $updated_item){
            $identifier = '%#'.$updated_item['class'].':'.$updated_item['id'].'%';
            array_push($this->updated_items_identifiers, $identifier);
        }
        foreach($this->updated_items_identifiers as $identifier){
            $formulas = PriceMaker::where([
                ['organization_id', '=', $this->organization_id],
                ['formula', 'like', $identifier]
            ])->get();
            foreach($formulas as $formula){
                if(!in_array($formula, $this->affected_price_makers)){
                    array_push($this->affected_price_makers, $formula);
                }
            }
        }
    }

    public function update () {
        try {
            if(count($this->affected_price_makers)>0){
                $price_updater = new PricesUpdater($this->affected_price_makers, $this->cycle, $this->organization_id);
                $price_updater->update();
            } else {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
    }
}