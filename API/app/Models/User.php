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

    public function isAdmin($organization_id){
        $system_admin_permission = Permission::where([
            'user_id' => $this->id,
            'organization_id' => $organization_id,
            'module_id' => 1
        ])->get()[0]->permission_level;
        return $system_admin_permission == 2;
    }

    public function initializePermissions($organization_id, $isAdmin = false){
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
                    'permission_level' => 0
                ]);
            }
        }
    }

    public function getPermissions($organization_id){
        foreach($this->organizations as $organization){
            if($organization->id == $organization_id){
                return Permission::where('user_id', $this->id)->where('organization_id', $organization_id)->get();
            }
        }
        return [];
    }
}
