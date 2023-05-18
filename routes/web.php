<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserFoodPreferenceController;
use App\Models\FoodType;
use App\Models\PriceRange;
use App\Models\Restaurant;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $restaurants_spa = Restaurant::select('restaurants.*', DB::raw('AVG(reviews.rate) as average_rate'))
                             ->join('reviews', 'restaurants.id', '=', 'reviews.restaurant_id')
                             ->join('restaurant_has_food_types', 'restaurants.id', '=', 'restaurant_has_food_types.restaurant_id')
                             ->join('food_types', 'restaurant_has_food_types.food_type_id', '=', 'food_types.id')
                             ->where('food_types.name', 'Spanish')
                             ->groupBy('restaurants.id')
                             ->orderByDesc('average_rate')
                             ->limit(4)
                             ->get();

    $restaurants_med = Restaurant::select('restaurants.*', DB::raw('AVG(reviews.rate) as average_rate'))
                                 ->join('reviews', 'restaurants.id', '=', 'reviews.restaurant_id')
                                 ->join('restaurant_has_food_types', 'restaurants.id', '=', 'restaurant_has_food_types.restaurant_id')
                                 ->join('food_types', 'restaurant_has_food_types.food_type_id', '=', 'food_types.id')
                                 ->where('food_types.name', 'Mediterranean')
                                 ->groupBy('restaurants.id')
                                 ->orderByDesc('average_rate')
                                 ->limit(4)
                                 ->get();

    $restaurants_bur = Restaurant::select('restaurants.*', DB::raw('AVG(reviews.rate) as average_rate'))
                                 ->join('reviews', 'restaurants.id', '=', 'reviews.restaurant_id')
                                 ->join('restaurant_has_food_types', 'restaurants.id', '=', 'restaurant_has_food_types.restaurant_id')
                                 ->join('food_types', 'restaurant_has_food_types.food_type_id', '=', 'food_types.id')
                                 ->where('food_types.name', 'Burger')
                                 ->groupBy('restaurants.id')
                                 ->orderByDesc('average_rate')
                                 ->limit(4)
                                 ->get();

    $featured_restaurant = Restaurant::whereNotNull('featured_id')->first();

    return view('welcome', ['restaurants_spa' => $restaurants_spa, 'restaurants_med' => $restaurants_med, 'restaurants_bur' => $restaurants_bur, 'featured_restaurant' => $featured_restaurant]);
});

Route::get( '/registers', function () {
    return view( 'registers' );
} )->name( 'registers' );

Route::get( '/registers', function () {
    $food_types = FoodType::all();
    $price_ranges = PriceRange::all();
    $schedules = Schedule::all();
    return view( 'registers', compact( 'food_types', 'price_ranges', 'schedules' ) );
} )->name( 'registers' )->middleware( 'guest' );

Route::get( '/user-data', [ UserController::class, 'show_user_data' ] )->name( 'user.edit' )->middleware( 'auth' );
Route::put( '/user-data', [ UserController::class, 'update' ] )->name( 'user.update' )->middleware( 'auth' );
Route::delete( '/user-data', [ UserController::class, 'remove_user' ] )->name( 'user.destroy' )->middleware( 'auth' );

Route::get( '/user-preferences', [
    UserFoodPreferenceController::class,
    'show_user_food_preferences',
] )->name( 'user-preferences' )->middleware( 'auth' );
Route::put( '/user-preferences', [
    UserFoodPreferenceController::class,
    'update_user_preferences',
] )->name( 'user_preferences.update' )->middleware( 'auth' );

Route::get( '/welcome', [ SearchController::class, 'search_location' ] )->name( 'search_location' );
Route::get( '/top-restaurants', [ RestaurantController::class, 'get_most_reviewed_restaurants' ] )->name( 'most_rated_restaurants' );
Route::get( '/user-preferences/location', [ SearchController::class, 'search_location' ] )->name( 'users.search.location' );

