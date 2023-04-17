<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFoodPreferenceHasFoodType extends Model {
    use HasFactory;

    protected $table = 'user_food_preferences_has_food_types';

    public function foodTypes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany {
        return $this->belongsToMany( FoodType::class, 'user_food_preferences_has_food_types' );
    }
}
