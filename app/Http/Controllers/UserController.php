<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserFoodPreference;
use GuzzleHttp\Client;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
    protected function create( Request $request ): Application|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse {
        $requestData = $request->all();

        $location = $requestData['location'];
        $latLong  = $this->getLatLong( $location );
        if ( $latLong == null ) {
            return back()->withErrors( [ 'location' => 'It does not exist the city' ] );
        }

        $userFoodPreference = new UserFoodPreference;
        $userFoodPreference->setAttribute( 'terrace', $requestData['terrace'] );
        $userFoodPreference->setAttribute( 'latitude', $latLong['lat'] );
        $userFoodPreference->setAttribute( 'longitude', $latLong['long'] );
        $userFoodPreference->save();
        $userFoodPreferenceId = $userFoodPreference->id;

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

    public function edit(): \Illuminate\Contracts\View\Factory|Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        $user = Auth::user(); // Obtener el usuario autenticado

        return view( 'user-data', compact( 'user' ) );
    }

    public function update( Request $request ): RedirectResponse {
        $user = Auth::user(); // Obtener el usuario autenticado
        $user->fill( $request->all() );
        $user->save();

        return redirect()->route( 'user.edit' )->with( 'success', 'Los cambios han sido guardados.' );
    }

    /**
     * Remove a user and all his food preferences
     *
     * @return RedirectResponse
     */
    public function remove_user(): RedirectResponse {
        $user = Auth::user();

        $userFoodPreference = $user->user_food_preferences;

        $userFoodPreference->schedules()->detach();
        $userFoodPreference->food_types()->detach();
        $userFoodPreference->price_ranges()->detach();

        $user->user_food_preferences_id = null;
        $user->save();

        $userFoodPreference->delete();

        $user->delete();

        Auth::logout();

        return redirect()->route('login')->with('success', 'User removed');
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
