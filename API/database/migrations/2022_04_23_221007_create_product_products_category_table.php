<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_products_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id') 
                    ->constrained('products')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->foreignId('products_category_id')
                    ->constrained('products_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_category_product');
    }
};
