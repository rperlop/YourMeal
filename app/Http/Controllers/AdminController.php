<?php


namespace App\Http\Controllers;

    use App\Models\User;
    use App\Models\Restaurant;
    use Carbon\Carbon;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Contracts\View\View;
    use Illuminate\Foundation\Application;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Support\Facades\DB;

    class AdminController extends Controller
{
        /**
         * Get the number of registered users and restaurants and the restaurant most reviewed
         *
         * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
         */
    public function get_app_stats(): Application|View|Factory|\Illuminate\Contracts\Foundation\Application {
        $userCount = User::count();
        $restaurantCount = Restaurant::count();

        $topRestaurants = Restaurant::withCount('reviews')
                                    ->orderBy('reviews_count', 'desc')
                                    ->take(5)
                                    ->get();


        return view('admin.dashboard', compact('userCount', 'restaurantCount', 'topRestaurants'));
    }

        /**
         * Update the feature restaurant on the welcome page
         *
         * @return RedirectResponse
         */
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
