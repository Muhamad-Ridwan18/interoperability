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
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id')->primary;
            $table->bigInteger('customer_id')->unsigned();
            $table->string('order_name', 100)->nullable(false);
            $table->string('order_description', 255)->nullable(false);
            $table->date('order_date')->nullable(false);
            $table->string('order_shipping_address', 255)->nullable(false);
            $table->enum('order_status', ['pending', 'shipped', 'delivered'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
