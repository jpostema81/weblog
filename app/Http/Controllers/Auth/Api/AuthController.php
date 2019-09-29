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
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                
                return response()->json(['status' => '0', 'message' => 'user_not_found'], 404);
            }
        } 
        catch (TokenExpiredException $e) {
    
            return response()->json(['status' => '0', 'message' => 'token_expired']);
    
        } 
        catch (TokenInvalidException $e) {
    
            return response()->json(['status' => '0', 'message' => 'token_invalid']);
    
        } 
        catch (JWTException $e) {
            return response()->json(['status' => '0', 'message' => 'token_invalid']);
    
        }
    
        // the token is valid and we have found the user via the sub claim
        return response()->json(['status' => '1', 'message' => 'token_valid', 'user' => $user]);
    }

    public function register(Request $request)
    {
        $credentials = $request->only('name', 'email', 'password', 'password_confirmation');

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if($validator->fails())
        {
            return response()->json($validator->errors()->toJson(), 400);
        }
        
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        return $this->respondWithToken($token);
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
            return response()->json($validator->errors()->toJson(), 400);
        }

        try 
        {
            // attempt to verify the credentials and create a token for the user
            if(!$token = JWTAuth::attempt($credentials)) 
            {
                return response()->json(['status' => '0', 'message' => 'invalid_credentials'], 400);
            }
        } 
        catch (JWTException $e) 
        {
            return response()->json(['status' => '0', 'message' => 'could_not_create_token'], 500);
        }

        return $this->respondWithToken($token);
    }

    // is deze functie nog noodzakelijk?
    public function logout()
    {
        auth()->logout();

        return response()->json(['status' => '1', 'message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60
        ]);
    }
}
