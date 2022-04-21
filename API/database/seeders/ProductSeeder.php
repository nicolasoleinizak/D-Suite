<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ProductsCategory;
use App\Models\Organization;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->delete();

        $products = [
            [
                'short_description' => 'Caja de 12 alfajores',
                'products_category_id' => ProductsCategory::where('name', 'alfajores')->first()->id,
                'organization_id' => Organization::all()->first()->id
            ],
            [
                'short_description' => 'Caja de 6 alfajores',
                'products_category_id' => ProductsCategory::where('name', 'alfajores')->first()->id,
                'organization_id' => Organization::all()->first()->id
            ]
        ];

        foreach($products as $product){
            DB::table('products')->insert([
                'short_description' => $product['short_description'],
                'products_category_id' => $product['products_category_id'],
                'organization_id' => $product['organization_id']
            ]);
        }
    }
}
