<?php

namespace App\Services\Admin;


interface AdminInterface {

    public function getUsers ($user_type);

    public function getUser ($user_type, $col_id);

    public function createUser ($user_type, array $data);

    public function updateUser ($user_type, $col_id, array $data);

    public function deleteUser ($user_type, $col_id);

}