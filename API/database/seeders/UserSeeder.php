<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Organization;
use App\Models\User;
use App\Models\Module;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('users')->delete();

        $superadmin = new User;
        $superadmin->name = 'Superadmin';
        $superadmin->email = 'superadmin@test.com';
        $superadmin->password = Hash::make('test1234');
        $superadmin->role_id = 1;
        $superadmin->save();

        $organization_admin = new User;
        $organization_admin->name = 'Admin user';
        $organization_admin->email = 'admin@test.com';
        $organization_admin->password = Hash::make('test1234');
        $organization_admin->role_id = 2;
        $organization_admin->save();

        $organization_id = Organization::all()->first()->id;

        $organization_admin->initializePermissions($organization_id, true);

        $regular_organization_user = new User;
        $regular_organization_user->name = 'Regular user';
        $regular_organization_user->email = 'regular@test.com';
        $regular_organization_user->password = Hash::make('test1234');
        $regular_organization_user->role_id = 2;
        $regular_organization_user->save();

        $regular_organization_user->initializePermissions($organization_id, false);
    }

}
