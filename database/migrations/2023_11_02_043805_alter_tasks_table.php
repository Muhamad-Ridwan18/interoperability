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
        Schema::table('tasks', function (Blueprint $table) {
            $table->renameColumn('task_name', 'name');
            $table->renameColumn('task_description', 'description');
            $table->renameColumn('task_status', 'status');
            $table->renameColumn('task_deadline', 'deadline');
            $table->renameColumn('task_assigner','assigner');
            $table->renameColumn('task_priority', 'priority');
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
