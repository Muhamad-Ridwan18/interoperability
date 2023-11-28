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
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id')-> primary;
            $table->string('post_title',100);
            $table->string('post_author',100);
            $table->string('post_category',100);
            $table->enum('post_status', array('draft','published'))->default('draft');
            $table->text('post_content');
            $table->integer('user_id')->index('user_id_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post');
    }
};
