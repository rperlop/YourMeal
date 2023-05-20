<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserFoodPreferenceHasPriceRange extends Model {
    use HasFactory;

    protected $fillable = [
        'terrace',
        'latitude',
        'longitude',
    ];

    public function priceRanges(): BelongsToMany {
        return $this->belongsToMany( PriceRange::class, 'user_food_preferences_has_price_ranges' );
    }
}
