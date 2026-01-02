<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accountability_metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->integer('tasks_completed')->default(0);
            $table->integer('tasks_missed')->default(0);
            $table->integer('focus_time')->default(0); // in minutes
            $table->decimal('discipline_score', 5, 2)->default(0);
            $table->decimal('completion_rate', 5, 2)->default(0);
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('date');
            $table->unique(['user_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accountability_metrics');
    }
};
