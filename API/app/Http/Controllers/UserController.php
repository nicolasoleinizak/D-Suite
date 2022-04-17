<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class UserController extends Controller
{
    public function get(Request $request){
        $user = User::find($request->id);
        return response()->json([$user]);
    }
}
