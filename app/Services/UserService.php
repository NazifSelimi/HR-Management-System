<?php

namespace App\Services;


use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\throwException;

class UserService
{

    public function getEmployees()
    {
        return User::query()->where("role", 'employee')->get();
    }

    public function getUsers()
    {
        return User::query()->get();
    }

    public function create($data)
    {
        $user = new User($data);
        $user->save();
        return $user;
    }

    public function getUserById($userId)
    {
        return User::query()->find($userId);
    }

    public function updateUser($data, $user)
    {
        return $user->update($data);

    }

    public function deleteUser($user)
    {
        $user->delete();
    }

}
