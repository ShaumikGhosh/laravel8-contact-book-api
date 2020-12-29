<?php

namespace App\Services\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminService  implements AdminInterface{

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }


    public function getUsers ($user_type)
    {
        if ( !$user_type === 'admin' ) {
            return response()->json(['error'=>''], 400);
        }

        $users = $this->user::where('type', 'user')->get();
        return response()->json([$users], 200);
    }



    public function getUser ($user_type, $col_id)
    {
        if ( !$user_type === 'admin' ) {
            return response()->json(['error'=>''], 400);
        }

        $user = $this->user::where('type', 'user')->where('id', $col_id)->first();
        return response()->json([$user], 200);
    }



    public function createUser ($user_type, array $data)
    {
        if ( !$user_type === 'admin' ) {
            return response()->json(['error'=>''], 400);
        }

        $this->user::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'type' => $data['type']
        ]);

        return response()->json(['success' => 'User successfully created!'], 201);
    }



    public function updateUser ($user_type, $col_id, array $data)
    {
        if ( !$user_type === 'admin' ) {
            return response()->json(['error'=>''], 400);
        }

        if($data['password'] !== '') {
            $data['pass'] = Hash::make($data['password']);
        }

        $this->user::find($col_id)->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['pass'],
            'status' => $data['status'],
            'type' => $data['type'],
        ]);

        return response()->json(['success' => 'User data successfully updated!'], 201);
    }



    public function deleteUser ($user_type, $col_id){

        if ( !$user_type === 'admin' ) {
            return response()->json(['error'=>''], 400);
        }

        $user = $this->user::find($col_id);
        $user->delete();

        return response()->json(['success' => 'User data successfully deleted!'], 200);
    }

}