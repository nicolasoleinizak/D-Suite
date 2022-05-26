<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PriceModifier;

class PriceModifierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PriceModifier::truncate();
        $modifiers = [
            [
                'description' => 'Transporte 10%',
                'type' => 'coefficient',
                'value' => 1.1,
                'organization_id' => 1
            ],
            [
                'description' => 'Ganancia 30%',
                'type' => 'coefficient',
                'value' => 1.3,
                'organization_id' => 1
            ],
            [
                'description' => 'Impuestos',
                'type' => 'coefficient',
                'value' => 1.05,
                'organization_id' => 1
            ]
        ];
        foreach($modifiers as $modifier){
            $price_modifier = new PriceModifier;
            $price_modifier->description = $modifier['description'];
            $price_modifier->type = $modifier['type'];
            $price_modifier->value = $modifier['value'];
            $price_modifier->organization_id = $modifier['organization_id'];
            $price_modifier->save();
        }
    }
}
