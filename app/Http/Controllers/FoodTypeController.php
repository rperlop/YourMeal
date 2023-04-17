<?php

namespace App\Http\Controllers;

use App\Models\FoodType;
use Illuminate\Http\Request;

class FoodTypeController extends Controller {
    public function index() {
        $foodTypes = FoodType::all();

        return view( 'food_types.index', [ 'foodTypes' => $foodTypes ] );
    }
}
