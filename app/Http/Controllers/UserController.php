<?php

namespace App\Http\Controllers;

use App\Libraries\Utilities;
use App\Models\User;
use App\Models\UserFoodPreference;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller {
    /**
     * Create a new user
     *
     * @param Request $request
     *
     * @return Application|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
     * @throws GuzzleException
     */
    protected function create(Request $request): Application|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
    {
        $request_data = $request->all();

        $location = $request_data['location'];
        $lat_long = (new Utilities)->getLatLong($location);
        if ($lat_long == null) {
            return back()->withErrors(['location' => 'It does not exist the city']);
        }

        $user_food_preferences = new UserFoodPreference;
        $user_food_preferences->setAttribute('terrace', $request_data['terrace']);
        $user_food_preferences->setAttribute('latitude', $lat_long['latitude']);
        $user_food_preferences->setAttribute('longitude', $lat_long['longitude']);
        $user_food_preferences->save();
        $user_food_preferences_id = $user_food_preferences->id;

        $user = new User;
        $user->setAttribute('first_name', $request_data['first_name']);
        $user->setAttribute('last_name', $request_data['last_name']);
        $user->setAttribute('email', $request_data['email']);
        $user->setAttribute('password', Hash::make($request_data['password']));
        $user->user_food_preferences_id = $user_food_preferences_id;
        $user->save();

        if (isset($request_data['price_ranges'])) {
            $user_food_preferences->price_ranges()->sync($request_data['price_ranges']);
        }

        if (isset($request_data['food_types'])) {
            $user_food_preferences->food_types()->sync($request_data['food_types']);
        }

        if (isset($request_data['schedules'])) {
            $user_food_preferences->schedules()->sync($request_data['schedules']);
        }

        Auth::login($user);

        return redirect('/')->with('user');
    }


    /**
     * Show user data
     *
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application
     */
    public function show_user_data(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application {
        $user = Auth::user();

        return view( 'user-data', compact( 'user' ) );
    }

    /**
     * Update user data
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
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
            'password.min' => 'Password must be at least 8 characters long.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('user.edit')
                             ->withErrors($validator)
                             ->withInput();
        }

        $user = Auth::user();
        $user->fill($request->all());

        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

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

        $user_food_preferences = $user->user_food_preferences;

        $user_food_preferences->schedules()->detach();
        $user_food_preferences->food_types()->detach();
        $user_food_preferences->price_ranges()->detach();

        $user->user_food_preferences_id = null;
        $user->save();

        $user_food_preferences->delete();

        $user->delete();

        Auth::logout();

        return redirect()->route('login')->with('success', 'User removed');
    }

}
