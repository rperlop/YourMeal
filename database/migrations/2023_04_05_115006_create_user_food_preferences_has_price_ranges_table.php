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
        Schema::create('user_food_preferences_has_price_ranges', function (Blueprint $table) {
            $table->unsignedBigInteger('price_range_id');
            $table->unsignedBigInteger('user_food_preference_id');
            $table->primary(['price_range_id', 'user_food_preference_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_food_preferences_has_price_ranges');
    }
};
