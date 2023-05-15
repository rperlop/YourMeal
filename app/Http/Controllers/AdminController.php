<?php


namespace App\Http\Controllers;

    use App\Models\User;
    use App\Models\Restaurant;

class AdminController extends Controller
{
    public function stats()
    {
        $userCount = User::count();
        $restaurantCount = Restaurant::count();

        $topRestaurants = Restaurant::withCount('reviews')
                                    ->orderBy('reviews_count', 'desc')
                                    ->take(5)
                                    ->get();


        return view('admin.dashboard', compact('userCount', 'restaurantCount', 'topRestaurants'));
    }

}


