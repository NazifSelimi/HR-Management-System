<?php

namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\DB;

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

    public function getUserById($id)
    {
        return User::with(['projects', 'departments'])->find($id);
    }

    public function create($data)
    {
        $user = new User($data);
        $user->save();
        return $user;
    }

//    public function getUserById($userId)
//    {
//        return User::query()->find($userId);
//    }
    public function assignDepartments($user, $request)
    {
        $syncData = [];
        foreach ($request->departments as $department) {
            $syncData[$department['id']] = ['position' => $department['position']];
        }
        $user->departments()->sync($syncData);
    }

    public function assignProjects($user, $request)
    {
        $syncData = [];
        foreach ($request->projects as $project) {
            $syncData[$project['id']] = ['role' => $project['role']];
        }
        $user->projects()->sync($syncData);
    }

    public function assignProject()
    {

    }

//    public function getUserById($userId)
//    {
//        return User::query()->find($userId);
//    }

    public function updateUser($data, $user)
    {
        return $user->update($data);

    }

    public function deleteUser($user)
    {
        $user->delete();
    }

}
