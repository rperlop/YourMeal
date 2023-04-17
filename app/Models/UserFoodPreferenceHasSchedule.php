<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFoodPreferenceHasSchedule extends Model {
    use HasFactory;

    protected $table = 'user_food_preferences_has_schedules';

    public function schedules(): \Illuminate\Database\Eloquent\Relations\BelongsToMany {
        return $this->belongsToMany( Schedule::class, 'user_food_preference_has_schedules' );
    }
}
