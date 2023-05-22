<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use App\Models\Restaurant;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller {
    /**
     * Get the number of registered users and restaurants, the restaurant most reviewed and last notifications
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function get_dashboard_data(): Application|View|Factory|\Illuminate\Contracts\Foundation\Application {
        $user_count       = User::count();
        $restaurant_count = Restaurant::count();
        $notifications    = Notification::latest()->take( 5 )->get();
        $top_restaurants = Restaurant::withCount( 'reviews' )
                                     ->orderBy( 'reviews_count', 'desc' )
                                     ->take( 5 )
                                     ->get();

        return view( 'admin.dashboard', compact( 'user_count', 'restaurant_count', 'notifications', 'top_restaurants' ) );
    }

    /**
     * Update the feature restaurant on the welcome page
     *
     * @return RedirectResponse
     */
    public function update_featured_restaurant(): RedirectResponse {
        $restaurant = Restaurant::select( 'restaurants.*', DB::raw( 'COUNT(reviews.id) as review_count' ) )
                                ->join( 'reviews', 'restaurants.id', '=', 'reviews.restaurant_id' )
                                ->where( 'reviews.created_at', '>', Carbon::now()->subWeek() )
                                ->groupBy( 'restaurants.id' )
                                ->orderByDesc( 'review_count' )
                                ->first();

        $restaurant?->update( [ 'featured_id' => $restaurant->id ] );

        return redirect()->back();
    }

}
