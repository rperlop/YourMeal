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
        $location  = ( new Utilities )->getCityName( $latitude, $longitude );

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
        $user                  = Auth::user();
        $user_food_preferences = $user->user_food_preferences;

        $existingLocation    = $user_food_preferences->location;
        $existingTerrace     = $user_food_preferences->terrace;
        $existingSchedules   = $user_food_preferences->schedules;
        $existingFoodTypes   = $user_food_preferences->food_types;
        $existingPriceRanges = $user_food_preferences->price_ranges;

        $validatedData = $request->validate( [
            'location'       => 'nullable|string|max:255',
            'terrace'        => 'nullable|boolean',
            'schedules'      => 'nullable|array',
            'schedules.*'    => 'sometimes|exists:schedules,id',
            'food_types'     => 'nullable|array',
            'food_types.*'   => 'sometimes|exists:food_types,id',
            'price_ranges'   => 'nullable|array',
            'price_ranges.*' => 'sometimes|exists:price_ranges,id',
        ] );

        if ( isset( $validatedData['location'] ) ) {
            $newLocation                      = $validatedData['location'];
            $newLocationLatLong               = ( new Utilities )->getLatLong( $newLocation );
            $user_food_preferences->latitude  = $newLocationLatLong['latitude'];
            $user_food_preferences->longitude = $newLocationLatLong['longitude'];
        } else {
            $user_food_preferences->latitude  = $existingLocation->latitude;
            $user_food_preferences->longitude = $existingLocation->longitude;
        }

        if ( isset( $validatedData['terrace'] ) ) {
            $user_food_preferences->terrace = $validatedData['terrace'];
        } else {
            $user_food_preferences->terrace = $existingTerrace;
        }

        if ( isset( $validatedData['schedules'] ) ) {
            $user_food_preferences->schedules()->sync( $validatedData['schedules'] );
        } else {
            $user_food_preferences->schedules()->sync( $existingSchedules );
        }

        if ( isset( $validatedData['food_types'] ) ) {
            $user_food_preferences->food_types()->sync( $validatedData['food_types'] );
        } else {
            $user_food_preferences->food_types()->sync( $existingFoodTypes );
        }

        if ( isset( $validatedData['price_ranges'] ) ) {
            $user_food_preferences->price_ranges()->sync( $validatedData['price_ranges'] );
        } else {
            $user_food_preferences->price_ranges()->sync( $existingPriceRanges );
        }

        $user_food_preferences->save();

        return redirect()->route('user-preferences')->with( 'success', 'Successful update' );
    }

}
