<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\AdminInterface;
use Illuminate\Support\Facades\Validator;


class AdminController extends Controller
{

    protected $admin;
    protected $request;
    

    public function __construct(AdminInterface $admin, Request $request)
    {
        $this->admin = $admin;
        $this->request = $request;
        $this->middleware('jwt.verify');
    }





    public function getAllUsers ()
    {
        return $this->admin->getUsers($this->request->user()->type);
    }





    public function getSingleUser ($col_id)
    {
        return $this->admin->getUser($this->request->user()->type, $col_id);
    }




    public function createTheUser ()
    {
        $validator = Validator::make($this->request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'type' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        return $this->admin->createUser($this->request->user()->type, $this->request->all());
    }





    public function updateTheUser ($col_id)
    {
        return $this->admin->updateUser($this->request->user()->type, $col_id, $this->request->all());
    }



    public function deleteTheUser ($col_id)
    {
        return $this->admin->deleteUser($this->request->user()->type, $col_id);
    }
}
