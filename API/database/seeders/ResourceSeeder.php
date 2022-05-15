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
                'category' => 'materias primas',
                'suppliers' => [
                    1
                ]
            ],
            [
                'name' => 'azúcar',
                'price' => 86,
                'unit' => 'kg',
                'category' => 'materias primas',
                'suppliers' => [
                    2
                ]
            ],
            [
                'name' => 'mano de obra',
                'price' => 450,
                'unit' => 'h',
                'category' => 'mano de obra',
                'suppliers' => [
                ]
            ]
        ];

        $organization_id = Organization::first()->id;

        foreach($resources as $resource){
            $category_id = ResourcesCategory::where([
                'organization_id' => $organization_id,
                'name' => $resource['category']
            ])->first()->id;

            $new_resource = new Resource;
            $new_resource->name = $resource['name'];
            $new_resource->price = $resource['price'];
            $new_resource->unit = $resource['unit'];
            $new_resource->organization_id = $organization_id;
            $new_resource->save();

            DB::table('resource_resources_category')->insert([
                'resource_id' => $new_resource->id,
                'resources_category_id' => $category_id
            ]);

            foreach($resource['suppliers'] as $supplier){
                DB::table('resource_supplier')->insert([
                    'resource_id' => $new_resource->id,
                    'supplier_id' => $supplier
                ]);
            }
        }
    }
}
