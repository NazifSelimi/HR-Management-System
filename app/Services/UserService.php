<?php

namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        // Get the user by the given id and eager load their projects and departments
        // where this user is part of the projects and departments
        $user = User::with([
            'projects' => function ($query) use ($id) {
                $query->whereRelation('users', 'user_id', $id); // Filter projects by user id
            },
            'departments' => function ($query) use ($id) {
                $query->whereRelation('users', 'user_id', $id); // Filter departments by user id
            }
        ])->find($id);

        return $user;
    }

    public function create($data)
    {
        //DB::beginTransaction();
        //Create a new user record and store it in the database
        $user = new User($data);
        $user->save();
        //DB::commit();
        return $user;
    }

    public function updatePassword($user, $password)
    {
        $user->password = Hash::make($password);
        if ($user->must_change_password) {
            $user->must_change_password = false; // User no longer required to change password

        }
        $user->save();
    }

    public function assignDepartments($user, $request)
    {


        $syncData = [];
        $response = []; //why array?
        $existingAssignments = $user->departments()->pluck('department_id', 'position')->toArray();
        //Creates an associative array where key is department id and value is position of that user in that department
        foreach ($request->departments as $department) {
            if (!array_key_exists($department['id'], $existingAssignments)) {
                $syncData[$department['id']] = ['position' => $department['position']];
                $response[] = response()->json(['message' => 'Department assigned Successfully']);
            } else {
                $response[] = response()->json(['message' => 'Department already assigned']);
            }
        }

        //Syncs the prepared departments with positions with the corresponding user id in the pivot table
        $user->departments()->syncWithoutDetaching($syncData);
    }

    public function assignProjects($user, $request)
    {
        $syncData = [];
        $response = [];
        $existingAssignments = $user->projects()->pluck('project_id', 'role')->toArray();

        //Creates an associative array where key is project id and value is role of that user in that project
        foreach ($request->projects as $project) {
            if (!array_key_exists($project['id'], $existingAssignments)) {
                $syncData[$project['id']] = ['role' => $project['role']];
                $response[] = response()->json(['message' => 'Project Assigned Successfully']);
            } else {
                $response[] = response()->json(['message' => 'Project already assigned']);
            }
        }

        //Syncs the prepared projects with roles with the corresponding user id in the pivot table
        $user->projects()->syncWithoutDetaching($syncData);
    }

    public function removeFromProject(User $user, $projects)
    {
        $response = [];
        $existingAssignments = $user->projects()->pluck('project_id')->toArray();

        foreach ($projects as $project) {
            if (in_array($project['id'], $existingAssignments)) {
                // Detach the project from the user
                $user->projects()->detach($project['id']);
                $response[] = ['message' => "Project with ID {$project['id']} removed successfully"];
            } else {
                $response[] = ['message' => "Project with ID {$project['id']} not found for this user"];
            }
        }

        return $response;
    }

    public function removeFromDepartment(User $user, $departments)
    {
        $response = [];
        $existingAssignments = $user->departments()->pluck('department_id')->toArray();

        foreach ($departments as $department) {
            if (in_array($department['id'], $existingAssignments)) {
                // Detach the department from the user
                $user->departments()->detach($department['id']);
                $response[] = ['message' => "Department with ID {$department['id']} removed successfully"];
            } else {
                $response[] = ['message' => "Department with ID {$department['id']} not found for this user"];
            }
        }

        return $response;
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
