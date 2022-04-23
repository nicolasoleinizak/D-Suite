<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'short-description',
        'long-description',
        'products_category_id',
        'organization_id'
    ];

    public function assignCategories(Array $categories_ids){
        foreach($categories_ids as $category_id){
            DB::table('products_category_product')->insert([
                'product_id' => $this->id,
                'products_category_id' => $category_id
            ]);
        }
    }
}
