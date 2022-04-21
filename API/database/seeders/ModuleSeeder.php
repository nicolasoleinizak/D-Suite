<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modules_names = [
            'system_administration',
            'products',
            'clients',
            'supplies',
            'suppliers'
        ];

        foreach($modules_names as $module_name){
            DB::table('modules')->insert([
                'name' => $module_name
            ]);
        }
    }
}
