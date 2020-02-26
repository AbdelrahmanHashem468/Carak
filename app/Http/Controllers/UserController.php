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
            'photo'=>'required|image|mimes:jpeg,png,jpg,gif,svg',
            'phonenumber'=>'required',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'photo' => User::fileUpload($request),
            'phonenumber'=>$request->phonenumber,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('TutsForWeb')->accessToken;

        return response()->json(['token' => $token], 200);
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
                return response()->json(['token' => $token], 200);
            } 
        else
            {
                return response()->json(['error' => 'UnAuthorised'], 401);
            }
    }

}
