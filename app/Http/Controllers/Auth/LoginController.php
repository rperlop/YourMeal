<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware( 'guest' )->except( 'logout' );
    }

    /**
     * Log a user out
     *
     * @param Request $request
     *
     * @return Application|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse
     */
    public function logout( Request $request ): Application|Redirector|\Illuminate\Contracts\Foundation\Application|RedirectResponse {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect( '/' );
    }

    /**
     * Get a user logged out if it is banned
     *
     * @param Request $request
     * @param         $user
     *
     * @return RedirectResponse
     */
    protected function authenticated(Request $request, $user): RedirectResponse {
        if ($user->banned) {
            Auth::logout();
            return redirect()->route('login')->with('status', 'Your account has been banned. Please contact the administrator for more information.');
        }

        return redirect()->intended($this->redirectPath());
    }


    protected function redirectTo(): string {
        return '/';
    }
}
