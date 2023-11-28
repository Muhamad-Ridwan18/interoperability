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
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('product_name', 'name');
            $table->renameColumn('product_description', 'description');
            $table->renameColumn('product_price', 'price');
            $table->renameColumn('product_brand', 'brand');
            $table->renameColumn('product_stock', 'stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
