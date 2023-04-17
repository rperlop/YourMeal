<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodType extends Model {
    use HasFactory;

    protected $table = 'food_types';

    public function restaurant(): \Illuminate\Database\Eloquent\Relations\BelongsToMany {
        return $this->belongsToMany( Restaurant::class, 'restaurant_has_food_types' );
    }

    public function user_food_preferences(): \Illuminate\Database\Eloquent\Relations\BelongsToMany {
        return $this->belongsToMany( UserFoodPreference::class, 'user_food_preferences_has_food_types' );
    }
}
