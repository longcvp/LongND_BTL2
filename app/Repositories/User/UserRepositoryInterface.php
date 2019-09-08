<?php
namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function createUser($data);

    public function editUser($data);

    public function authLogin($id);

    public function resetPass($email);

    public function changePass($id, $password);

}