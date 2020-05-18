<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class LoginController extends Controller
{
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
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /*
     * Overwrite the default behaviour of the method as it's defined in the AuthenticatesUsers trait
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|email|string',
            'password' => 'required|string',
        ]);
    }

    public function attemptLogin(Request $request) {
        $users = User::all();
        foreach ($users as $user) {
            if ($request->email === $user->email && Hash::check($request->password, $user->password)) {
                $this->guard()->login($user,false);
                return true;
            }
        }
        return false;
    }

    public function logout(Request $request)    {
        Auth::logout();
        return redirect()->route('cms-home');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
            'email' => "Let op: het e-mailadres is hoofdlettergevoelig!",
            'credentials' => "Deze inloggegevens zijn bij ons niet bekend!",
        ]);
    }

    protected function guard()  {
        return Auth::guard();
    }
}
