<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{

    /** <div style="font-size: 3                                            0px; font-weight: 700; font-family: Josefin sans;"> Temporary </div>
     */
    public function login(Request $request){
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        //check Email
        $user = User::where('email', $fields['email'])->first();
        if (!$user){
            return response([
                'message' => 'Email does not exist'
            ]);
        }
        //check password
        if(!Hash::check($fields['password'], $user->password)){
            return response([
                'message' => 'Wrong Password'
            ]);
        }

        $token = $user->createToken('userToken')->plainTextToken;
        $response =[
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);
    }
    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Logout'
        ];
    }
    public function profile(Request $request){
        auth()->user()->role;
        return Auth::user();
    }
}
