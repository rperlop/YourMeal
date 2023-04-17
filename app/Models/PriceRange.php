<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceRange extends Model {
    use HasFactory;

    protected $table = 'price_ranges';

    public function user_food_preferences(): \Illuminate\Database\Eloquent\Relations\BelongsToMany {
        return $this->belongsToMany( UserFoodPreference::class, 'user_food_preferences_has_price_ranges' );
    }
}
