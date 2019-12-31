<?php

namespace App\Http\Controllers\Auth\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Mail;
use App\Mail\RegistrationConfirmation;
use App\Http\Resources\UserResource;
use App\User;
use App\Http\Requests\Admin\Auth\RegisterUser;
use App\Http\Requests\Admin\Auth\Login;

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

    public function register(RegisterUser $request)
    {
        $validatedInput = $request->validated();
        $user = User::create($validatedInput);
        $token = auth()->tokenById($user->id);

        try 
        {
            $emailAddress = $validatedInput['email'];
            Mail::to($emailAddress)->send(new RegistrationConfirmation());
        }
        catch(\Exception $e)
        {
            return response()->json(['message' => 'Error while sending mail'], 500);
        }

        return $this->respondWithToken($token, $user);
    }

    public function login(Login $request)
    {
        $validatedInput = $request->validated();

        if($token = $this->guard()->attempt($validatedInput)) 
        {
            $user = $this->guard()->user();
            return $this->respondWithToken($token, new UserResource($user));
        }

        return response()->json(['error' => 'Invalid Login Credentials'], 401);
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
