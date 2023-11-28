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
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id')->primary;
            $table->string('task_name', 100)->nullable(false);
            $table->string('task_description', 255)->nullable(false);
            $table->enum('task_status', ['done', 'undone'])->default('undone');
            $table->date('task_deadline')->nullable(false);
            $table->string('task_assigner', 100)->nullable(false);
            $table->enum('task_priority', ['low', 'medium', 'high'])->default('low');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task');
    }
};
