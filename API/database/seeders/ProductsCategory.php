<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsCategory extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products_categories')->delete();
        $categories = array(
            [
                'name' => 'chocolates'
            ],
            [
                'name' => 'alfajores'
            ],
            [
                'name' => 'dietética'
            ],
            [
                'name' => 'dulces y mermeladas'
            ],
            [
                'name' => 'frutas con chocolate'
            ]
        );

        foreach($categories as $category){
            DB::table('products_categories')->insert([
                'name' => $category['name']
            ]);
        }
    }
}
