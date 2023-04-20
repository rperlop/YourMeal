<?php

namespace App\Http\Controllers;

use App\Models\FoodType;
use App\Models\PriceRange;
use App\Models\Schedule;
use App\Models\UserFoodPreference;
use GuzzleHttp\Client;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class UserFoodPreferenceController extends Controller {
    /**
     * Show user food preferences on preferences food view
     *
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application
     */
    public function show_user_food_preferences(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application {
        $user = Auth::user();
        $latitude = $user->user_food_preferences->latitude;
        $longitude = $user->user_food_preferences->longitude;
        $terrace = $user->user_food_preferences->terrace;
        $location = $this->getCityName($latitude, $longitude);

        $user_food_preferences_id = $user->user_food_preferences_id;
        $user_food_preferences = UserFoodPreference::find($user_food_preferences_id);

        $food_types = FoodType::all();
        $price_ranges = PriceRange::all();
        $schedules = Schedule::all();

        return view('user-preferences', compact('user', 'user_food_preferences', 'latitude', 'longitude', 'terrace', 'schedules', 'food_types', 'price_ranges', 'location'));
    }


    public function update(Request $request)
    {
        $user = Auth::user();
        $userFoodPreference = $user->user_food_preferences;

        // Obtén la latitud y longitud a partir del nombre de la ciudad
        $location = $request->input('location');
        $latLong = $this->getLatLong($location);

        // Verifica que se haya obtenido la latitud y longitud correctamente
        if ($latLong) {
            // Actualiza las propiedades del modelo UserFoodPreference con los datos obtenidos
            $userFoodPreference->latitude = $latLong['latitude'];
            $userFoodPreference->longitude = $latLong['longitude'];
        }

        // Actualiza las demás propiedades del modelo UserFoodPreference con los datos enviados por el formulario
        $userFoodPreference->terrace = $request->has('terrace');

        // Guarda los cambios en la base de datos
        $userFoodPreference->save();

        // Actualiza la relación con los horarios de comida seleccionados por el usuario
        $userFoodPreference->schedules()->sync($request->input('schedules'));

        // Actualiza la relación con los tipos de comida seleccionados por el usuario
        $userFoodPreference->food_types()->sync($request->input('food_types'));

        // Actualiza la relación con los rangos de precio seleccionados por el usuario
        $userFoodPreference->price_ranges()->sync($request->input('price_ranges'));

        // Redirige al usuario a la página de preferencias con un mensaje de éxito
        return redirect()->route('user-preferences')->with('success', 'Your preferences have been updated!');
    }



    public function getCityName($lat, $long): ?string {
        $apiKey = 'a82c53d8a743452e9323753bab52a057';
        $client = new Client();
        $url = "https://api.opencagedata.com/geocode/v1/json?q=" . urlencode($lat . ',' . $long) . "&key=" . $apiKey . "&language=en&pretty=1";
        $response = $client->request('GET', $url);
        $body = json_decode($response->getBody());

        if ($body->total_results > 0) {
            $cityName = $body->results[0]->components->city ?? null;
            return $cityName;
        } else {
            return null;
        }
    }

    public function getLatLong( $location ): ?array {
        $apiKey   = 'a82c53d8a743452e9323753bab52a057';
        $client   = new Client();
        $url      = "https://api.opencagedata.com/geocode/v1/json?q=" . urlencode( $location ) . "&key=" . $apiKey . "&language=en&pretty=1";
        $response = $client->request( 'GET', $url );
        $body     = json_decode( $response->getBody() );
        if ( $body->total_results > 0 ) {
            $latitude = $body->results[0]->geometry->lat;
            $longitude = $body->results[0]->geometry->lng;

            return [ 'latitude' => $latitude, 'longitude' => $longitude ];
        } else {
            return null;
        }
    }
}
