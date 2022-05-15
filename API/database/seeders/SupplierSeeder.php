<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Organization;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $suppliers = [
            [
                'name' => 'Aromito',
            ],
            [
                'name' => 'Makukos'
            ]
        ];

        $organization_id = Organization::first()->id;

        foreach($suppliers as $supplier){
            DB::table('suppliers')->insert([
                'name' => $supplier['name'],
                'organization_id' => $organization_id
            ]);
        }
    }
}
