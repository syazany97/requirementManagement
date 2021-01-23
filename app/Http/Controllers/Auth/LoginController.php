<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

    public function showLoginPage(Request $request)
    {
        $email = '';
        $password = '';

        if ($request->has('demo')) {
            if ($request->boolean('demo')) {
                $name = Str::random(11);
                $password = Str::random(8);
                $user = User::create([
                    'name' => $name,
                    'email' => $name . '@gmail.com',
                    'password' => Hash::make($password),
                ]);
                $email = $user->email;
            }
        }

        return view('auth.login')->with([
            'email' => $email,
            'password' => $password
        ]);
    }


}
