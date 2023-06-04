<?php

namespace App\Http\Controllers;

use App\Models\EmployeeRole;
use App\Models\User;
use App\Services\Utils\FileServiceInterface;
use App\Traits\ExceptionTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ExceptionTrait;
    private $fileService;
    private $profilePictureFolderName;

    public function __construct(FileServiceInterface $fileService)
    {

        $this->fileService = $fileService;
        $this->profilePictureFolderName = config('storage.base_path') . 'profile_picture';
    }

    public function index()
    {
        $users = User::whereNull('deleted_at')->orderBy('role_id')->orderBy('last_name')->with('role')->get();
        foreach ($users as $user){
            if(isset($user->profile_picture)){
                $user->profile_picture =$this->fileService->download($user->profile_picture, $user->id);
            }
        }
        return $users;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'first_name' => 'required|string',
            'middle_name' => '',
            'last_name' => 'required|string',
            'role' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'birthday' => 'string',
            'contact_number' => 'string|required',
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
            'profile_picture' => null,
            'created_by' => Auth::user()->id,
            'contact_number' => $fields['contact_number'],
        ]);
        if(isset($request->profile_picture)){
            if(!in_array(explode(';',explode('/',explode(',', $request->profile_picture)[0])[1])[0], array('jpg','jpeg','png')) ) {
                $this->throwException('profile_picture has invalid file type', 422);
            }
            $filename = md5($user->id.Carbon::now()->timestamp);
            $user->profile_picture = $this->fileService->upload($this->profilePictureFolderName, $filename, $request->profile_picture, $user->id);
            $user->save();
        }

        return response($user, 201);
    }



    public function show($id)
    {
        return User::whereNull('deleted_at')
            ->where('id', $id)
            ->with('createdBy')
            ->with('role')
            ->first();
    }

    public function update(Request $request, $id)
    {
        $User = User::find($id);
        $User->update($request->all());
        return $User;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
