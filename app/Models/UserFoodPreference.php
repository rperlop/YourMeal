<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFoodPreference extends Model
{
    use HasFactory;

    protected $fillable = ['terrace', 'latitude', 'longitude'];

    public function food_types(): \Illuminate\Database\Eloquent\Relations\BelongsToMany {
        return $this->belongsToMany(FoodType::class, 'user_food_preferences_has_food_types');
    }

    public function price_ranges(): \Illuminate\Database\Eloquent\Relations\BelongsToMany {
        return $this->belongsToMany(PriceRange::class, 'user_food_preferences_has_price_ranges');
    }

    public function schedules(): \Illuminate\Database\Eloquent\Relations\BelongsToMany {
        return $this->belongsToMany(Schedule::class, 'user_food_preferences_has_schedules');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }



}
