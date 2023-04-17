<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFoodPreferenceHasPriceRange extends Model
{
    use HasFactory;

    protected $table = 'user_food_preferences_has_price_ranges';

    public function priceRanges(): \Illuminate\Database\Eloquent\Relations\BelongsToMany {
        return $this->belongsToMany(PriceRange::class, 'user_food_preferences_has_price_ranges');
    }

}
