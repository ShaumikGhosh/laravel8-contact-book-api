<?php

namespace App\Services\User;


interface UserInterface {

    public function signUp (array $data);

    public function loginUser (array $data);

    public function loggedInUser ();

    public function changePassword ($user_id, array $data);

    public function updateAuthDetails ($user_id, array $data);

}