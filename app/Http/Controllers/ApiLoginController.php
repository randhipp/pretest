<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\User;

use Illuminate\Support\Str;


class ApiLoginController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email','=',$request->username)->first();

        if(isset($user) && Hash::check( $request->password, $user->password) )
        {
            //add api_token to user with successfull login
            $user->api_token = Str::random(80);
            $user->logged_in = 1;
            $user->save();

            return json_encode([ 'status' => 'ok',
                                'email' => $request->username,
                                'login_status' => $user->logged_in,
                                'api_token' => $user->api_token,
                                ]);
        }

    }
    public function logout(Request $request)
    {
        $user = User::where('email','=',$request->username)->first();

        if(isset($user))
        {
            //add api_token to user with successfull login
            $user->api_token = null;
            $user->logged_in = 0;
            $user->save();

            return json_encode([ 'status' => 'ok',
                                'email' => $request->username,
                                'login_status' => $user->logged_in,
                                'api_token' => $user->api_token,
                                ]);
        }

    }
}
