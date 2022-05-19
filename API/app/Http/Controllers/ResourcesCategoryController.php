<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResourcesCategory;
use App\Libraries\JSONResponse;
use App\Libraries\Jasonres;

class ResourcesCategoryController extends Controller
{
    /**
     * It returns a JSON response of all the categories in the database
     * 
     * @param Request request The request object
     * 
     * @return A JSONResponse object.
     */
    public function index (Request $request) {

        try {
            $categories = ResourcesCategory::where([
                'organization_id' => $request->organization_id
            ])->get();
    
            if($categories){
                return Jasonres::success('', $categories);
            } else {
                return Jasonres::error('REQ002');
            }
        } catch (Exception $e){
            return Jasonres::error('SRV001');
        }

    }

    public function retrieve (Request $request) {

        try {
            $category = ResourcesCategory::where([
                'id' => $request->id,
                'organization_id' => $request->organization_id
            ])->first();
    
            if($category){
                return Jasonres::success('', $category);
            } else {
                return Jasonres::error('REQ002');
            }
        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }

    public function create (Request $request) {

        try {
            $validationData = $request->validate([
                'name' => 'required|string'
            ]);
    
            $new_category = new ResourcesCategory;
            $new_category->name = $request->name;
            $new_category->organization_id = $request->organization_id;
            if($new_category->save()){
                return Jasonres::success('Category successfully created', $new_category);
            } else {
                return Jasonres::error('SRV001');
            }
        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }

    public function update (Request $request) {
        
        try {
            
                    $validationData = $request->validate([
                        'name' => 'required|string'
                    ]);
            
                    $category = ResourcesCategory::where([
                        'id' => $request->id,
                        'organization_id' => $request->organization_id
                    ])->first();
            
                    if($category){
                        $category->name = $request->name;
                        if($category->save()){
                            return Jasonres::success('Resource category successfully updated', $category);
                        } else{
                            return Jasonres::error('SRV001');
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
            $category = ResourcesCategory::where([
                'id' => $request->id,
                'organization_id' => $request->organization_id
            ])->first();
    
            if($category){
                if($category->delete()){
                    return Jasonres::success('Successfully deleted', []);
                } else {
                    return Jasonres::error('SRV001');
                }
            } else {
                return Jasonres::error('REQ002');
            }
        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }
}