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
        Schema::table('orders', function (Blueprint $table) {
            $table->renameColumn('order_name', 'name');
            $table->renameColumn('order_description', 'description');
            $table->renameColumn('order_date', 'date');
            $table->renameColumn('order_shipping_address', 'shipping_address');
            $table->renameColumn('order_status', 'status');
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
