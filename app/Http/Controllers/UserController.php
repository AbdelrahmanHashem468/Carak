<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class UserController extends Controller
{
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'photo'=>'required',
            'phonenumber'=>'required',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'photo' => $request->photo,
            'phonenumber'=>$request->phonenumber,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('TutsForWeb')->accessToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ], 200);
    }


    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($credentials)) 
            {
                $token = auth()->user()->createToken('TutsForWeb')->accessToken;
                $user = auth()->user();     
                return response()->json([
                    'token' => $token,
                    'user' => $user,
                ], 200);
            } 
        else
            {
                return response()->json(['error' => 'UnAuthorised'], 401);
            }
    }


    public function profile()
    {
        $userData = User::getAllUserData();
        return $userData;
    }

    public function uploadimge(Request $request)
    {
        
        return User::fileUpload($request);
    }

}
