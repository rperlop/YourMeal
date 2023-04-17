<?php

namespace App\Http\Controllers;

use App\Models\FoodType;
use App\Models\PriceRange;
use App\Models\Schedule;
use App\Models\User;
use App\Models\UserFoodPreference;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserFoodPreferenceController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $user_food_preferences = $user->user_food_preferences;
        $latitude = $user->user_food_preferences->latitude;
        $longitude = $user->user_food_preferences->longitude;
        $location = $this->getCityName( $latitude, $longitude );
        $schedules = $user->user_food_preferences->schedules;
        $food_types = $user->user_food_preferences->food_types;
        $price_ranges =$user->user_food_preferences->price_ranges;

        return view('user-preferences', compact('user', 'schedules', 'food_types', 'price_ranges'));
    }


    public function update(Request $request)
    {
        $user = Auth::user();
        $userFoodPreference = $user->user_food_preferences;

        // Actualiza las propiedades del modelo UserFoodPreference con los datos enviados por el formulario
        $userFoodPreference->latitude = $request->input('latitude');
        $userFoodPreference->longitude = $request->input('longitude');
        $userFoodPreference->terrace = $request->has('terrace');

        // Actualiza la relación con los horarios de comida seleccionados por el usuario
        $userFoodPreference->userFoodPreferencesHasSchedules()->sync($request->input('schedules'));

        // Actualiza la relación con los tipos de comida seleccionados por el usuario
        $userFoodPreference->userFoodPreferencesHasFoodTypes()->sync($request->input('food_types'));

        // Actualiza la relación con los rangos de precio seleccionados por el usuario
        $userFoodPreference->userFoodPreferencesHasPriceRanges()->sync($request->input('price_ranges'));

        // Guarda los cambios en la base de datos
        $userFoodPreference->save();

        // Redirige al usuario a la página de preferencias con un mensaje de éxito
        return redirect()->route('user-preferences')->with('success', 'Your preferences have been updated!');
    }


    public function getCityName($lat, $long): ?string {
        $apiKey   = 'a82c53d8a743452e9323753bab52a057';
        $client   = new Client();
        $url      = "https://api.opencagedata.com/geocode/v1/json?q=" . urlencode( $lat . ',' . $long ) . "&key=" . $apiKey . "&language=en&pretty=1";
        $response = $client->request( 'GET', $url );
        $body     = json_decode( $response->getBody() );
        if ( $body->total_results > 0 ) {
            $cityName = $body->results[0]->components->city;

            return $cityName;
        } else {
            return null;
        }
    }
}
