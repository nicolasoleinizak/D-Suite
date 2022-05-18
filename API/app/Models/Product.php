<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

        try {
            DB::table('product_products_category')->where('product_id', $this->id)->delete();
    
            foreach($categories_ids as $category_id){
                DB::table('product_products_category')->insert([
                    'product_id' => $this->id,
                    'products_category_id' => $category_id
                ]);
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function categories(){
        return $this->belongsToMany(ProductsCategory::class);
    }
}
