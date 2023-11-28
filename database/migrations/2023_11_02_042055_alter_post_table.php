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
        Schema::table('posts', function (Blueprint $table) {
            $table->renameColumn('post_title', 'title');
            $table->renameColumn('post_author', 'author');
            $table->renameColumn('post_category', 'category');
            $table->renameColumn('post_status', 'status');
            $table->renameColumn('post_content', 'content');
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
