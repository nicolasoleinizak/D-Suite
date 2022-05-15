<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Resource extends Model
{
    use HasFactory;

    public function assignCategories($categories){
        foreach($categories as $categorie){
            DB::table('resource_resources_category')->insert([
                'resource_id' => $this->id,
                'resources_category_id' => $category->id
            ]);
        }
    }

    public function categories(){
        return $this->belongsToMany(ResourcesCategory::class);
    }
}
