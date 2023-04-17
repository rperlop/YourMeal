<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model {
    use HasFactory;

    protected $table = 'restaurants';

    public function schedules(): \Illuminate\Database\Eloquent\Relations\BelongsToMany {
        return $this->belongsToMany( Schedule::class, 'restaurant_has_schedules' );
    }

    public function food_types(): \Illuminate\Database\Eloquent\Relations\BelongsToMany {
        return $this->belongsToMany( FoodType::class, 'restaurant_has_food_types' );
    }
}
