<?php

namespace App\Http\Controllers;

use App\Models\EmployeeRole;
use App\Models\User;
use App\Traits\ExceptionTrait;
use Couchbase\Role;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    use exceptionTrait;

    public function index()
    {
        //
    }


    public function store(Request $request)
    {
        $fields = $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'string',
            'last_name' => 'required|string',
            'role' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'birthday' => 'string',
            'password' => 'required|string|confirmed',
        ]);

        $role = EmployeeRole::where('slug', $fields['role'])->first();
        if (!$role) {
            return $this->throwException('401', 'Invalid role');
        }
        $user = User::create([
            'first_name' => $fields['first_name'],
            'middle_name' => $fields['middle_name'],
            'last_name' => $fields['last_name'],
            'role_id' => $role->id,
            'email' => $fields['email'],
            'birthday' => $fields['birthday'],
            'password' => bcrypt($fields['password']),
        ]);
        return response($user, 201);
    }


    public function show($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
