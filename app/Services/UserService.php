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
        return User::query()->where("role_id", 2)->get();
    }
    public function create($data)
    {
        $user = new User($data);
        $user->save();
        return $user;
    }

    public function getUser($userId)
    {
        return User::query()->find($userId);
    }

    public function updateUser($data, $user)
    {
        return $user->update($data);

    }

    public function deleteUser(User $user)
    {
        $user->delete();
    }

    public function getRoles()
    {
        return Role::all();
    }

    public function createRole($data){
        $role = new Role($data);
        $role->save();
        return $role;
    }
    public function updateRole($data, $role){
        return $role->update($data);
    }
    public function deleteRole(Role $role){
        $role->delete();
    }

    public function getRole($roleId)
    {
        return Role::query()->find($roleId);
    }
}
