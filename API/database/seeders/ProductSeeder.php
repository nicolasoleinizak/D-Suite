<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ProductsCategory;
use App\Models\Organization;
use App\Models\Product;

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
                'products_categories_id' => [ProductsCategory::where('name', 'alfajores')->first()->id],
                'organization_id' => Organization::all()->first()->id
            ],
            [
                'short_description' => 'Caja de 6 alfajores',
                'products_categories_id' => [ProductsCategory::where('name', 'alfajores')->first()->id],
                'organization_id' => Organization::all()->first()->id
            ],
            [
                'short_description' => 'Alfajor individual',
                'products_categories_id' => [ProductsCategory::where('name', 'alfajores')->first()->id],
                'organization_id' => Organization::all()->first()->id
            ]
        ];

        foreach($products as $product){
            $new_product = new Product;
            $new_product->short_description = $product['short_description'];
            $new_product->organization_id = $product['organization_id'];
            $new_product->save();
            $new_product->assignCategories($product['products_categories_id']);
        }
    }
}
