<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libraries\Jasonres;
use App\Models\Resource;

class ResourceController extends Controller
{
    public function index(Request $request){
        try {
                $resources = Resource::where([
                    'organization_id' => $request->organization_id,
                ])->with('categories')->get();

                if($resources){
                    return Jasonres::success('', $resources);
                } else {
                    return Jasonres::error('REQ002');
                }
            } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }

    public function retrieve(Request $request){
        try{
            $resource = Resource::where([
                'organization_id' => $request->organization_id,
                'id' => $request->id
            ])->with('categories')->first();

            if($resource){
                return Jasonres::success('', $resource);
            } else {
                return Jasonres::error('REQ002');
            }
        } catch(Exception $e){
            return Jasronres::error('SRV001');
        }
    }

    public function create(Request $request){
        try{
            $validationData = $request->validate([
                'name' => 'required|string',
                'price' => 'numeric',
                'unit' => 'required|string',
                'categories' => 'array'
            ]);
            $resource = new Resource;
            $resource->name = $request->name;
            $resource->price = isset($request->price)? $request->price : 0;
            $resource->unit = $request->unit;
            $resource->organization_id = $request->organization_id;
            if($resource->save()){
                if(isset($categories)){
                    if($resource->assignCategories($categories)){
                        return Jasonres::success('', $resource);
                    }
                } else {
                    return Jasonres::success('', $resource);
                }
            } else {
                return Jasonres::error('SRV001');
            }
        } catch(Exception $e) {
            return Jasonres::error('SRV001');
        }
    }

    public function update(Request $request){
        try{
            $resource = Resource::where([
                'organization_id' => $request->organization_id,
                'id' => $request->id
            ])->first();
            
            if($resource){
                $resource->name = isset($request->name)? $request->name : $resource->name;
                $resource->price = isset($request->price)? $request->price : $resource->price;
                $resource->unit = isset($request->unit)? $request->unit : $resource->unit;
                if(isset($request->categories)){
                    $resource->assignCategories($request->categories);
                }
                if($resource->save()){
                    return Jasonres::success('Data successfully updated', $resource);
                } else {
                    return Jasonres::error('SRV001');
                }
            } else {
                return Jasonres::error('REQ002');
            }
        } catch(Exception $e){
            return Jasonres::error('SRV001');
        }
    }

    public function destroy(Request $request){
        try{
            $resource = Resource::where([
                'organization_id' => $request->organization_id,
                'id' => $request->id
            ]);
            if($resource->delete()){
                return Jasonres::success('Resource successfully deleted');
            } else {
                return Jasonres::error('SRV001');
            }
        } catch (Exception $e){
            return Jasonres::error('SRV001');
        }
    }
}