Route::post( '/registers', [ UserController::class, 'create' ] )->name( 'registers' )->middleware( 'guest' );
Route::get( '/registers/location', [ SearchController::class, 'search_location' ] )->name( 'registers.search.location' );

Route::post( '/logout', [ LoginController::class, 'logout' ] )->name( 'logout' );

Auth::routes();

Route::get( '/home', [ App\Http\Controllers\HomeController::class, 'index' ] )->name( 'home' );

Route::get( '/restaurant/{id}', [ RestaurantController::class, 'show' ] )->name( 'restaurant' );

Route::get( '/recommendations', [ RestaurantController::class, 'get_recommended_restaurants' ] )->name( 'recommended.restaurants' )->middleware( 'auth' );


Route::get( '/report/{review}', [ ReportController::class, 'create' ] )->name('report.report')->middleware( 'auth' );
Route::post( '/report', [ ReportController::class, 'store' ] )->name('report.store')->middleware( 'auth' );

/*Route::post('/restaurant/{restaurant}/review/{updating}', [ReviewController::class, 'store'])->name('review.store')->middleware('auth');*/


Route::get( '/searcher', [ SearchController::class, 'search' ] )->name( 'searcher' );

Route::post('/restaurant/{restaurant}/review/{updating}', [ReviewController::class, 'store'])->name('review.store')->middleware('auth');

Route::middleware( [ 'auth', 'admin' ] )->group( function () {
    Route::get( '/admin/pages/index-users', [ UserController::class, 'index' ] )->name('admin.index.users');
    Route::get( '/admin/pages/create-user', function () {
        $food_types = FoodType::all();
        $price_ranges = PriceRange::all();
        $schedules = Schedule::all();
        return view( 'admin.pages.create-user', compact( 'food_types', 'price_ranges', 'schedules' ));
    } )->name( 'admin.create.user' );
    Route::get( '/admin/pages/create-user/location', [ SearchController::class, 'search_location' ] )->name( 'user.search.location' );
    Route::post( '/admin/pages/create-user', [ UserController::class, 'admin_create_user' ] )->name( 'create.user' );
    Route::get( '/admin/pages/edit-user/{id}', [ UserController::class, 'admin_show_user_data' ] )->name( 'admin.edit.user' );
    Route::put( '/admin/pages/edit-user/{id}', [ UserController::class, 'admin_update_user' ] )->name( 'admin.update.user' );
    Route::delete( '/admin/pages/edit-user/{id}', [ UserController::class, 'admin_remove_user' ] )->name( 'admin.destroy.user' );
    Route::get( '/admin/pages/index-restaurants', [ RestaurantController::class, 'index' ] )->name('admin.index.restaurants');
    Route::get( '/admin/pages/create-restaurant', function () {
        $food_types = FoodType::all();
        $price_ranges = PriceRange::all();
        $schedules = Schedule::all();
        return view( 'admin.pages.create-restaurant', compact( 'food_types', 'price_ranges', 'schedules' ));
    } )->name( 'admin.create.restaurant' );
    Route::post( '/admin/pages/create-restaurant', [ RestaurantController::class, 'create_restaurant' ] )->name( 'create.restaurant' );
    Route::get( '/admin/pages/edit-restaurant/{id}', [ RestaurantController::class, 'show_restaurant_data' ] )->name( 'edit.restaurant' );
    Route::put( '/admin/pages/edit-restaurant/{id}', [ RestaurantController::class, 'update_restaurant' ] )->name( 'update.restaurant' );
    Route::delete( '/admin/pages/edit-restaurant/{id}', [ RestaurantController::class, 'remove_restaurant' ] )->name( 'destroy.restaurant' );
    Route::get( '/admin/pages/create-restaurant/location', [ SearchController::class, 'search_location' ] )->name( 'admin.search.location' );
    Route::get('/admin/dashboard', [AdminController::class, 'stats'])->name('admin.dashboard');
    Route::post('/admin/update-featured-restaurant', [AdminController::class, 'update_featured_restaurant' ]);
} );
