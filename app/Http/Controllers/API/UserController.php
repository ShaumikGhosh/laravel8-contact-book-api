<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\User\UserInterface;


class UserController extends Controller
{

    protected $repository;
    protected $request;


    public function __construct(UserInterface $repo, Request $request)
    {
        $this->repository = $repo;
        $this->request = $request;
        $this->middleware('jwt.verify', ['except' => ['authenticate', 'register']]);    
    }





    public function authenticate()
    {
        $credentials = $this->request->only('email', 'password');
        return $this->repository->loginUser($credentials);
    }




    public function register()
    {
        $validator = Validator::make($this->request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        return $this->repository->signUp($this->request->all());
    }





    public function getAuthenticatedUser()
    {
        return $this->repository->loggedInUser();
    }


    public function changePassword ()
    {
        $validator = Validator::make($this->request->all(), [
            'old_password' => 'required',
            'new_password' => 'min:6|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:6'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        return $this->repository->changePassword($this->request->user()->id, $this->request->all());
    }



    public function changeTheUserDetails ()
    {
        $this->repository->updateAuthDetails($this->request->user()->id, $this->request->all());
    }



}
