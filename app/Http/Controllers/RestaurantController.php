<?php

namespace App\Http\Controllers;

use App\Utils\Utilities;
use App\Models\FoodType;
use App\Models\PriceRange;
use App\Models\Restaurant;
use App\Models\Review;
use App\Models\Schedule;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RestaurantController extends Controller {
    /**
     * Show all the data of a specific restaurant on the client web
     *
     * @param integer $id
     *
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application
     */
    public function show( int $id ): Factory|Application|View|\Illuminate\Contracts\Foundation\Application {
        $restaurant = Restaurant::findOrFail( $id );

        $has_terrace = $restaurant->terrace ? 'Yes' : 'No';

        $price_range = $restaurant->price_range->range;

        $food_types = $restaurant->food_types()->pluck( 'name' )->toArray();

        $schedules = $restaurant->schedules()->get();

        $user_has_review     = false;
        $user_review_in_page = false;
        $user_review         = null;

        if ( Auth::check() ) {
            $user            = Auth::user();
            $user_has_review = Review::where( 'restaurant_id', $restaurant->id )->where( 'user_id', $user->id )->exists();
            if ( $user_has_review ) {
                $reviews     = Review::where( 'restaurant_id', $restaurant->id );
                $user_review = Review::where( 'restaurant_id', $restaurant->id )->where( 'user_id', $user->id );
                $reviews     = $user_review->union( $reviews )->simplePaginate( 5 );
                $user_review = $user_review->first();
                if ( $reviews->currentPage() == 1 ) {
                    $user_review_in_page = true;
                }
            } else {
                $reviews = Review::where( 'restaurant_id', $restaurant->id )->simplePaginate( 5 );
            }
        } else {
            $reviews = Review::where( 'restaurant_id', $restaurant->id )->simplePaginate( 5 );
        }

        $total_reviews = Review::where( 'restaurant_id', $restaurant->id )->get();
        $count         = $total_reviews->count();

        if ( $count > 0 ) {
            $avg_rating = round( $total_reviews->avg( 'rate' ), 1 );
        } else {
            $avg_rating = 0;
        }

        $data = [
            'restaurant'          => $restaurant,
            'price_range'         => $price_range,
            'has_terrace'         => $has_terrace,
            'food_types'          => $food_types,
            'schedules'           => $schedules,
            'reviews'             => $reviews,
            'avg_rating'          => $avg_rating,
            'user_has_review'     => $user_has_review,
            'user_review_in_page' => $user_review_in_page,
            'user_review'         => $user_review,
        ];

        return view( 'restaurant', $data );
    }

    /**
     * Index all restaurants on the admin panel
     *
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application {
        $restaurants = Restaurant::all();

        return view( 'admin.pages.index-restaurants', compact( 'restaurants' ) );
    }

    /**
     * Show the data of a specific restaurant on the admin panel
     *
     * @param integer $id
     *
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application
     * @throws GuzzleException
     */
    public function show_restaurant_data( int $id ): Factory|Application|View|\Illuminate\Contracts\Foundation\Application {
        $restaurant   = Restaurant::findOrFail( $id );
        $has_terrace  = $restaurant->terrace ? 'Yes' : 'No';
        $price_ranges = PriceRange::all();

        $food_types = FoodType::all();
        $schedules  = Schedule::all();

        $selected_food_types  = $restaurant->food_types()->pluck( 'food_types.id' )->toArray();
        $selected_schedules   = $restaurant->schedules()->pluck( 'schedules.id' )->toArray();
        $selected_price_range = $restaurant->price_range_id;

        $location = ( new Utilities )->get_full_address( $restaurant->latitude, $restaurant->longitude );

        return view( 'admin/pages/edit-restaurant' )
            ->with( 'restaurant', $restaurant )
            ->with( 'price_ranges', $price_ranges )
            ->with( 'has_terrace', $has_terrace )
            ->with( 'food_types', $food_types )
            ->with( 'schedules', $schedules )
            ->with( 'selected_food_types', $selected_food_types )
            ->with( 'selected_schedules', $selected_schedules )
            ->with( 'selected_price_range', $selected_price_range )
            ->with( 'location', $location );
    }

    /**
     * Create a new restaurant on admin panel
     *
     * @param Request $request
     *
     * @return RedirectResponse
     * @throws GuzzleException
     */
    protected function create_restaurant( Request $request ): RedirectResponse {
        $validator = Validator::make( $request->all(), [
            'name'           => 'required|max:255',
            'address'        => 'required|max:255',
            'description'    => 'required|max:400',
            'web'            => 'required|max:255',
            'email'          => 'required|email|unique:restaurants,email,',
            'phone_number'   => 'required',
            'location'       => 'required|max:255',
            'terrace'        => 'required|max:255',
            'schedules'      => 'required|array|min:1',
            'food_types'     => 'required|array|min:1',
            'price_ranges'   => 'required|array|min:1',
            'main_image_url' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',

        ], [
            'name.required'           => 'The name field is mandatory.',
            'name.max'                => 'The name can not have more than 255 characters.',
            'address.required'        => 'The address field is mandatory.',
            'address.max'             => 'The address can not have more than 255 characters.',
            'description.required'    => 'The description field is mandatory.',
            'description.max'         => 'The description can not have more than 400 characters.',
            'web.required'            => 'The web field is mandatory.',
            'web.max'                 => 'The web can not have more than 255 characters.',
            'phone_number.required'   => 'The phone number field is mandatory.',
            'phone_number.max'        => 'The phone number can not have more than 255 characters.',
            'email.required'          => 'The email field is mandatory.',
            'email.email'             => 'The email has to have an email format.',
            'email.unique'            => 'This email is already used.',
            'location.required'       => 'The location field is mandatory.',
            'location.max'            => 'The location can not have more than 255 characters.',
            'terrace.required'        => 'The terrace field is mandatory.',
            'schedules.required'      => 'The schedules field is mandatory.',
            'schedules.min'           => 'At least, you must pick one schedule.',
            'food_types.required'     => 'The food types field is mandatory.',
            'food_types.min'          => 'At least, you must pick one food type.',
            'price_ranges.required'   => 'The price ranges field is mandatory.',
            'price_ranges.min'        => 'At least, you must pick one price range.',
            'main_image_url.required' => 'You must upload an image of the restaurant.',
            'main_image_url.format'   => 'You must upload a correct image format',
            'main_image_url.max'      => 'The image size can not exceed 2MB.',
        ] );

        if ( $validator->fails() ) {
            return redirect()->route( 'create.restaurant' )
                             ->withErrors( $validator )
                             ->withInput();
        }

        $location = $request['location'];
        $lat_long = ( new Utilities )->get_lat_long( $location );
        if ( $lat_long == null ) {
            return back()->withErrors( [ 'location' => 'It does not exist the address' ] );
        }

        $restaurant = new Restaurant;
        $restaurant->setAttribute( 'name', $request['name'] );
        $restaurant->setAttribute( 'address', $request['address'] );
        $restaurant->setAttribute( 'web', $request['web'] );
        $restaurant->setAttribute( 'phone_number', $request['phone_number'] );
        $restaurant->setAttribute( 'email', $request['email'] );
        $restaurant->setAttribute( 'description', $request['description'] );
        $price_range_id = $request->input( 'price_ranges' )[0];
        $restaurant->setAttribute( 'price_range_id', $price_range_id );
        $restaurant->setAttribute( 'terrace', $request['terrace'] );
        $restaurant->setAttribute( 'latitude', $lat_long['latitude'] );
        $restaurant->setAttribute( 'longitude', $lat_long['longitude'] );

        if ( $request->hasFile( 'main_image_url' ) ) {
            $image    = $request->file( 'main_image_url' );
            $filename = time() . '-' . $image->getClientOriginalName();
            $image->storeAs( 'public/img/restaurants', $filename );
            $url = 'img/restaurants/' . $filename;
            $restaurant->setAttribute( 'main_image_url', $url );
        }

        $restaurant->save();

        if ( isset( $request['food_types'] ) ) {
            $restaurant->food_types()->sync( $request['food_types'] );
        }

        if ( isset( $request['schedules'] ) ) {
            $restaurant->schedules()->sync( $request['schedules'] );
        }

        return redirect()->route( 'admin.index.restaurants' )->with( 'success', 'Restaurant created' );
    }

    /**
     * Update a restaurant on the admin panel
     *
     * @param Request $request
     * @param integer $id
     *
     * @return RedirectResponse
     * @throws GuzzleException
     */
    protected function update_restaurant( Request $request, int $id ): RedirectResponse {
        $validator = Validator::make( $request->all(), [
            'name'             => 'required|max:255',
            'address'          => 'required|max:255',
            'description'      => 'required|max:400',
            'web'              => 'required|max:255',
            'email'            => 'required|email|unique:restaurants,email,' . $id,
            'phone_number'     => 'required',
            'location'         => 'required|max:255',
            'terrace'          => 'required|max:255',
            'schedules'        => 'required|array|min:1',
            'food_types'       => 'required|array|min:1',
            'price_range_id'   => 'required',
            'main_image.url.*' => 'nullable|image|max:2048',

        ], [
            'name.required'         => 'The name field is mandatory.',
            'name.max'              => 'The name can not have more than 255 characters.',
            'address.required'      => 'The address field is mandatory.',
            'address.max'           => 'The address can not have more than 255 characters.',
            'description.required'  => 'The description field is mandatory.',
            'description.max'       => 'The description can not have more than 400 characters.',
            'web.required'          => 'The web field is mandatory.',
            'web.max'               => 'The web can not have more than 255 characters.',
            'phone_number.required' => 'The phone number field is mandatory.',
            'phone_number.max'      => 'The phone number can not have more than 255 characters.',
            'email.required'        => 'The email field is mandatory.',
            'email.email'           => 'The email has to have an email format.',
            'email.unique'          => 'This email is already used.',
            'location.required'     => 'The location field is mandatory.',
            'location.max'          => 'The location can not have more than 255 characters.',
            'terrace.required'      => 'The terrace field is mandatory.',
            'schedules.required'    => 'The schedules field is mandatory.',
            'schedules.min'         => 'At least, you must pick one schedule.',
            'food_types.required'   => 'The food types field is mandatory.',
            'food_types.min'        => 'At least, you must pick one food type.',
            'price_ranges.required' => 'The price ranges field is mandatory.',
        ] );

        if ( $validator->fails() ) {
            return redirect()->route( 'edit.restaurant', $id )
                             ->withErrors( $validator )
                             ->withInput();
        }

        $location = $request['location'];
        $lat_long = ( new Utilities )->get_lat_long( $location );
        if ( $lat_long == null ) {
            return back()->withErrors( [ 'location' => 'It does not exist the address' ] );
        }

        $restaurant                 = Restaurant::findOrFail( $id );
        $restaurant->name           = $request['name'];
        $restaurant->address        = $request['address'];
        $restaurant->web            = $request['web'];
        $restaurant->phone_number   = $request['phone_number'];
        $restaurant->email          = $request['email'];
        $restaurant->description    = $request['description'];
        $restaurant->price_range_id = $request['price_range_id'];
        $restaurant->terrace        = $request['terrace'];
        $restaurant->latitude       = $lat_long['latitude'];
        $restaurant->longitude      = $lat_long['longitude'];

        if ( $request->hasFile( 'main_image_url' ) ) {
            Storage::disk( 'public' )->delete( $restaurant->main_image_url );
            $image    = $request->file( 'main_image_url' );
            $filename = time() . '-' . $image->getClientOriginalName();
            $image->storeAs( 'public/img/restaurants', $filename );
            $url = 'img/restaurants/' . $filename;
            $restaurant->setAttribute( 'main_image_url', $url );
        }

        $restaurant->save();

        $restaurant->food_types()->sync( $request['food_types'] );
        $restaurant->schedules()->sync( $request['schedules'] );

        return redirect()->route( 'update.restaurant', $restaurant->id )->with( 'success', 'Restaurant updated' );
    }

    /**
     * Remove a restaurant
     *
     * @param $id
     *
     * @return RedirectResponse
     */
    public function remove_restaurant( $id ): RedirectResponse {
        $restaurant = Restaurant::findOrFail( $id );

        $restaurant->reviews()->each( function ( $review ) {
            $review->images()->delete();
        } );

        $restaurant->reviews()->delete();

        $restaurant->delete();

        return redirect()->route( 'admin.index.restaurants' )->with( 'success', 'Restaurant removed' );
    }

    /**
     * Get the most reviewed restaurants
     *
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application
     */
    public function get_most_reviewed_restaurants( $food_type ): Factory|Application|View|\Illuminate\Contracts\Foundation\Application {
        $restaurants = Restaurant::select( 'restaurants.*', DB::raw( 'AVG(reviews.rate) as average_rate' ) )
                                 ->join( 'reviews', 'restaurants.id', '=', 'reviews.restaurant_id' )
                                 ->join( 'restaurant_has_food_types', 'restaurants.id', '=', 'restaurant_has_food_types.restaurant_id' )
                                 ->join( 'food_types', 'restaurant_has_food_types.food_type_id', '=', 'food_types.id' )
                                 ->where( 'food_types.name', $food_type )
                                 ->groupBy( 'restaurants.id' )
                                 ->orderByDesc( 'average_rate' )
                                 ->limit( 4 )
                                 ->get();

        return view( 'top-restaurants' )->with( 'restaurants', $restaurants );
    }

    /**
     * Get a list of recommended restaurants for a user
     *
     * @return \Illuminate\Contracts\Foundation\Application|Application|Factory|View
     */
    public function get_recommended_restaurants(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application {
        $userId = Auth::id();

        $userFoodPreferences = DB::table( 'user_food_preferences' )
                                 ->join( 'user_food_preferences_has_food_types', 'user_food_preferences.id', '=', 'user_food_preferences_has_food_types.user_food_preference_id' )
                                 ->join( 'food_types', 'user_food_preferences_has_food_types.food_type_id', '=', 'food_types.id' )
                                 ->join( 'users', 'users.user_food_preferences_id', '=', 'user_food_preferences.id' )
                                 ->where( 'users.id', $userId )
                                 ->pluck( 'food_types.id' );

        $userFoodPreferencesSchedules = DB::table( 'user_food_preferences' )
                                          ->join( 'user_food_preferences_has_schedules', 'user_food_preferences.id', '=', 'user_food_preferences_has_schedules.user_food_preference_id' )
                                          ->join( 'schedules', 'user_food_preferences_has_schedules.schedule_id', '=', 'schedules.id' )
                                          ->join( 'users', 'users.user_food_preferences_id', '=', 'user_food_preferences.id' )
                                          ->where( 'users.id', $userId )
                                          ->pluck( 'schedules.id' );

        $userFoodPreferencesPriceRange = DB::table( 'user_food_preferences' )
                                           ->join( 'user_food_preferences_has_price_ranges', 'user_food_preferences.id', '=', 'user_food_preferences_has_price_ranges.user_food_preference_id' )
                                           ->join( 'price_ranges', 'user_food_preferences_has_price_ranges.price_range_id', '=', 'price_ranges.id' )
                                           ->join( 'users', 'users.user_food_preferences_id', '=', 'user_food_preferences.id' )
                                           ->where( 'users.id', $userId )
                                           ->pluck( 'price_ranges.id' );

        $userFoodPreferencesLocation = DB::table( 'user_food_preferences' )
                                         ->join( 'users', 'users.user_food_preferences_id', '=', 'user_food_preferences.id' )
                                         ->where( 'users.id', $userId )
                                         ->select( 'user_food_preferences.latitude', 'user_food_preferences.longitude' )
                                         ->first();

        $latitude  = $userFoodPreferencesLocation->latitude;
        $longitude = $userFoodPreferencesLocation->longitude;

        $restaurants = DB::table( 'restaurants' )
                         ->select( 'restaurants.*' )
                         ->selectRaw( '(6371 * acos(cos(radians(' . $latitude . ')) * cos(radians(restaurants.latitude)) * cos(radians(restaurants.longitude) - radians(' . $longitude . ')) + sin(radians(' . $latitude . ')) * sin(radians(restaurants.latitude)))) AS distance' )
                         ->whereExists( function ( $query ) use ( $userFoodPreferences ) {
                             $query->select( DB::raw( 1 ) )
                                   ->from( 'restaurant_has_food_types' )
                                   ->whereIn( 'food_type_id', $userFoodPreferences )
                                   ->whereRaw( 'restaurant_has_food_types.restaurant_id = restaurants.id' );
                         } )
                         ->whereNotExists( function ( $query ) use ( $userId ) {
                             $query->select( DB::raw( 1 ) )
                                   ->from( 'reviews' )
                                   ->where( 'reviews.user_id', $userId )
                                   ->whereRaw( 'reviews.restaurant_id = restaurants.id' );
                         } )
                         ->whereExists( function ( $query ) use ( $userFoodPreferencesSchedules ) {
                             $query->select( DB::raw( 1 ) )
                                   ->from( 'restaurant_has_schedules' )
                                   ->whereIn( 'schedule_id', $userFoodPreferencesSchedules )
                                   ->whereRaw( 'restaurant_has_schedules.restaurant_id = restaurants.id' );
                         } )
                         ->where( function ( $query ) use ( $userFoodPreferencesPriceRange ) {
                             $query->whereIn( 'price_range_id', $userFoodPreferencesPriceRange );
                         } )
                         ->having( 'distance', '<=', 5 ) // Filtrar por distancia <= 5 km
                         ->orderBy( 'distance', 'asc' )
                         ->get();

        $restaurantIds = $restaurants->pluck( 'id' );

        $rates = DB::table( 'reviews' )
                   ->whereIn( 'restaurant_id', $restaurantIds )
                   ->select( 'restaurant_id', DB::raw( 'AVG(rate) as average_rating' ) )
                   ->groupBy( 'restaurant_id' )
                   ->get();

        $restaurants = $restaurants->map( function ( $restaurant ) use ( $rates ) {
            $rate                       = $rates->where( 'restaurant_id', $restaurant->id )->first();
            $restaurant->average_rating = $rate ? $rate->average_rating : null;

            return $restaurant;
        } );

        $restaurants = $restaurants->sortByDesc( 'average_rating' )->take( 5 );

        return view( '/recommendations', [
            'recommendations' => $restaurants,
        ] );
    }
}
