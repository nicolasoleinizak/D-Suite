<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use App\Models\Module;
use App\Models\License;
use App\Libraries\Jasonres;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $organizations = Organization::all();
    
            if($organizations){
                return Jasonres::success('', $organizations);
            } else {
                return Jasonres::error('REQ002');
            }

        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }

    public function retrieve(Request $request)
    {
        try{

            $organization = Organization::find($request->organization_id);

            if($organization){
                return Jasonres::success('', $organization);
            } else {
                return Jasonres::error('REQ002');
            }

        } catch (Exception $e){
            return Jasonres::error('SRV001');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validationData = $request->validate([
            'name' => 'required|string',
            'image' => 'string'
        ]);

        try{

            $user = Auth::guard()->user();

            if(!$user){
                return Jasonres::error('AUT001');
            }

            $user_id = Auth::guard()->user()->id;

            $organization = new Organization;
            $organization->name = $request->name;
            $organization->image_url = $request->image_url;
            if(!$organization->save()){
                return Jasronres::error('SRV001');
            }

            $default_license_length = 60 * 24 * 60 * 60;
            $date = new DateTime();
            $default_license_expiration_date = $date->setTimestamp(time() + $default_license_length);
            
            $modules = Module::all();
            if(!$modules){
                return Jasonres::error('SRV001');
            }
    
            foreach($modules as $module){
                $license = new License;
                $license->module_id = $module->id;
                $license->organization_id = $organization->id;
                $license->expires = $default_license_expiration_date;
                if(!$license->save()){
                    return Jasronres::error('SRV001');
                }
            }
    
            $user = User::find($user_id);
            if(!$user){
                Jasonres::error('SRV001');
            }
            $user->initializePermissions($organization->id, true);
    
            return Jasonres::success('Organization created successfully', $organization);
            
        } catch (Exception $e) {

        } 


        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try{
            $organization = Organization::where([
                'id' => $request->organization_id
                ])->first();
    
            if($organization){
    
                $organization->name = isset($request->name) ? $request->name : $organization->name;
                $organization->image_url = isset($request->image_url) ? $request->image_url : $organization->image_url;
    
                if($organization->save()){
                    return Jasonres::success('Organization successfully updated', $organization);
                } else{
                    return Jasonres::error('SRV001');
                }
            } else {
                return Jasonres::error('REQ001');
            }
        } catch (Exception $e){
            return Jasonres::error('SRV001');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try{
            $organization = Organization::where([
                'id' => $request->organization_id
            ]);

            if($organization->first()){
                if($organization->delete()){
                    return Jasonres::success('The organization was successfully deleted');
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
