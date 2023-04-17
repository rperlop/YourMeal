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
        Schema::table('restaurant_has_schedules', function (Blueprint $table) {
            Schema::rename('restaurant_schedules', 'restaurant_has_schedules');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurant_has_schedules', function (Blueprint $table) {
            Schema::rename('restaurant_has_schedules', 'restaurant_schedules');
        });
    }
};
