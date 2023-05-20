<?php

namespace App\Http\Controllers;

use App\Models\FoodType;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class FoodTypeController extends Controller {
    /**
     * Index all food types
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function index(): Application|View|Factory|\Illuminate\Contracts\Foundation\Application {
        $foodTypes = FoodType::all();

        return view( 'food_types.index', [ 'foodTypes' => $foodTypes ] );
    }
}
