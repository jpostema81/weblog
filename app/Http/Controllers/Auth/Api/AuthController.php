<?php

namespace App\Http\Controllers\Auth\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\User;


class AuthController extends Controller
{
    public function getUserByToken(Request $request) 
    {
        try 
        {
            if (!$user = JWTAuth::parseToken()->authenticate()) 
            {
                return response()->json(['status' => '0', 'message' => 'user not found'], 404);
            }
        } 
        catch (TokenExpiredException $e) 
        {
            return response()->json(['status' => '0', 'message' => 'token expired']);
        } 
        catch (TokenInvalidException $e) 
        {
            return response()->json(['status' => '0', 'message' => 'token invalid']);
        } 
        catch (JWTException $e) 
        {
            return response()->json(['status' => '0', 'message' => 'There is a problem with your token']);
        }
    
        // the token is valid and we have found the user via the sub claim
        return response()->json(['status' => '1', 'message' => 'token valid', 'user' => $user]);
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

        $token = JWTAuth::fromUser($user);

        return $this->respondWithToken($token, $user);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6|max:1',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 422);
        }

        try 
        {
            // attempt to verify the credentials and create a token for the user
            if(!$token = JWTAuth::attempt($credentials)) 
            {
                return response()->json(['status' => '0', 'message' => 'invalid credentials'], 400);
            }
        } 
        catch (JWTException $e) 
        {
            return response()->json(['status' => '0', 'message' => 'could not create token'], 500);
        }

        $user = JWTAuth::user();

        return $this->respondWithToken($token, $user);
    }

    // is deze functie nog noodzakelijk?
    public function logout()
    {
        try 
        {
            auth()->logout();
        }
        catch (JWTException $e) 
        {
            return response()->json(['status' => '0', 'message' => 'There is a problem with your token']);
        }

        return response()->json(['status' => '1', 'message' => 'Successfully logged out']);
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
}
