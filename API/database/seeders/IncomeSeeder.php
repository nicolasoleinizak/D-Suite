<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('incomes')->insert([
            [
                'type' => 'sale',
                'date' => '2022-24-04',
                'quantity' => 1,
                'concept' => 'Alfajores',
                'value' => 150,
                'organization_id' => 1,
                'created_at' => '1990-12-12 12:00'
            ],
            [
                'type' => 'sale',
                'date' => '2022-10-04',
                'quantity' => 2,
                'concept' => 'Alfajores',
                'value' => 200,
                'organization_id' => 1,
                'created_at' => '1995-12-12 12:00'
            ],
            [
                'type' => 'sale',
                'date' => '2022-20-04',
                'quantity' => 2,
                'concepto' => 'Bombones',
                'value' => 200,
                'organization_id' => 1,
                'created_at' => '2000-12-12 12:00'
            ]
            ]);
    }
}
