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
    public function update_user_preferences(Request $request): RedirectResponse {
        $user = Auth::user();
        $user_food_preferences = $user->user_food_preferences;

        $existingLocation = $user_food_preferences->location;
        $existingTerrace = $user_food_preferences->terrace;
        $existingSchedules = $user_food_preferences->schedules;
        $existingFoodTypes = $user_food_preferences->food_types;
        $existingPriceRanges = $user_food_preferences->price_ranges;

        $newLocation = $request->input('location');
        $newTerrace = $request->input('terrace');
        $newSchedules = $request->input('schedules');
        $newFoodTypes = $request->input('food_types');
        $newPriceRanges = $request->input('price_ranges');

        if (isset($newLocation)) {
            $newLocationLatLong = (new Utilities)->getLatLong($newLocation);
            $user_food_preferences->latitude = $newLocationLatLong['latitude'];
            $user_food_preferences->longitude = $newLocationLatLong['longitude'];
        } else {
            $user_food_preferences->latitude = $existingLocation->latitude;
            $user_food_preferences->longitude = $existingLocation->longitude;
        }

        if (isset($newTerrace)) {
            $user_food_preferences->terrace = $newTerrace;
        } else {
            $user_food_preferences->terrace = $existingTerrace;
        }

        if (isset($newSchedules)) {
            $user_food_preferences->schedules()->sync($newSchedules);
        } else {
            $user_food_preferences->schedules()->sync($existingSchedules);
        }

        if (isset($newFoodTypes)) {
            $user_food_preferences->food_types()->sync($newFoodTypes);
        } else {
            $user_food_preferences->food_types()->sync($existingFoodTypes);
        }

        if (isset($newPriceRanges)) {
            $user_food_preferences->price_ranges()->sync($newPriceRanges);
        } else {
            $user_food_preferences->price_ranges()->sync($existingPriceRanges);
        }

        $user_food_preferences->save();

        return redirect()->route('user-preferences')->with('success', 'Successful update');
    }

}
