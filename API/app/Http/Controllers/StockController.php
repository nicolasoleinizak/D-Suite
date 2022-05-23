<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libraries\Jasonres;
use App\Models\Product;
use App\Models\Resource;

class StockController extends Controller
{
    public function index(Request $request){
        try {

            $products = Product::where([
                'organization_id' => $request->organization_id
            ])->get();
            $resources = Resource::where([
                'organization_id' => $request->organization_id
            ])->get();
            if($products && $resources){
                $items = [];
                foreach($products as $product){
                    array_push(
                        $items, 
                        [
                            ...$product->toArray(),
                            'type' => 'product'
                    ]);
                }
                foreach($resources as $resource){
                    array_push(
                        $items,
                        [
                            ...$resource->toArray(),
                            'type' => 'resource'
                        ]
                        );
                }
                return Jasonres::success('', $items);
            } else {
                return Jasonres::error('REQ002');
            }
        } catch (Exception $e){
            return Jasonres::error('SRV001');
        }
    }

    public function retrieve(Request $request){
        try {

            $item = null;
            switch($request->type){
                case 'product':
                    $item = Product::where([
                        'organization_id' => $request->organization_id,
                        'id' => $request->id
                    ])->first();
                    break;
                case 'resource':
                    $item = Resource::where([
                        'organization_id' => $request->organization_id,
                        'id' => $request->id
                    ])->first();
                    break;
            }
            if($item){
                return Jasonres::success('', $item);
            } else {
                return Jasonres::error('REQ002');
            }
        } catch (Exception $e){
            return Jasonres::error('SRV001');
        }
    }

    public function update(Request $request){
        
    }
}
