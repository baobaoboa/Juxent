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

    public function register(Request $request){
        $fields = $request->validate([
            'last_name' => 'required|string',
            'first_name' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'contact_number' => 'required|string|unique:users,contact_number',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed|min:8',
            'street' => 'required|string',
            'address_line_2' => '',
            'barangay' => 'required|string',
            'city' => 'required|string',
            'region' => 'required|string',
            'country' => 'required|string',
            'zipcode' => 'required|integer'
        ]);

        $address = Address::create([
            'street' => $fields['street'],
            'address_line_2' => $fields['address_line_2'],
            'barangay' => $fields['barangay'],
            'city' => $fields['city'],
            'region' => $fields['region'],
            'country' => $fields['country'],
            'zipcode' => $fields['zipcode']
        ]);
        //slug create
        $userSlug = str_replace(" ", "-",strtoupper($fields['username']));
        $user = User::create([
            'last_name' => $fields['last_name'],
            'first_name' => $fields['first_name'],
            'username' => $fields['username'],
            'contact_number' => $fields['contact_number'],
            'slug' => $userSlug,
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'role_id' => $fields['role_id'],
            'address_id' => $address->id,
        ]);

        if($fields['role_id'] == 2){
            DB::table('wallets')->insert([
                ['seller_id' => $user->id, 'money' => 0],
            ]);
        }

        //adding role info
        $role = DB::select('SELECT name FROM `roles` WHERE id=?', [$user->role_id]);
        $user->role = $role[0]->name;
        //adding address key
        $user->address = $address;

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
        auth()->user()->role->slug;
        auth()->user()->address;
        unset(Auth::user()->id);

        Auth::user()->avatar = env('APP_URL').Storage::disk('local')->url('app/'). Auth::user()->avatar;
        return Auth::user();
    }
}
