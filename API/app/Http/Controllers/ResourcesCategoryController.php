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

        $categories = ResourcesCategory::where([
            'organization_id' => $request->organization_id
        ])->get();

        return Jasonres::respond([], $categories);
    }

    public function retrieve (Request $request) {

        $category = ResourcesCategory::where([
            'id' => $request->id,
            'organization_id' => $request->organization_id
        ])->first();

        if(!$category){
            return Jasonres::respond(['success' => false, 'error_code' => 'REQ002']);
        } else {
            return Jasonres::respond([], $category);
        }

    }

    public function create (Request $request) {

        $validationData = $request->validate([
            'name' => 'required|string'
        ]);

        $new_category = new ResourcesCategory;
        $new_category->name = $request->name;
        $new_category->organization_id = $request->organization_id;
        if($new_category->save()){
            return Jasonres::respond([], $new_category);
        }
    }

    public function update (Request $request) {

    }

    public function destroy (Request $request) {

    }
}
