<?php

namespace App\Services\Contact;
use App\Models\Contact;


class ContactService implements ContactInterface {



    protected $contact;


    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }



    public function getContacts ($user_id)
    {
        $contacts = $this->contact::where("user_id", $user_id)->get();

        if ( !$contacts ){
            return response()->json(["error" => "We could not get the contacts for you!"], 400);
        }

        return response()->json($contacts, 200);
    }



    public function getContact ($user_id, $col_id)
    {
        $contact = $this->contact::where("user_id", $user_id)->where("id", $col_id)->first();

        if (!$contact) {
            return response()->json(['error' => 'Contact not found for you!'], 404);
        }

        return response()->json($contact, 200);
    }



    public function createContact ($user_id, array $data)
    {
        $this->contact::create([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'website' => $data['website'],
            'user_id' => $user_id
        ]);

        return response()->json(['contact_created' => 'Contact successfully created!'], 201);

    }



    public function updateContact ($user_id, $col_id, array $data)
    {
        $contact = $this->contact::where('id', $col_id)->where('user_id', $user_id)->first();

        if (!$contact) {
            return response()->json(['error' => 'We could not update the contact for you!'], 400);
        }

        $contact->update($data);
        return response()->json(['contact_updated' => 'Contact successfully updated!'], 201);
    }



    public function deleteContact ($user_id, $col_id)
    {
        $contact = $this->contact::where('user_id', $user_id)->where('id', $col_id)->first();
        if(!$contact) {
            return response()->json(["error" => "We could not delete the contact for you!"]);
        }

        $contact->delete();
        return response()->json(["contact_delete"=>"Contact successfully deleted!"], 201);
        
    }

    
}