<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Contact\ContactInterface;
use Illuminate\Support\Facades\Validator;


class ContactController extends Controller
{

    protected $contact;
    protected $request;




    public function __construct (ContactInterface $contact, Request $request)
    {
        $this->contact = $contact;
        $this->request = $request;
        $this->middleware('jwt.verify');
    }





    public function myContacts ()
    {
        return $this->contact->getContacts($this->request->user()->id);
    }




    public function myContact ($col_id)
    {
        return $this->contact->getContact(
            $this->request->user()->id, 
            $col_id
        );
    }




    public function createContact ()
    {
        $validator = Validator::make($this->request->all(), [
            'full_name' => 'required',
            'email' => 'required|email|unique:contacts',
            'phone' => 'required|unique:contacts',
            'address' => 'required',
            'website' => 'required|unique:contacts',
        ]);

        if($validator->fails()){
            return response()->json(
                $validator->errors(), 
                400
            );
        }

        return $this->contact->createContact(
            $this->request->user()->id, 
            $this->request->all()
        );
    }





    public function updateContact ($col_id)
    {
        return $this->contact->updateContact(
            $this->request->user()->id, 
            $col_id, $this->request->all()
        );
    }



    public function deleteContact ($col_id)
    {
        return $this->contact->deleteContact(
            $this->request->user()->id, 
            $col_id
        );
    }


}
