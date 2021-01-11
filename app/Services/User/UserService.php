<?php

namespace App\Services\User;

use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\User;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;


class UserService implements UserInterface {

    protected $user;


    public function __construct (User $user)
    {
        $this->user = $user;    
    }


    public function signUp (array $data)
    {
        $user = $this->user::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $token = JWTAuth::fromUser($user);
        return response()->json(compact('user','token'),201);
    }


    public function loginUser (array $data)
    {
        try {
                $credentials = ['email' => $data['email'], 'password' => $data['password']];
                
                if (! $token = JWTAuth::attempt($credentials)) {
                    return response()->json(['error' => 'Invalid credentials provided!'], 400);
                }else{
                    if (! $token = JWTAuth::attempt(array_merge($credentials, ['status'=>true]))) {
                        return response()->json(['error' => 'Your account is currently disabled!'], 400);
                    }
                }

                // if (! $toekn = JWTAuth::attempt([$data, 'status'=>false])){
                //     return response()->json(['error' => 'You account is disabled!'], 400);
                // }
        }
        catch (JWTException $e) {
            return response()->json(['error' => 'Could not create the token!'], 500);
        }

        return response()->json(compact('token'));
    }




    public function loggedInUser ()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getMessage());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getMessage());
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getMessage());
        }
        return response()->json(compact('user'));
    }



    public function changePassword ($user_id, array $data)
    {
        $user = $this->user::where('id', $user_id)->first();

        if (!Hash::check($data['old_password'], $user->password)) {
            return response()->json(["error" => "Old password confirmation failed!"], 400);
        }

        $user->password = Hash::make($data['new_password']);
        $user->save();

        return response()->json(["success" => "Password successfully updated!"], 200);
    }



    public function updateAuthDetails ($user_id, array $data) 
    {
        $user  = $this->user::find($user_id);

        if (!$user) {
            return response()->json(["error" => "User id could not found!"], 400);
        }

        $user->update($data);
        return response()->json(["success" => "Info successfully updated!"], 200);
    }

    

}