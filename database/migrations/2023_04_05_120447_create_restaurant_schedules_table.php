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
        Schema::create('restaurant_schedules', function (Blueprint $table) {
            $table->unsignedBigInteger('schedule_id');
            $table->unsignedBigInteger('restaurant_id');
            $table->primary(['schedule_id', 'restaurant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_schedules');
    }
};
