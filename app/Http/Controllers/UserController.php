<?php

namespace App\Http\Controllers;

use Hash;
use Illuminate\Http\Request;
use App\User;
use Auth;


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


    public function adminLogin(Request $request)
    {
        $user = User::where('email',$request->email)->get();

        if($user && $user[0]['role'] == 'admin')
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
        else
            {
                return response()->json(['error' => 'Not Found'], 401);
            }
        
    }


    public function profile()
    {
        $userData = User::getAllUserData();
        return response()->json($userData,200);
    }


    public function checkPassword(Request $request)
    {
        
        return response()->json(
            Hash::check($request->password, Auth::user()->password, []));
            
    }

    public function editProfile(Request $request)
    {
        $user = Auth::User();
        User::where('id',$user->id)->update([
            'name' => $request->name,
            'photo' => $request->photo,
            'phonenumber'=>$request->phonenumber,
        ]);
        if($request->password!=null)
            $user->password = bcrypt($request->password);
        $user->save();
        $user = User::find($user->id);
        return response()->json($user,200);
    }


    public function uploadimge(Request $request)
    {
        return response()->json(User::fileUpload($request),200);
    }

}
