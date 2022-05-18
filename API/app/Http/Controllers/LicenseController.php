<?php

namespace App\Http\Controllers;

use App\Models\License;
use Illuminate\Http\Request;
use App\Libraries\Jasonres;

class LicenseController extends Controller
{
    /**
     * It updates the license expiration date
     * 
     * @param Request request 
     * 
     * @return A JSON response.
     */
    public function update(Request $request){
        try{
            $license = License::where([
                'module_id' => $request->module_id,
                'organization_id' => $request->organization_id
            ])->first();

            if(!$license){
                return Jasonres::error('REQ002');
            }

            $license->expires = $request->expires;
            
            if($license->save()){
                return Jasonres::success('License successfully updated');
            } else {
                return Jasonres::error('SRV001');
            }

        } catch (Exception $e){
            return Jasonres::error('SRV001');
        }
    }
}
