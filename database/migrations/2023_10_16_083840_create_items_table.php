<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id')->primary;
            $table->string('product_name', 100)->nullable(false);
            $table->string('product_description', 255)->nullable(false);
            $table->integer('category_id')->nullable(false);
            $table->string('product_brand', 100)->nullable(false);
            $table->integer('product_price')->nullable(false);
            $table->integer('product_stock')->nullable(false);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
