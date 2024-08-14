<?php

namespace App\Services;


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
