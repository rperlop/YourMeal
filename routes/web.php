<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserFoodPreferenceController;
use App\Models\FoodType;
use App\Models\PriceRange;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get( '/', function () {
    return view( 'welcome' );
} );

Route::get( '/registers', function () {
    return view( 'registers' );
} );

Route::get( '/registers', function () {
    $foodTypes = FoodType::all();
    $priceRanges = PriceRange::all();
    $schedules = Schedule::all();

    return view( 'registers', compact( 'foodTypes', 'priceRanges', 'schedules' ) );
} );

Route::get( '/user-data', [ UserController::class, 'edit' ] )->name( 'user.edit' )->middleware( 'auth' );
Route::put( '/user-data', [ UserController::class, 'update' ] )->name( 'user.update' )->middleware( 'auth' );
Route::delete( '/user-data', [ UserController::class, 'destroy' ] )->name( 'user.destroy' )->middleware( 'auth' );

Route::get( '/user-preferences', [
    UserFoodPreferenceController::class,
    'edit',
] )->name( 'user.edit' )->middleware( 'auth' );
Route::put( '/user-preferences', [
    UserFoodPreferenceController::class,
    'update',
] )->name( 'user-preferences.update' )->middleware( 'auth' );

Route::post( '/registers', [ UserController::class, 'create' ] );

Route::post( '/logout', [ LoginController::class, 'logout' ] )->name( 'logout' );

Route::get( '/search', [ SearchController::class, 'search' ] )->name( 'search' );

//Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//Route::post('/register', 'Auth\RegisterController@register');

Auth::routes();

Route::get( '/home', [ App\Http\Controllers\HomeController::class, 'index' ] )->name( 'home' );

Route::get('/restaurant', [RestaurantController::class, 'show'])->name('restaurant.show');
