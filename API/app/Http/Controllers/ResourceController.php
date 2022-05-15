<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libraries\Jasonres;
use App\Models\Resource;

class ResourceController extends Controller
{
    public function index(Request $request){
        if(isset($request->organization_id)){
            $resources = Resource::where([
                'organization_id' => $request->organization_id,
            ])->with('categories')->get();
            return Jasonres::sendData($resources);
        } else {
            return Jasonres::error('REQ001');
        }
    }

    public function retrieve(Request $request){
        try{
            $resource = Resource::where([
                'organization_id' => $request->organization_id,
                'id' => $request->id
            ])->with('categories')->first();
            return Jasonres::sendData($resource);
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
            if(isset($categories)){
                $resource->assignCategories($categories);
            }
            $resource->save();
            return Jasonres::success($resource);
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

            $resource->name = isset($request->name)? $request->name : $resource->name;
            $resource->price = isset($request->price)? $request->price : $resource->price;
            $resource->unit = isset($request->unit)? $request->unit : $resource->unit;
            if(isset($request->categories)){
                $resource->assignCategories($request->categories);
            }
            $resource->save();

            return Jasonres::success('Data successfully updated', $resource);

        } catch(Exception $e){
            return Jasonres::error('SRV001');
        }
    }

    public function destroy(Request $request){
        try{
            Resource::where([
                'organization_id' => $request->organization_id,
                'id' => $request->id
            ])->delete();
            return Jasonres::success('Item successfully deleted');
        } catch (Exception $e){
            return Jasonres::error('SRV001');
        }
    }
}
