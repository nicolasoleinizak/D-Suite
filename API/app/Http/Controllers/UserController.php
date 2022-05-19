<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Module;
use App\Libraries\Jasonres;

class UserController extends Controller
{
    /**
     * It gets the user information from the token and returns it to the frontend.
     * 
     * @return A JSON response with the user's information.
     */
    public function getUserInfo(){
        try {
            $user = User::where([
                'id' => Auth::id()
            ])->with('organizations')->first();

            if($user){
                return Jasonres::success('', $user);
            } else {
                return Jasonres::error('REQ002');
            }
        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }

    public function register(Request $request){
        try {
            $validationData = $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:6|max:40',
                'name' => 'required|max:40'
            ]);
            $newUser = new User;
            $newUser->email = $request->email;
            $newUser->password = Hash::make($request->password);
            $newUser->name = $request->name;
            $newUser->role_id = 2;
            $newUser->created_at = time();
            $newUser->updated_at = time();
            if($newUser->save()){
                return Jasonres::success('The user was registered successfully');
            } else {
                return Jasonres::error('SRV001');
            }
        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }

    public function isAdmin($user_id, $organization_id){
        try {
            $user = User::find($user_id);
            if($user){
                $is_admin = $user->is_admin($organization_id);
                return Jasonres::success('', $is_admin);
            } else {
                return Jasonres::error('REQ002');
            }
        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }

    public function getPermissions(Request $request){
        try {
            $user = User::find(Auth::id());
    
            if($user){
                $data = [
                    'permissions' => $user->getPermissions($request->organization_id),
                    'isAdmin' => $user->isAdmin($request->organization_id)
                ];
                return Jasonres::success('', $data);
            } else {
                return Jasonres::error('REQ002');
            }
        } catch (Exception $e) {
            return Jasonres::error('SRV001');
        }
    }

    public function updatePermissions(Request $request){
        try {
            $user = User::find($request->user_id);
            if($user){
                if($user->updatePermissions($request->organization_id, $request->permissions)){
                    return Jasonres::success('The permissions was successfully updated');
                } else {
                    return Jasonres::error('SRV001');
                }
            } else {
                return Jasonres::error('REQ002');
            }
        } catch (Exception $e) {
            return Jasonres::error('REQ002');
        }
    }
}
