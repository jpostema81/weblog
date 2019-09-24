<?php

namespace App\Http\Controllers\Auth\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        if(User::where('email', $request->get('email'))->exists()) 
        {
            $user = User::where('email', $request->get('email'))->first();
            $auth = Hash::check($request->get('password'), $user->password);
            
            if($user && $auth)
            {
                $user->rollApiKey();
         
                return response(array(
                    'user' => $user,
                    'status' => '1',
                    'msg' => 'Authorization Successful!',
                ));
            }
        }

        return response(array(
            'status' => '0',
            'msg' => 'Unauthorized, check your credentials.',
        ));
    }
}
