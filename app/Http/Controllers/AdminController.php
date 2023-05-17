<?php


namespace App\Http\Controllers;

    use App\Models\User;
    use App\Models\Restaurant;
    use Carbon\Carbon;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Support\Facades\DB;

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

    public function update_featured_restaurant(): RedirectResponse {
        $last_week = Carbon::now()->subWeek();

        $featured_restaurant = Restaurant::select('restaurants.*', DB::raw('COUNT(reviews.id) as review_count'))
                                        ->leftJoin('reviews', 'restaurants.id', '=', 'reviews.restaurant_id')
                                        ->where('reviews.created_at', '>', $last_week)
                                        ->groupBy('restaurants.id')
                                        ->orderByDesc('review_count')
                                        ->first();

        session(['featured_restaurant' => $featured_restaurant]);

        return redirect()->back();
    }

}


