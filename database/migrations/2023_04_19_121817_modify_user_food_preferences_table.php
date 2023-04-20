<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('user_food_preferences', function (Blueprint $table) {
            $table->decimal('latitude', 9, 6)->change();
            $table->decimal('longitude', 9, 6)->change();
        });
    }

    public function down()
    {
        Schema::table('user_food_preferences', function (Blueprint $table) {
            $table->decimal('latitude')->change();
            $table->decimal('longitude')->change();
        });
    }
};
