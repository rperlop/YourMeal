<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserFoodPreference;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
    protected function create( Request $request ): \Illuminate\Foundation\Application|\Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse {
        $requestData = $request->all();

        // Buscamos latitud y longitud de la ciudad
        $location = $requestData['location'];
        $latLong  = $this->getLatLong( $location );
        if ( $latLong == null ) {
            return back()->withErrors( [ 'city' => 'No se pudo encontrar la ciudad o pueblo ingresado' ] );
        }

        // Creamos nuevo registro en la tabla user_food_preferences
        $userFoodPreference = new UserFoodPreference;
        $userFoodPreference->setAttribute( 'terrace', $requestData['terrace'] );
        $userFoodPreference->setAttribute( 'latitude', $latLong['lat'] );
        $userFoodPreference->setAttribute( 'longitude', $latLong['long'] );
        $userFoodPreference->save();
        $userFoodPreferenceId = $userFoodPreference->id;

        // Creamos nuevo usuario y lo vinculamos con el registro en la tabla user_food_preferences
        $user = new User;
        $user->setAttribute( 'first_name', $requestData['first_name'] );
        $user->setAttribute( 'last_name', $requestData['last_name'] );
        $user->setAttribute( 'email', $requestData['email'] );
        $user->setAttribute( 'password', Hash::make( $requestData['password'] ) );
        $user->user_food_preferences_id = $userFoodPreferenceId;
        $user->save();

        if ( isset( $requestData['price_ranges'] ) ) {
            $userFoodPreference->price_ranges()->sync( $requestData['price_ranges'] );
        }

        if ( isset( $requestData['food_types'] ) ) {
            $userFoodPreference->food_types()->sync( $requestData['food_types'] );
        }

        if ( isset( $requestData['schedules'] ) ) {
            $userFoodPreference->schedules()->sync( $requestData['schedules'] );
        }

        Auth::login($user);

        return redirect('/')->with('user');
    }

    public function edit(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        $user = Auth::user(); // Obtener el usuario autenticado

        return view( 'user-data', compact( 'user' ) );
    }

    public function update( Request $request ): \Illuminate\Http\RedirectResponse {
        $user = Auth::user(); // Obtener el usuario autenticado
        $user->fill( $request->all() );
        $user->save();

        return redirect()->route( 'user.edit' )->with( 'success', 'Los cambios han sido guardados.' );
    }

    public function destroy(): \Illuminate\Http\RedirectResponse {
        $user = Auth::user(); // Obtener el usuario autenticado

        // Obtén la instancia del modelo UserFoodPreference asociada al usuario
        $userFoodPreference = $user->user_food_preferences;

        // Elimina los registros asociados a través de las relaciones muchos a muchos
        $userFoodPreference->schedules()->detach();
        $userFoodPreference->food_types()->detach();
        $userFoodPreference->price_ranges()->detach();

        // Borra el registro de preferencias de comida del usuario
        $userFoodPreference->delete();

        // Borra el registro del usuario autenticado
        $user->delete();

        Auth::logout();

        return redirect()->route('login')->with('success', 'Tu cuenta ha sido eliminada.');
    }


    public function getLatLong( $location ): ?array {
        $apiKey   = 'a82c53d8a743452e9323753bab52a057';
        $client   = new Client();
        $url      = "https://api.opencagedata.com/geocode/v1/json?q=" . urlencode( $location ) . "&key=" . $apiKey . "&language=en&pretty=1";
        $response = $client->request( 'GET', $url );
        $body     = json_decode( $response->getBody() );
        if ( $body->total_results > 0 ) {
            $lat  = $body->results[0]->geometry->lat;
            $long = $body->results[0]->geometry->lng;

            return [ 'lat' => $lat, 'long' => $long ];
        } else {
            return null;
        }
    }
}
