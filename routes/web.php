<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserFoodPreferenceController;
use App\Models\Config;
use App\Models\FoodType;
use App\Models\PriceRange;
use App\Models\Restaurant;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get( '/', function () {
    $restaurants_rate = Restaurant::select( 'restaurants.*',
        DB::raw( 'AVG(reviews.rate) as average_rate' ) )
                                  ->join( 'reviews', 'restaurants.id', '=', 'reviews.restaurant_id' )
                                  ->groupBy( 'restaurants.id' )
                                  ->havingRaw( 'COUNT(reviews.id) >= 5' )
                                  ->orderByDesc( 'average_rate' )
                                  ->limit( 6 )
                                  ->get();

    $restaurants_review = Restaurant::select( 'restaurants.*',
        DB::raw( 'AVG(reviews.rate) as average_rate' ) )
                                    ->join( 'reviews', 'restaurants.id', '=', 'reviews.restaurant_id' )
                                    ->groupBy( 'restaurants.id' )
                                    ->orderByDesc( DB::raw( 'COUNT(reviews.id)' ) )
                                    ->take( 6 )
                                    ->get();

    $featured_restaurant = Restaurant::whereNotNull( 'featured_id' )->first();
    $config              = Config::all();

    return view( 'welcome', [
        'restaurants_rate'    => $restaurants_rate,
        'restaurants_review'  => $restaurants_review,
        'featured_restaurant' => $featured_restaurant,
        'config'              => $config,
    ] );
} );
Route::get( '/registers', function () {
    return view( 'registers' );
} )->name( 'registers' );
Route::get( '/registers', function () {
    if (Auth::check()) {
        return redirect('/');
    }
    $food_types   = FoodType::all();
    $price_ranges = PriceRange::all();
    $schedules    = Schedule::all();
    return view( 'registers',
        compact( 'food_types', 'price_ranges', 'schedules' ) );
} )->name( 'registers' );
Route::get( '/welcome', [
    SearchController::class,
    'search_location'
] )->name( 'search_location' );
Route::get( '/top-restaurants', [
    RestaurantController::class,
    'get_most_reviewed_restaurants',
] )->name( 'most_rated_restaurants' );
Route::get( '/user-preferences/location', [
    SearchController::class,
    'search_location',
] )->name( 'users.search.location' );
Route::post( '/registers', [
    UserController::class,
    'create'
] )->name( 'registers' )->middleware( 'guest' );
Route::get( '/registers/location', [
    SearchController::class,
    'search_location',
] )->name( 'registers.search.location' );
Route::get( '/restaurant/{id}', [
    RestaurantController::class,
    'show'
] )->name( 'restaurant' );
Route::get( '/searcher', [
    SearchController::class,
    'search'
] )->name( 'searcher' );

/**
 * Auth routes
 */
Route::middleware( [ 'auth' ] )->group( function () {
    Route::get( '/user-data', [
        UserController::class,
        'show_user_data'
    ] )->name( 'user.edit' );
    Route::put( '/user-data', [
        UserController::class,
        'update'
    ] )->name( 'user.update' );
    Route::delete( '/user-data', [
        UserController::class,
        'remove_user'
    ] )->name( 'user.destroy' );
    Route::get( '/user-preferences', [
        UserFoodPreferenceController::class,
        'show_user_food_preferences',
    ] )->name( 'user-preferences' );
    Route::put( '/user-preferences', [
        UserFoodPreferenceController::class,
        'update_user_preferences',
    ] )->name( 'user_preferences.update' );
    Route::post( '/logout', [
        LoginController::class,
        'logout'
    ] )->name( 'logout' );
    Route::post( '/disable-notification', [
        UserController::class,
        'notice_banning_and_strike_notification',
    ] )->name( 'disable-notification' );
    Route::post( '/restaurant/{restaurant}/review/{updating}', [
        ReviewController::class,
        'store',
    ] )->name( 'review.store' );
    Route::get( '/recommendations', [
        RestaurantController::class,
        'get_recommended_restaurants',
    ] )->name( 'recommended.restaurants' );
    Route::post( '/report', [
        ReportController::class,
        'store'
    ] )->name( 'report.store' );
    Route::get( '/report/{review}', [
        ReportController::class,
        'get_report_view'
    ] )->name( 'report.report' );
} );

