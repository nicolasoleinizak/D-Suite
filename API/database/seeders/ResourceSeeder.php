<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\ResourcesCategory;
use App\Models\Resource;
use App\Models\Organization;

class ResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('resources')->delete();

        $resources = [
            [
                'name' => 'harina',
                'price' => 115,
                'unit' => 'kg',
                'category' => 'materias primas'
            ],
            [
                'name' => 'azúcar',
                'price' => 86,
                'unit' => 'kg',
                'category' => 'materias primas'
            ],
            [
                'name' => 'mano de obra',
                'price' => 450,
                'unit' => 'h',
                'category' => 'mano de obra'
            ]
        ];

        foreach($resources as $resource){
            $category_id = ResourcesCategory::where([
                'organization_id' => Organization::all()->first()->id,
                'name' => $resource['category']
            ])->first()->id;

            $new_resource = new Resource;
            $new_resource->name = $resource['name'];
            $new_resource->price = $resource['price'];
            $new_resource->unit = $resource['unit'];
            $new_resource->save();

            DB::table('resources_resources_categories')->insert([
                'resource_id' => $new_resource->id,
                'resources_category_id' => $category_id
            ]);
        }
    }
}
