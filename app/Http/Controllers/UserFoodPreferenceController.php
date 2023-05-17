<?php

namespace App\Http\Controllers;

use App\Libraries\Utilities;
use App\Models\FoodType;
use App\Models\PriceRange;
use App\Models\Schedule;
use App\Models\UserFoodPreference;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserFoodPreferenceController extends Controller {
    /**
     * Show user food preferences on preferences' food view
     *
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application
     * @throws GuzzleException
     */
    public function show_user_food_preferences(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application {
        $user      = Auth::user();
        $latitude  = $user->user_food_preferences->latitude;
        $longitude = $user->user_food_preferences->longitude;
        $terrace   = $user->user_food_preferences->terrace;
        $location  = ( new Utilities )->get_full_address( $latitude, $longitude );

        $user_food_preferences_id = $user->user_food_preferences_id;
        $user_food_preferences    = UserFoodPreference::find( $user_food_preferences_id );

        $food_types   = FoodType::all();
        $price_ranges = PriceRange::all();
        $schedules    = Schedule::all();

        return view( 'user-preferences', compact( 'user', 'user_food_preferences', 'latitude', 'longitude', 'terrace', 'schedules', 'food_types', 'price_ranges', 'location' ) );
    }

    /**
     * Update user food preferences
     *
     * @param Request $request
     *
     * @return RedirectResponse
     * @throws GuzzleException
     */
    public function update_user_preferences( Request $request ): RedirectResponse {
        $validator = Validator::make( $request->all(), [
            'location'     => 'required|max:255',
            'terrace'      => 'required|max:255',
            'schedules'    => 'required|array|min:1',
            'food_types'   => 'required|array|min:1',
            'price_ranges' => 'required|array|min:1',
        ], [
            'location.required'     => 'The location field is mandatory.',
            'location.max'          => 'The location can not have more than 255 characters.',
            'terrace.required'      => 'The terrace field is mandatory.',
            'schedules.required'    => 'The schedules field is mandatory.',
            'schedules.min'         => 'At least, you must pick one schedule.',
            'food_types.required'   => 'The food types field is mandatory.',
            'food_types.min'        => 'At least, you must pick one food type.',
            'price_ranges.required' => 'The price ranges field is mandatory.',
            'price_ranges.min'      => 'At least, you must pick one price range.',
        ] );

        if ( $validator->fails() ) {
            return redirect()->route( 'user_preferences.update' )
                             ->withErrors( $validator )
                             ->withInput();
        }

        $user                  = Auth::user();
        $user_food_preferences = $user->user_food_preferences;

        $location     = $user_food_preferences->location;
        $terrace      = $user_food_preferences->terrace;
        $schedules    = $user_food_preferences->schedules;
        $food_types   = $user_food_preferences->food_types;
        $price_ranges = $user_food_preferences->price_ranges;

        $new_location     = $request->input( 'location' );
        $new_terrace      = $request->input( 'terrace' );
        $new_schedules    = $request->input( 'schedules' );
        $new_food_types   = $request->input( 'food_types' );
        $new_price_ranges = $request->input( 'price_ranges' );

        if ( isset( $new_location ) ) {
            $new_location_lat_long            = ( new Utilities )->get_lat_long( $new_location );
            $user_food_preferences->latitude  = $new_location_lat_long['latitude'];
            $user_food_preferences->longitude = $new_location_lat_long['longitude'];
        } else {
            $user_food_preferences->latitude  = $location->latitude;
            $user_food_preferences->longitude = $location->longitude;
        }

        if ( isset( $new_terrace ) ) {
            $user_food_preferences->terrace = $new_terrace;
        } else {
            $user_food_preferences->terrace = $terrace;
        }

        if ( isset( $new_schedules ) ) {
            $user_food_preferences->schedules()->sync( $new_schedules );
        } else {
            $user_food_preferences->schedules()->sync( $schedules );
        }

        if ( isset( $new_food_types ) ) {
            $user_food_preferences->food_types()->sync( $new_food_types );
        } else {
            $user_food_preferences->food_types()->sync( $food_types );
        }

        if ( isset( $new_price_ranges ) ) {
            $user_food_preferences->price_ranges()->sync( $new_price_ranges );
        } else {
            $user_food_preferences->price_ranges()->sync( $price_ranges );
        }

        $user_food_preferences->save();

        return redirect()->route( 'user-preferences' )->with( 'success', 'Successful update' );
    }
}
