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
            ])->select([
                'id', 'short_description', 'stock'
            ])->get();
            $resources = Resource::where([
                'organization_id' => $request->organization_id
            ])->select([
                'id', 'name', 'stock'
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
        try {
            echo $request->type;
            switch($request->type){
                case 'product':
                    $product = Product::where([
                        'organization_id' => $request->organization_id,
                        'id' => $request->id
                    ])->first();
                    if($product){
                        $product->stock = $request->stock;
                        if($product->save()){
                            return Jasonres::success('', $product);
                        } else {
                            return Jasonres::error('SRV001');
                        }
                    } else {
                        return Jasonres::error('REQ002');
                    }
                    break;
                case 'resource':
                    $resource = Resource::where([
                        'organization_id' => $request->organization_id,
                        'id' => $request->id
                    ])->first();
                    if($resource){
                        $resource->stock = $request->stock;
                        if($resource->save()){
                            return Jasonres::success('', $resource);
                        } else {
                            return Jasonres::error('SRV001');
                        }
                    } else {
                        return Jasonres::error('REQ002');
                    }
                    break;
            }
        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }

    public function updateAll (Request $request) {
        try {
            foreach($request->items as $item){
                switch($item['type']){
                    case 'product':
                        $product = Product::where([
                            'organization_id' => $request->organization_id,
                            'id' => $item['id']
                        ])->first();
                        if($product){
                            $product->stock = $item['stock'];
                            if($product->save()){
                            } else {
                                return Jasonres::error('SRV001');
                            }
                        } else {
                            return Jasonres::error('REQ002');
                        }
                        break;
                    case 'resource':
                        $resource = Resource::where([
                            'organization_id' => $request->organization_id,
                            'id' => $item['id']
                        ])->first();
                        if($resource){
                            $resource->stock = $item['stock'];
                            if($resource->save()){
                            } else {
                                return Jasonres::error('SRV001');
                            }
                        } else {
                            return Jasonres::error('REQ002');
                        }
                        break;
                }
            }
            return Jasonres::success('Items stock successfully updated');
        } catch (Exception $e){
            return Jasonres::error('SRV001');
        }
    }
}
