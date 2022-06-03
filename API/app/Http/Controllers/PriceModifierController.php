<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PriceModifier;
use App\Libraries\Jasonres;

class PriceModifierController extends Controller
{
    public function index (Request $request) {
        try {
            $price_modifiers = PriceModifier::where([
                'organization_id' => $request->organization_id
            ])->get();
            if($price_modifiers){
                return Jasonres::success('', $price_modifiers);
            } else {
                return Jasonres::error('REQ002');
            }
        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }

    public function retrieve (Request $request) {
        try {
            $price_modifier = PriceModifier::where([
                'organization_id' => $request->organization_id,
                'id' => $request->id
            ])->first();
            if($price_modifier){
                return Jasonres::success('', $price_modifier);
            } else {
                return Jasonres::error('REQ002');
            }
        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }

    public function create (Request $request) {
        try {
            $request->validate([
                'description' => 'required|string',
                'type' => 'required|string',
                'value' => 'numeric|required'
            ]);
            $price_modifier = new PriceModifier;
            $price_modifier->description = $request->description;
            $price_modifier->type = $request->type;
            $price_modifier->value = $request->value;
            $price_modifier->organization_id = $request->organization_id;
            if($price_modifier->save()){
                return Jasonres::success('Price modifier successfully created', $price_modifier);
            } else {
                return Jasonres::error('SRV001');
            }
        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }

    public function update (Request $request) {
        try {
            $price_modifier = PriceModifier::where([
                'organization_id' => $request->organization_id,
                'id' => $request->id
            ])->first();
            if($price_modifier){
                $price_modifier->description = isset($request->description)
                    ? $request->description 
                    : $price_modifier->description;
                $price_modifier->type = isset($request->type)
                    ? $request->type 
                    : $price_modifier->type;
                $price_modifier->value = isset($request->value)
                    ? $request->value 
                    : $price_modifier->value;
                if($price_modifier->save()){
                    return Jasonres::success('', $price_modifier);
                } else {
                    return Jasonress::error('SRV001');
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
            $price_modifier = PriceModifier::where([
                'organization_id' => $request->organization_id,
                'id' => $request->id
            ]);
            if($price_modifier->delete()){
                return Jasonres::success('Price modifier successfully deleted');
            } else {
                return Jasonres::error('SRV001');
            }
        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }
}
