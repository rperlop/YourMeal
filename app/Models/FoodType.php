<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FoodType extends Model {
    use HasFactory;

    protected $table = 'food_types';

    public $timestamps = false;

    public function restaurant(): BelongsToMany {
        return $this->belongsToMany( Restaurant::class, 'restaurant_has_food_types' );
    }

    public function user_food_preferences(): BelongsToMany {
        return $this->belongsToMany( UserFoodPreference::class, 'user_food_preferences_has_food_types' );
    }
}
