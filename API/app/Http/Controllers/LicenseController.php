<?php

namespace App\Http\Controllers;

use App\Models\License;
use Illuminate\Http\Request;

class LicenseController extends Controller
{
    public function update(Request $request){
        $license = License::where([
            'module_id' => $request->module_id,
            'organization_id' => $request->organization_id
        ])->get()->first();
        $license->expires = $request->expires;
        $license->save();
        return response()->json(['message' => 'Licenses successfully updated']);
    }
}
