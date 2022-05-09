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
        Schema::create('resources_resources_categories', function (Blueprint $table) {
            $table->id();
            $table  ->foreignId('resource_id')
                    ->constrained('resources')
                    ->onDelete('cascade');
            $table  ->foreignId('resources_category_id')
                    ->constrained('resources_categories')
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
        Schema::dropIfExists('resources_resources_categories');
    }
};
