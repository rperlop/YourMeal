<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedules';

    public function restaurants(): \Illuminate\Database\Eloquent\Relations\BelongsToMany {
        return $this->belongsToMany(Restaurant::class, 'restaurant_has_schedules');
    }

    public function user_food_preferences(): \Illuminate\Database\Eloquent\Relations\BelongsToMany {
        return $this->belongsToMany(UserFoodPreference::class, 'user_food_preference_has_schedules');
    }
}
