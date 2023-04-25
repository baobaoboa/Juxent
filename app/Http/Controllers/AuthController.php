<?php

namespace App\Http\Controllers;
use App\Models\EmployeeRole;
use App\Models\User;
use App\Traits\ExceptionTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    use ExceptionTrait;

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
            return $this->throwException('401', "Email does not exist");
        }
        //check password
        if(!Hash::check($fields['password'], $user->password)){
            return $this->throwException('401', "Wrong Password");
        }
        //$roles = EmployeeRole::find('')
        $role = EmployeeRole::find($user->role_id);
        $token = $user->createToken('userToken', Carbon::now()->addDays(3))->plainTextToken;
        $response =[
            'user' => $user,
            'role' => $role,
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
