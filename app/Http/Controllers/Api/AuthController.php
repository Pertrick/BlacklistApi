<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Events\NewUserRegistered;
use App\Models\User;

class AuthController extends Controller
{
    /* seeting the authentication using constructor

    public function __construct()
    {
        $this->middleware('auth:api', ['except' =>['login', 'register']]);
    }

    */


    //user-login api 
    public function login(Request $request)
    {
         //validation
         $request->validate([
            'email' => 'required | email ',
            'password' => 'required',
        ]);

        if (!$token = auth()->attempt(['email' =>$request->email, 'password' => $request->password]))
        {
            return response()->json([
                'status' => false,
                'message' => 'Login Failed! Invalid Credentials',
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Logged in successfully',
            'access_token' => $token
        ]);

    }

    //user-register
    public function register(Request $request)
    {
        //validation
        $request->validate([
            'name' => 'required' ,
            'email' => 'required | email | unique:users',
            'password' => 'required|confirmed',
        ]);

        //create a new user
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        $user->save();

        event(new NewUserRegistered($user));

        if($user->save())
        {
            return response()->json([
                'status' => true,
                'message' => 'User Registration Successful',
                'data' => $user,
            ], 200);
        }



    }

    public function logout()
    {

        auth()->logout();

        return response()->json([
            'status' => true,
            'message' => 'User Logged Out Successfully.',
           
        ], 200);
    }
}
