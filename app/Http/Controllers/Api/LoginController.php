<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{

    // use AuthenticatesUsers;

    public function login(LoginRequest $request) 
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            $user->tokens()->delete();


            if($request->get('fcm_token')) {
                $user->update([
                    'fcm_token' => $request->get('fcm_token'),
                ]);
            }

            return response()->json([
                'message' => 'Login Berhasil!',
                'data' => [
                    'token' => $user->createToken('auth_token')->plainTextToken,
                    'name' => 'Bearer',
                    'account' => new UserResource($user)
                ]
            ]);
        } else {
            throw ValidationException::withMessages([
                'email' => [trans('auth.failed')],
            ]);
        } 
    }

    public function logout(Request $request)
    {

        auth()->user()->update(['fcm_token' => null]);
        auth()->user()->tokens()->delete();

        // delete the current token that was used for the request
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout berhasil',
            'link' => route('login'),
        ]);
    }
}