/**
 * Admin routes
 */
Route::middleware( [ 'auth', 'admin' ] )->group( function () {
    Route::get( '/admin/pages/index-users', [
        UserController::class,
        'index'
    ] )->name( 'admin.index.users' );
    Route::get( '/admin/pages/create-user', function () {
        $food_types   = FoodType::all();
        $price_ranges = PriceRange::all();
        $schedules    = Schedule::all();
        return view( 'admin.pages.create-user',
            compact( 'food_types', 'price_ranges', 'schedules' ) );
    } )->name( 'admin.create.user' );
    Route::get( '/admin/pages/create-user/location', [
        SearchController::class,
        'search_location',
    ] )->name( 'user.search.location' );
    Route::post( '/admin/pages/create-user', [
        UserController::class,
        'admin_create_user'
    ] )->name( 'create.user' );
    Route::get( '/admin/pages/edit-user/{id}', [
        UserController::class,
        'admin_show_user_data',
    ] )->name( 'admin.edit.user' );
    Route::put( '/admin/pages/edit-user/{id}', [
        UserController::class,
        'admin_update_user',
    ] )->name( 'admin.update.user' );
    Route::delete( '/admin/pages/edit-user/{id}', [
        UserController::class,
        'admin_remove_user',
    ] )->name( 'admin.destroy.user' );
    Route::get( '/admin/pages/index-restaurants', [
        RestaurantController::class,
        'index',
    ] )->name( 'admin.index.restaurants' );
    Route::get( '/admin/pages/create-restaurant', function () {
        $food_types   = FoodType::all();
        $price_ranges = PriceRange::all();
        $schedules    = Schedule::all();
        return view( 'admin.pages.create-restaurant',
            compact( 'food_types', 'price_ranges', 'schedules' ) );
    } )->name( 'admin.create.restaurant' );
    Route::post( '/admin/pages/create-restaurant', [
        RestaurantController::class,
        'create_restaurant',
    ] )->name( 'create.restaurant' );
    Route::get( '/admin/pages/edit-restaurant/{id}', [
        RestaurantController::class,
        'show_restaurant_data',
    ] )->name( 'edit.restaurant' );
    Route::put( '/admin/pages/edit-restaurant/{id}', [
        RestaurantController::class,
        'update_restaurant',
    ] )->name( 'update.restaurant' );
    Route::delete( '/admin/pages/edit-restaurant/{id}', [
        RestaurantController::class,
        'remove_restaurant',
    ] )->name( 'destroy.restaurant' );
    Route::get( '/admin/pages/create-restaurant/location', [
        SearchController::class,
        'search_location',
    ] )->name( 'admin.search.location' );
    Route::get( '/admin/dashboard', [
        AdminController::class,
        'get_dashboard_data',
    ] )->name( 'admin.dashboard' );
    Route::post( '/admin/update-featured-restaurant', [
        AdminController::class,
        'update_featured_restaurant'
    ] );
    Route::get( '/admin/pages/index-reviews', [
        ReviewController::class,
        'index_reviews'
    ] )->name( 'index-reviews' );
    Route::get( '/admin/pages/show-review/{id}', [
        ReviewController::class,
        'show_review'
    ] )->name( 'show-review' );
    Route::delete( '/reviews/{id}', [
        ReviewController::class,
        'delete'
    ] )->name( 'reviews.delete' );
    Route::delete( '/reviews/{id}/strike', [
        ReviewController::class,
        'delete_with_strike',
    ] )->name( 'reviews.delete_with_strike' );
    Route::delete( '/reviews/{id}/dismiss-reports', [
        ReviewController::class,
        'dismiss_reports',
    ] )->name( 'reviews.dismiss_reports' );
    Route::get( '/admin/pages/admin-policy', [
        ConfigController::class,
        'show_admin_policy_config',
    ] )->name( 'admin-policy' );
    Route::put( '/admin/pages/admin-policy', [
        ConfigController::class,
        'update_admin_policy_config',
    ] )->name( 'update.admin-policy' );
    Route::get( '/admin/pages/notifications', [
        NotificationController::class,
        'index'
    ] )->name( 'notifications' );
    Route::get( '/admin/pages/show-notification/{id}', [
        NotificationController::class,
        'show_notification',
    ] )->name( 'show-notification' );
} );
