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
    
            if($resources){
                return Jasonres::success('', $resources);
            } else {
                return Jasonres::error('REQ002');
            }
        } else {
            return Jasonres::error('REQ001');
        }
    }

    public function retrieve(Request $request){
        $resource = Resource::where([
            'organization_id' => $request->organization_id,
            'id' => $request->id
        ])->with('categories')->first();

        if($resource){
            return Jasonres::success('', $resource);
        } else {
            return Jasonres::error('SRV001');
        }
    }

    public function create(Request $request){
        try{
            $resource = new Resource;
            $resource->name = $request->name;
            $resource->price = $request->price;
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
        $resource = Resource::where([
            'organization_id' => $request->organization_id,
            'id' => $request->id
        ]);

        //COMPLETE...
    }
}
