<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PriceMaker;
use App\Libraries\PriceHandle\PriceCalculator;

class PriceMakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $price_makers = [
            [
                'product_id' => 3,
                'description' => 'Precio minorista',
                'formula' => '(#Resource:1 + #Resource:2) * #PriceModifier:1 * #PriceModifier:1'
            ],
            [
                'product_id' => 2,
                'description' => 'Precio minorista',
                'formula' => '#Product:1 * 6'
            ]
        ];

        foreach($price_makers as $price_maker){
            $new_price_maker = new PriceMaker;
            $new_price_maker->product_id = $price_maker['product_id'];
            $new_price_maker->description = $price_maker['description'];
            $new_price_maker->formula = $price_maker['formula'];
            $new_price_maker->result = PriceCalculator::parse($price_maker['formula'], 1);
            $new_price_maker->organization_id = 1;
            $new_price_maker->save();
        }
    }
}
