<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internal_project_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('estimated_time')->default(0); // in minutes
            $table->integer('actual_time')->default(0); // in minutes
            $table->timestamp('due_at')->nullable();
            $table->string('status')->default('pending'); // pending, in_progress, completed, missed
            $table->string('priority')->default('medium'); // low, medium, high
            $table->integer('order')->default(0);
            $table->timestamps();
            
            $table->index('internal_project_id');
            $table->index('user_id');
            $table->index('status');
            $table->index('due_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
