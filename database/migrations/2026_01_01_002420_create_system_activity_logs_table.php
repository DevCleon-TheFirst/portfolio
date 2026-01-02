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
        Schema::create('system_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('action'); // e.g., "New Post", "Task Completed"
            $table->text('description')->nullable();
            $table->string('icon')->default('bell'); // For UI display
            $table->string('color')->default('indigo'); // For UI accent
            $table->string('link')->nullable(); // Where clicking takes you
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_activity_logs');
    }
};
