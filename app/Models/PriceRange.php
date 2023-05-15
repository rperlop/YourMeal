<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PriceRange extends Model {
    use HasFactory;

    public function user_food_preferences(): BelongsToMany {
        return $this->belongsToMany( UserFoodPreference::class, 'user_food_preferences_has_price_ranges' );
    }

    public function restaurants(): HasMany {
        return $this->hasMany(Restaurant::class);
    }
}
