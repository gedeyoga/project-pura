<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserTransformer;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    public function loggedOut(Request $request)
    {
        return response()->json([
            'status' => 200,
            'redirect' => route('login'),
        ], 200);
    }

    public function showLoginForm()
    {
        return view('layouts.auth');
    }

    public function authenticated(Request $request, $user)
    {
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Login Berhasil!',
            'data' => [
                'token' => $user->createToken('auth_token')->plainTextToken,
                'name' => 'Bearer',
                'account' => new UserTransformer($user)
            ]
        ]);
    }
}
