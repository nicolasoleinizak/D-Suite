<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ModuleSeeder::class,
            OrganizationSeeder::class,
            OrganizationUserSeeder::class,
            ProductsCategorySeeder::class,
            ProductSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            SupplierSeeder::class,
            ResourcesCategorySeeder::class,
            ResourceSeeder::class,
            PriceModifierSeeder::class,
            PriceMakerSeeder::class,
            IncomeSeeder::class,
        ]);
    }
}
