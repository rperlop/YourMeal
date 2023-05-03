<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function show($id): Factory|Application|View|\Illuminate\Contracts\Foundation\Application {
        $restaurant = Restaurant::findOrFail($id);

        $has_terrace = $restaurant->terrace ? 'Yes' : 'No';

        $price_range = $restaurant->price_range->range;

        $food_types = $restaurant->food_types()->pluck('name')->toArray();

        $schedules = $restaurant->schedules()->get();

        $data = [
            'restaurant' => $restaurant,
            'price_range' => $price_range,
            'has_terrace' => $has_terrace,
            'food_types' => $food_types,
            'schedules' => $schedules,
        ];

        return view('restaurant', $data);
    }
}
