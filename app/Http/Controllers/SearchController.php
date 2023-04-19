<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class SearchController extends Controller {
    public function search( Request $request ) {
        $search = $request->get('search');
        $restaurants = Restaurant::where('name', 'LIKE', '%' . $search . '%')->get();

        return view('restaurant')->with('restaurants', $restaurants);
    }
}
