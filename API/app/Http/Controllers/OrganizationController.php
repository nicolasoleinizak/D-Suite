<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use App\Models\Module;
use App\Models\License;
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
        return Organization::all();
    }

    public function retrieve(Request $request)
    {
        return Organization::find($request->organization_id);
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

        $user_id = Auth::guard()->user()->id;
        $organization = new Organization;
        $organization->name = $request->name;
        $organization->image_url = $request->image_url;
        $organization->save();
        $organization_id = $organization->id;

        
        $default_license_length = 60 * 24 * 60 * 60;
        $date = new DateTime();
        $default_license_expiration_date = $date->setTimestamp(time() + $default_license_length);
        
        $modules = Module::all();

        foreach($modules as $module){
            $license = new License;
            $license->module_id = $module->id;
            $license->organization_id = $organization_id;
            $license->expires = $default_license_expiration_date;
            $license->save();
        }

        $user = User::find($user_id);
        $user->initializePermissions($organization_id, true);

        return response()->json(['message' => 'Organization created successfully']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $organization = Organization::find($request->organization_id);
        $organization->name = isset($request->name) ? $request->name : $organization->name;
        $organization->image_url = isset($request->image_url) ? $request->image_url : $organization->image_url;
        $organization->save();
        return response()->json(['message' => 'Data updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Organization::find($request->organization_id)->delete();
        return response()->json(['message' => 'Organization deleted successfully']);
    }
}
