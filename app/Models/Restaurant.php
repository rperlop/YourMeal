<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Restaurant extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'featured_id',
    ];

    protected $table = 'restaurants';

    public function price_range(): BelongsTo {
        return $this->belongsTo( PriceRange::class );
    }

    public function schedules(): BelongsToMany {
        return $this->belongsToMany( Schedule::class, 'restaurant_has_schedules' );
    }

    public function food_types(): BelongsToMany {
        return $this->belongsToMany( FoodType::class, 'restaurant_has_food_types' );
    }

    public function reviews(): HasMany {
        return $this->hasMany( Review::class );
    }
}
