<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResourcesCategory;
use App\Libraries\JSONResponse;

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

        return response()->json(new JSONResponse([], $categories));
    }

    public function retrieve (Request $request) {

    }

    public function create (Request $request) {

    }

    public function update (Request $request) {

    }

    public function destroy (Request $request) {

    }
}
