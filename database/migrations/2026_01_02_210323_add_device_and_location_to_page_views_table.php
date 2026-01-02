<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('page_views', function (Blueprint $table) {
            $table->string('device_type')->nullable()->after('user_agent'); // mobile, desktop, tablet
            $table->string('browser')->nullable()->after('device_type');
            $table->string('platform')->nullable()->after('browser'); // OS
            $table->string('country')->nullable()->after('platform');
            $table->string('city')->nullable()->after('country');
        });
    }

    public function down(): void
    {
        Schema::table('page_views', function (Blueprint $table) {
            $table->dropColumn(['device_type', 'browser', 'platform', 'country', 'city']);
        });
    }
};
