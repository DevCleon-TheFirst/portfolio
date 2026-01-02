<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('timeline_events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('event_type'); // education, work, achievement, learning
            $table->date('date');
            $table->string('icon')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
            
            $table->index('event_type');
            $table->index('date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('timeline_events');
    }
};
