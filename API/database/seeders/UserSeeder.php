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

        $admin = new User;
        $admin->name = 'Admin user';
        $admin->email = 'admin@test.com';
        $admin->password = Hash::make('test1234');
        $admin->save();

        $organization_id = Organization::all()->first()->id;

        DB::table('organization_user')->insertGetId([
            'user_id' => $admin->id,
            'organization_id' => $organization_id
        ]);

        $admin->initializePermissions($organization_id, true);

        $regular_user = new User;
        $regular_user->name = 'Regular user';
        $regular_user->email = 'regular@test.com';
        $regular_user->password = Hash::make('test1234');
        $regular_user->save();

        DB::table('organization_user')->insert([
            'user_id' => $admin->id,
            'organization_id' => $organization_id
        ]);

        $regular_user->initializePermissions($organization_id, false);
    }

}
