<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function organizations(){
        return $this->belongsToMany(Organization::class);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin($organization_id){
        $system_admin_permission = Permission::where([
            'user_id' => $this->id,
            'organization_id' => $organization_id,
            'module_id' => 1
        ])->get()[0]->permission_level;
        return $system_admin_permission == 2;
    }

    /**
     * It takes an organization id and a boolean value and inserts a row into the permissions table for
     * each module in the modules table. 
     * 
     * The permission level is set to 2 if the user can write, 1 if the user can only read. 
     * 
     * @param organization_id The id of the organization that the user is being added to.
     * @param isAdmin boolean
     */
    public function initializePermissions($organization_id, $isAdmin = false){

        DB::table('organization_user')->insertGetId([
            'user_id' => $this->id,
            'organization_id' => $organization_id
        ]);

        $modules = Module::all();
        foreach($modules as $module){
            if($module->id == 1 && $isAdmin){
                DB::table('permissions')->insert([
                    'organization_id' => $organization_id,
                    'module_id' => $module->id,
                    'user_id' =>  $this->id,
                    'permission_level' => 2
                ]);
            }
            else{
                DB::table('permissions')->insert([
                    'organization_id' => $organization_id,
                    'module_id' => $module->id,
                    'user_id' =>  $this->id,
                    'permission_level' => $isAdmin? 2:0
                ]);
            }
        }
    }

    public function updatePermissions($organization_id, Array $permissions_by_module){
        try {
            foreach($permissions_by_module as $new_permission){
                $permission = Permission::where([
                    'user_id' => $this->id,
                    'organization_id' => $organization_id,
                    'module_id' => $new_permission['module_id']
                ])->first();
                $permission->permission_level = $new_permission['permission_level'];
                $permission->save();
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getPermissions($organization_id){
        $permissions = Permission::where([
            'user_id' => $this->id,
            'organization_id'=> $organization_id
        ])->get();

        $parsed_permissions = $permissions->map(function($item){
            return [
                'module_id' => $item->module_id,
                'module' => Module::where('id', $item->module_id)->get()->first()->name,
                'permission_level' => $item->permission_level,
                'permission_type' => $item->permission_level == 1? 'reading' : 'writing'
            ];
        })->all();

        return $parsed_permissions;

    }
}
