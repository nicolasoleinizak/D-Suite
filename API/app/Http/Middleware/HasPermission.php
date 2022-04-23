<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Module;
use App\Models\Permission;

class HasPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param $moduleId
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $module_id, $required_permission_level)
    {
        $user_id = Auth::guard()->user()->id;

        $permission_level = Permission::where([
            'user_id' => $user_id,
            'organization_id' => $request->organization_id,
            'module_id' => $module_id
        ])->get()[0]->permission_level;

        if($permission_level >= $required_permission_level){
            return $next($request);
        } else {
            return response()->json(['message' => 'The user has not permission to access this module']);
        }
    }
}
