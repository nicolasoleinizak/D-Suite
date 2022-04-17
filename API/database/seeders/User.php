<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Organization;

class User extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        DB::table('users')->insert([
            'name' => 'Test user',
            'email' => 'test@test.com',
            'password' => Hash::make('test1234')
        ]);

        DB::table('organization_user')->insert([
            'user_id' => DB::table('users')->select('id')->limit(1)->get()[0]->id,
            'organization_id' => Organization::all()->first()->id
        ]);
    }
}
