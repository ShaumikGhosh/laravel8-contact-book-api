<?php

namespace App\Services\Contact;


interface ContactInterface {

    public function getContacts ($id);

    public function getContact ($user_id, $col_id);

    public function createContact ($user_id, array $data);

    public function updateContact ($user_id, $col_id, array $data);

    public function deleteContact ($user_id, $col_id);

}