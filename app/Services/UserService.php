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
        return User::with(['projects' , 'departments'])->find($id);
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
        $request->validate([
            'departments' => 'required|array',
            'departments.*.id' => 'exists:departments,id', // Validate that each department ID exists
            'departments.*.position' => 'required|string', // Validate that each position is a string
        ]);

        // Prepare the data for sync
        $syncData = [];
        foreach ($request->departments as $department) {
            $syncData[$department['id']] = ['position' => $department['position']];
        }

        // Sync the departments with the user, including the position
        $user->departments()->sync($syncData);
    }

    public function assignProjects($user, $request)
    {
        $request->validate([
            'project' => 'required|array',
            'projects.*.id' => 'exists:projects,id',
            'projects.*.role' => 'required|string',
        ]);
        $syncData = [];
        foreach($request->projects as $project) {
            $syncData[$project['id']] = ['role' => $project['role']];
        }
        $user->projects()->sync($syncData);
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
