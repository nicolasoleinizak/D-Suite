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
        Schema::create('price_makers', function (Blueprint $table) {
            $table->id();
            $table  ->foreignId('product_id')
                    ->constrained('products')
                    ->onDelete('cascade');
            $table->string('description');
            $table->string('formula');
            $table->double('result');
            $table  ->foreignId('organization_id')
                    ->constrained('organizations')
                    ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('price_maker');
    }
};
