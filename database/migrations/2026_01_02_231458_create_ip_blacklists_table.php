<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ip_blacklists', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address')->unique();
            $table->enum('reason', ['auto_blocked', 'manual', 'spam_detected', 'rate_limit', 'suspicious'])->default('manual');
            $table->timestamp('blocked_at');
            $table->timestamp('expires_at')->nullable();
            $table->foreignId('blocked_by')->nullable()->constrained('users')->onDelete('set null');
            $table->integer('attempt_count')->default(1);
            $table->timestamp('last_attempt_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('ip_address');
            $table->index('blocked_at');
            $table->index('expires_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ip_blacklists');
    }
};
