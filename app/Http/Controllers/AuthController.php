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

    /** <div style="font-size: 40px; font-weight: 700; font-family: Josefin sans;"> Temporary </div>
     */
    public function register(Request $request){
        $fields = $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'required|string',
            'last_name' => 'required|string',
            'role_id' => 'required|integer',
            'username' => 'required|string|unique:users,username',
            'birthday' => 'required|date',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed|min:8',
        ]);
        $user = User::create([
            'first_name' => $fields['first_name'],
            'middle_name' => $fields['middle_name'],
            'last_name' => $fields['last_name'],
            'role_id' => $fields['role_id'],
            'username' => $fields['username'],
            'birthday' => $fields['birthday'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
        ]);

        $token = $user->createToken('userToken')->plainTextToken;
        $response =[
            'user' => $user,
            'token' => $token
        ];
        unset($user->role_id);
        unset($user->id);
        return response($response, 201);
    }
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
        //unsetting unnecessary datum
        unset($response['user']['id']);
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
