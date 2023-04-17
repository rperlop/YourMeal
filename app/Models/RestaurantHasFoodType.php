<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantHasFoodType extends Model
{
    use HasFactory;

    protected $table = 'restaurant_has_food_types';
}
