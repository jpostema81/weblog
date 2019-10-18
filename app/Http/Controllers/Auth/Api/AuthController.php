<?php

namespace App\Http\Controllers\Auth\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use App\User;

// https://jwt-auth.readthedocs.io/en/docs/quick-start/


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserByToken()
    {
        return response()->json(new UserResource($this->guard()->user()), 200);
    }

    public function register(Request $request)
    {
        $credentials = $request->only('firstName', 'lastName', 'email', 'password', 'password_confirmation');

        $validator = Validator::make($credentials, [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 422);
        }
        
        $user = User::create([
            'first_name' => $request->get('firstName'),
            'last_name' => $request->get('lastName'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = auth()->tokenById($user->id);

        return $this->respondWithToken($token, $user);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 422);
        }

        if($token = $this->guard()->attempt($credentials)) 
        {
            $user = $this->guard()->user();
            return $this->respondWithToken($token, $user);
        }

        return response()->json(['error' => 'Invalid Login Details'], 401);
    }

    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token, $user)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60,
            'user'         => $user,
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard('api');
    }
}
