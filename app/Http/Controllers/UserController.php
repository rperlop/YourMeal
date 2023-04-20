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
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {
    protected function create( Request $request ): Application|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse {
        $validatedData = $request->validate([
            'location' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'price_ranges' => 'array',
            'food_types' => 'array',
            'schedules' => 'array',
            'terrace' => 'boolean'
        ]);

        $requestData = $validatedData;

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
        $user = Auth::user();

        return view( 'user-data', compact( 'user' ) );
    }

    public function update( Request $request ): RedirectResponse {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::user()->id,
            'password' => 'required|min:8',
        ], [
            'first_name.required' => 'The first name field is mandatory.',
            'first_name.max' => 'The first name can not have more than 255 characters.',
            'last_name.required' => 'The last name field is mandatory.',
            'last_name.max' => 'The last name can not have more than 255 characters.',
            'email.required' => 'The email field is mandatory.',
            'email.email' => 'The email has to have an email format.',
            'email.unique' => 'This email is already used.',
            'password.required' => 'The password field is mandatory.',
            'password.min' => 'Password has to have 8 characters.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('user.edit')
                             ->withErrors($validator)
                             ->withInput();
        }

        $user = Auth::user();
        $user->fill($request->all());
        $user->save();

        return redirect()->route('user.edit')->with('success', 'Changes are saved.');
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
