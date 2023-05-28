<?php

namespace App\Http\Controllers;

use App\Models\FoodType;
use App\Models\PriceRange;
use App\Models\Schedule;
use App\Utils\Utilities;
use App\Models\Config;
use App\Models\User;
use App\Models\UserFoodPreference;
use GuzzleHttp\Exception\GuzzleException;
use http\Env\Response;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller {
    /**
     * Create a new user
     *
     * @param Request $request
     *
     * @return Application|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
     * @throws GuzzleException
     */
    protected function create( Request $request ): Application|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse {
        $validator = Validator::make( $request->all(), [
            'first_name'   => 'required|max:255',
            'last_name'    => 'required|max:255',
            'email'        => 'required|email|unique:users,email,',
            'password'     => 'required|min:8',
            'location'     => 'required|max:255',
            'terrace'      => 'required|max:255',
            'schedules'    => 'required|array|min:1',
            'food_types'   => 'required|array|min:1',
            'price_ranges' => 'required|array|min:1',
        ], [
            'first_name.required'   => 'The first name field is mandatory.',
            'first_name.max'        => 'The first name can not have more than 255 characters.',
            'last_name.required'    => 'The last name field is mandatory.',
            'last_name.max'         => 'The last name can not have more than 255 characters.',
            'email.required'        => 'The email field is mandatory.',
            'email.email'           => 'The email has to have an email format.',
            'email.unique'          => 'This email is already used.',
            'password.required'     => 'The password field is mandatory.',
            'password.min'          => 'Password must be at least 8 characters long.',
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
            return redirect()->route( 'registers' )
                             ->withErrors( $validator )
                             ->withInput();
        }

        $location = $request['location'];
        $lat_long = Utilities::get_lat_long( $location );
        if ( $lat_long == null ) {
            return back()->withErrors( [ 'location' => 'It does not exist the city' ] );
        }

        $user_food_preferences = new UserFoodPreference;
        $user_food_preferences->setAttribute( 'terrace', $request['terrace'] );
        $user_food_preferences->setAttribute( 'latitude', $lat_long['latitude'] );
        $user_food_preferences->setAttribute( 'longitude', $lat_long['longitude'] );
        $user_food_preferences->save();
        $user_food_preferences_id = $user_food_preferences->id;

        $user = new User;
        $user->setAttribute( 'first_name', $request['first_name'] );
        $user->setAttribute( 'last_name', $request['last_name'] );
        $user->setAttribute( 'email', $request['email'] );
        $user->setAttribute( 'password', Hash::make( $request['password'] ) );
        $user->user_food_preferences_id = $user_food_preferences_id;
        $user->save();

        if ( isset( $request['price_ranges'] ) ) {
            $user_food_preferences->price_ranges()->sync( $request['price_ranges'] );
        }

        if ( isset( $request['food_types'] ) ) {
            $user_food_preferences->food_types()->sync( $request['food_types'] );
        }

        if ( isset( $request['schedules'] ) ) {
            $user_food_preferences->schedules()->sync( $request['schedules'] );
        }

        Auth::login( $user );

        return redirect( '/' )->with( 'user' );
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
        $validator = Validator::make( $request->all(), [
            'first_name' => 'required|max:255',
            'last_name'  => 'required|max:255',
            'email'      => 'required|email|unique:users,email,' . Auth::user()->id,
            'password'   => 'required|min:8',
        ], [
            'first_name.required' => 'The first name field is mandatory.',
            'first_name.max'      => 'The first name can not have more than 255 characters.',
            'last_name.required'  => 'The last name field is mandatory.',
            'last_name.max'       => 'The last name can not have more than 255 characters.',
            'email.required'      => 'The email field is mandatory.',
            'email.email'         => 'The email has to have an email format.',
            'email.unique'        => 'This email is already used.',
            'password.required'   => 'The password field is mandatory.',
            'password.min'        => 'Password must be at least 8 characters long.',
        ] );

        if ( $validator->fails() ) {
            return redirect()->route( 'user.edit' )
                             ->withErrors( $validator )
                             ->withInput();
        }

        $user = Auth::user();
        $user->fill( $request->all() );

        if ( $request->has( 'password' ) ) {
            $user->password = bcrypt( $request->password );
        }

        $user->save();

        toastr()->success( 'User data updated.' );

        return redirect()->route( 'user.edit' );
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

        $user->save();

        $user->notifications()->delete();

        $user->reports()->delete();

        $user->reviews()->each(function ($review) {
            $review->reports()->delete();
            $review->images()->delete();
            $review->delete();
        });

        $user->delete();

        $user_food_preferences->delete();

        Auth::logout();

        return redirect()->route( 'login' );
    }

    /**
     * Index all users on admin panel
     *
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application
     */
    public function index(): Factory|Application|View|\Illuminate\Contracts\Foundation\Application {
        $users = User::all();

        return view( 'admin.pages.index-users', compact( 'users' ) );
    }

    /**
     * Create a new user on admin panel
     *
     * @param Request $request
     *
     * @return Application|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
     * @throws GuzzleException
     */
    protected function admin_create_user( Request $request ): Application|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse {
        $validator = Validator::make( $request->all(), [
            'first_name'   => 'required|max:255',
            'last_name'    => 'required|max:255',
            'email'        => 'required|email|unique:users,email,',
            'password'     => 'required|min:8',
            'location'     => 'required|max:255',
            'terrace'      => 'required|max:255',
            'schedules'    => 'required|array|min:1',
            'food_types'   => 'required|array|min:1',
            'price_ranges' => 'required|array|min:1',
        ], [
            'first_name.required'   => 'The first name field is mandatory.',
            'first_name.max'        => 'The first name can not have more than 255 characters.',
            'last_name.required'    => 'The last name field is mandatory.',
            'last_name.max'         => 'The last name can not have more than 255 characters.',
            'email.required'        => 'The email field is mandatory.',
            'email.email'           => 'The email has to have an email format.',
            'email.unique'          => 'This email is already used.',
            'password.required'     => 'The password field is mandatory.',
            'password.min'          => 'Password must be at least 8 characters long.',
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
            return redirect()->route( 'admin.create.user' )
                             ->withErrors( $validator )
                             ->withInput();
        }

        $location = $request['location'];
        $lat_long = Utilities::get_lat_long( $location );
        if ( $lat_long == null ) {
            return back()->withErrors( [ 'location' => 'It does not exist the city' ] );
        }

        $user_food_preferences = new UserFoodPreference;
        $user_food_preferences->setAttribute( 'terrace', $request['terrace'] );
        $user_food_preferences->setAttribute( 'latitude', $lat_long['latitude'] );
        $user_food_preferences->setAttribute( 'longitude', $lat_long['longitude'] );
        $user_food_preferences->save();
        $user_food_preferences_id = $user_food_preferences->id;

        $user = new User;
        $user->setAttribute( 'first_name', $request['first_name'] );
        $user->setAttribute( 'last_name', $request['last_name'] );
        $user->setAttribute( 'email', $request['email'] );
        $user->setAttribute( 'role', $request['role'] );
        $user->setAttribute( 'password', Hash::make( $request['password'] ) );
        $user->user_food_preferences_id = $user_food_preferences_id;
        $user->save();

        if ( isset( $request['price_ranges'] ) ) {
            $user_food_preferences->price_ranges()->sync( $request['price_ranges'] );
        }

        if ( isset( $request['food_types'] ) ) {
            $user_food_preferences->food_types()->sync( $request['food_types'] );
        }

        if ( isset( $request['schedules'] ) ) {
            $user_food_preferences->schedules()->sync( $request['schedules'] );
        }

        toastr()->success( 'User created.' );

        return redirect()->route( 'admin.index.users' );
    }

    /**
     * Update the data of a specific user on the admin panel
     *
     * @param Request $request
     * @param         $id
     *
     * @return RedirectResponse
     *
     * @throws GuzzleException
     */
    public function admin_update_user( Request $request, $id ): RedirectResponse {
        $user = User::findOrFail( $id );

        $validator = Validator::make( $request->all(), [
            'first_name' => 'max:255',
            'last_name'  => 'max:255',
            'email'      => [
                'email',
                Rule::unique( 'users' )->ignore( $user->id ),
            ],
            'password'   => 'nullable|min:8',
            'role'       => 'in:admin,user',
            'location'     => 'required|max:255',
            'terrace'      => 'required|max:255',
            'schedules'    => 'required|array|min:1',
            'food_types'   => 'required|array|min:1',
            'price_ranges' => 'required|array|min:1',
        ], [
            'first_name.max' => 'The first name can not have more than 255 characters.',
            'last_name.max'  => 'The last name can not have more than 255 characters.',
            'email.email'    => 'The email has to have an email format.',
            'email.unique'   => 'This email is already used.',
            'password.min'   => 'Password must be at least 8 characters long.',
            'role.in'        => 'Invalid role value.',
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
            return redirect()->route( 'admin.edit.user', $user->id )
                             ->withErrors( $validator )
                             ->withInput();
        }

        $user->fill( $request->except( 'password' ) );

        if ( $request->filled( 'password' ) ) {
            $user->password = bcrypt( $request->password );
        }

        if ( $request->has( 'role' ) ) {
            $user->setAttribute( 'role', $request['role'] );
        }

        $user->save();

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
            $new_location_lat_long            = Utilities::get_lat_long( $new_location );
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

        toastr()->success( 'Changes are saved.' );

        return redirect()->route( 'admin.edit.user', $user->id );
    }

    /**
     * Show the data of a specific user on admin panel
     *
     * @param integer $id
     *
     * @return Factory|Application|View|\Illuminate\Contracts\Foundation\Application
     * @throws GuzzleException
     */
    public function admin_show_user_data( int $id ): Factory|Application|View|\Illuminate\Contracts\Foundation\Application {
        $user = User::findOrFail( $id );

        $latitude  = $user->user_food_preferences->latitude;
        $longitude = $user->user_food_preferences->longitude;
        $terrace   = $user->user_food_preferences->terrace;
        $location  = Utilities::get_full_address( $latitude, $longitude );

        $user_food_preferences_id = $user->user_food_preferences_id;
        $user_food_preferences    = UserFoodPreference::find( $user_food_preferences_id );

        $food_types   = FoodType::all();
        $price_ranges = PriceRange::all();
        $schedules    = Schedule::all();

        return view( 'admin/pages/edit-user', compact( 'user', 'user_food_preferences', 'latitude', 'longitude', 'terrace', 'schedules', 'food_types', 'price_ranges', 'location' ) );
    }

    /**
     * Remove a user from admin panel
     *
     * @param integer $id
     *
     * @return RedirectResponse
     */
    public function admin_remove_user( int $id ): RedirectResponse {
        $user = User::findOrFail( $id );

        $user_food_preferences = $user->user_food_preferences;

        $user_food_preferences->schedules()->detach();
        $user_food_preferences->food_types()->detach();
        $user_food_preferences->price_ranges()->detach();

        $user->save();

        $user->notifications()->delete();

        $user->reports()->delete();

        $user->reviews()->each(function ($review) {
            $review->reports()->delete();
            $review->images()->delete();
            $review->delete();
        });

        $user->delete();

        $user_food_preferences->delete();

        toastr()->success( 'User removed.' );

        return redirect()->route( 'admin.index.users' );
    }

    /**
     * Notice strike and banning notifications to a user
     *
     * @return void
     */
    public function notice_banning_and_strike_notification(): void {
        $user = Auth::user();
        $user->notify = 0;
        $user->save();

        $strikes_number = Config::where('property', 'strikes_number')->value('value');
        if (Auth::user()->strikes == $strikes_number){
            $user->banned = true;
            $user->save();
        }
    }

    /**
     * Add a strike to a user
     *
     * @param int $id
     *
     * @return void
     */
    public function add_strike(int $id) {
        $user = User::findOrFail( $id );
        $user->strikes++;
        $user->notify = 1;
        $user->save();

        toastr()->success( 'Strike added.' );
        return redirect()->route( 'admin.edit.user', $user->id );
    }
}
