<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('user_food_preferences_id')->nullable();
            $table->foreign('user_food_preferences_id')->references('id')->on('user_food_preferences');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_user_food_preferences_id_foreign');
            $table->dropColumn('user_food_preferences_id');
        });
    }
};
