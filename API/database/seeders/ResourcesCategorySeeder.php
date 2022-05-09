<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ResourcesCategory;
use App\Models\Organization;
use Illuminate\Support\Facades\DB;

class ResourcesCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('resources_categories')->delete();
        $organization_id = Organization::all()->first()->id;
        $category_names = [
            'Insumos',
            'Mano de obra',
            'Materias primas'
        ];
        foreach($category_names as $category_name){
            $resource_category = new ResourcesCategory;
            $resource_category->name = $category_name;
            $resource_category->organization_id = $organization_id;
            $resource_category->save();
        }
    }
}
