<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\UserFoodPreference;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;

class RegisterController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default, this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware( 'guest' );
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator( array $data ) {
        return Validator::make( $data, [
            'first_name' => [ 'required', 'string', 'max:255' ],
            'last_name'  => [ 'required', 'string', 'max:255' ],
            'email'      => [ 'required', 'string', 'email', 'max:255', 'unique:users' ],
            'password'   => [ 'required', 'string', 'min:8', 'confirmed' ],
        ] );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return RedirectResponse
     */
    protected function create( array $data ) {
        //Creamos nuevo usuario
        $user = User::create( [
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'password'   => Hash::make( $data['password'] ),
        ] );

        //Buscamos latitud y longitud de la ciudad
        $location = $data['location'];
        $latLong  = $this->getLatLong( $location );
        if ( $latLong == null ) {
            return back()->withErrors( [ 'city' => 'No se pudo encontrar la ciudad o pueblo ingresado' ] );
        }

        $userFoodPreference = new UserFoodPreference;
        $userFoodPreference->setAttribute( 'user_food_preferences_id', $data['user_food_preferences_id'] );
        $userFoodPreference->setAttribute( 'terrace', $data['terrace'] );
        $userFoodPreference->setAttribute( 'latitude', $latLong['lat'] );
        $userFoodPreference->setAttribute( 'longitude', $latLong['long'] );
        $user->userFoodPreference()->save( $userFoodPreference );

        if ( isset( $validatedData['price_ranges'] ) ) {
            $user->price_ranges()->sync( $data['price_ranges'] );
        }

        if ( isset( $validatedData['food_types'] ) ) {
            $user->food_types()->sync( $data['food_types'] );
        }

        if ( isset( $validatedData['schedules'] ) ) {
            $user->schedules()->sync( $data['schedules'] );
        }

        return $user;
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
