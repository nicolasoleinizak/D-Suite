<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class UserController extends Controller
{
    public function getUserParameters(Request $request){
        $user = Auth::guard()->user();
        $organizations = [];
        foreach($user->organizations as $organization){
            array_push($organizations, [
                'id' => $organization->id,
                'name' => $organization->name]
            );
        }
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'organizations' => $organizations,
        ]);
    }

    public function register(Request $request){
        $validationData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|max:40',
            'name' => 'required|max:40'
        ]);
        $newUser = new User;
        $newUser->email = $request->email;
        $newUser->password = $request->password;
        $newUser->name = $request->name;
        $newUser->created_at = time();
        $newUser->updated_at = time();
        $newUser->save();
        return response()->json(['message' => 'The user was registered successfully']);
    }
}
