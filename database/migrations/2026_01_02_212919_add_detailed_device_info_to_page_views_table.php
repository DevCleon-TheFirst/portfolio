<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('page_views', function (Blueprint $table) {
            $table->string('browser_version')->nullable()->after('browser');
            $table->string('platform_version')->nullable()->after('platform');
            $table->string('screen_resolution')->nullable()->after('platform_version');
        });
    }

    public function down(): void
    {
        Schema::table('page_views', function (Blueprint $table) {
            $table->dropColumn(['browser_version', 'platform_version', 'screen_resolution']);
        });
    }
};
