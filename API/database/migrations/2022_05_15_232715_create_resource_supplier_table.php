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
        Schema::create('resource_supplier', function (Blueprint $table) {
            $table->id();
            $table  ->foreignId('supplier_id')
                    ->constrained('suppliers')
                    ->onDelete('cascade');
            $table  ->foreignId('resource_id')
                    ->constrained('resources')
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
        Schema::dropIfExists('resource_supplier');
    }
};
