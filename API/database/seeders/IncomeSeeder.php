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
                'date' => date('2022-04-24 12:00:00'),
                'quantity' => 1,
                'concept' => 'Alfajores',
                'value' => 150,
                'organization_id' => 1,
            ],
            [
                'type' => 'sale',
                'date' => date('2022-10-04 12:00:00'),
                'quantity' => 2,
                'concept' => 'Alfajores',
                'value' => 200,
                'organization_id' => 1,
            ],
            [
                'type' => 'sale',
                'date' => date('2022-09-04 12:00:00'),
                'quantity' => 2,
                'concepto' => 'Bombones',
                'value' => 200,
                'organization_id' => 1,
            ]
            ]);
    }
}
