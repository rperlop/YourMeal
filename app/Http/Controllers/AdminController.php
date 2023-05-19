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
        $restaurant = Restaurant::select('restaurants.*', DB::raw('COUNT(reviews.id) as review_count'))
                                ->join('reviews', 'restaurants.id', '=', 'reviews.restaurant_id')
                                ->where('reviews.created_at', '>', Carbon::now()->subWeek())
                                ->groupBy('restaurants.id')
                                ->orderByDesc('review_count')
                                ->first();

        if ($restaurant) {
            $restaurant->update(['featured_id' => $restaurant->id]);
        }

        return redirect()->back();
    }



}


