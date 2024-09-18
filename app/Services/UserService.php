<?php

namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{

    public function getEmployees()
    {
        //Get users that have role employee
        return User::query()->where("role", 'employee')->get();
    }

    public function getUsers()
    {
        //Get all users
        return User::query()->get();
    }

    public function getUserById($id)
    {
        //Get specific user record by given id; Also eager load their relationships: Projects and departments
        return User::with(['projects', 'departments'])->find($id);
    }

    public function create($data)
    {
        //Create a new user record and store it in the database
        $user = new User($data);
        $user->save();
        return $user;
    }

    public function assignDepartments($user, $request)
    {

        $syncData = [];

        //Creates an associative array where key is department id and value is position of that user in that department
        foreach ($request->departments as $department) {
            $syncData[$department['id']] = ['position' => $department['position']];
        }

        //Syncs the prepared departments with positions with the corresponding user id in the pivot table
        $user->departments()->sync($syncData);
    }

    public function assignProjects($user, $request)
    {
        $syncData = [];

        //Creates an associative array where key is project id and value is role of that user in that project
        foreach ($request->projects as $project) {
            $syncData[$project['id']] = ['role' => $project['role']];
        }

        //Syncs the prepared projects with roles with the corresponding user id in the pivot table
        $user->projects()->syncWithoutDetaching($syncData);
    }



    public function updateUser($data, $user)
    {
        //Update user record with data
        return $user->update($data);
    }

    public function deleteUser($user)
    {
        //Delete user record
        $user->delete();
    }

}
