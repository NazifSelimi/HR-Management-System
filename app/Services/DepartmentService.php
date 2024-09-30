<?php

namespace App\Services;

use App\Models\Department;
use Illuminate\Support\Facades\DB;

class DepartmentService
{
    public function getDepartments()
    {
        //Get all departments; Eager load project and user relationships
        return Department::with(['projects', 'users'])->get();
    }

    public function getDepartmentById($id)
    {
        //Get specific department; Eager load project and user relationships
        return Department::with(['projects', 'users'])->find($id);
    }

    public function getEmployeeDepartments($userId)
    {
        return Department::whereRelation('users', 'user_id', $userId)->get();
    }

    public function getEmployeeDepartmentsById($departmentId)
    {
        return Department::with('users')->findOrFail($departmentId);
    }


    public function create($data)
    {
        //Create new department instance and store it in the database
        $department = new Department($data);
        $department->save();
        return $department;
    }

    public function assignUsers($department, $request)
    {
        $syncData = [];
        $response = [];
        $existingAssignments = $department->users()->pluck('position', 'user_id')->toArray();

        //Creates an associative array where key is user id and value is position of that user in that department
        foreach ($request->users as $user) {

            if (!array_key_exists($user['id'], $existingAssignments)) {

                $syncData[$user['id']] = ['position' => $user['position']];
                $response[] = response()->json(['message' => 'User assigned successfully.']);
            } else {
                $response[] = response()->json(['message' => 'This user is already assigned to this department.']);
            }
        }

        //Syncs the prepared users with positions with the corresponding department id in the pivot table
        $department->users()->syncWithoutDetaching($syncData);
        return $response;
    }

    public function assignProjects($department, $request)
    {
        $syncData = [];
        $response = [];
        $existingAssignments = $department->projects()->pluck('project_id')->toArray();

        //Creates an associative array where key is user id and value is position of that user in that department
        foreach ($request->projects as $project) {

            if (!array_key_exists($project['id'], $existingAssignments)) {

                $syncData[$project['id']] = ['project_id' => $project['id']];
                $response[] = response()->json(['message' => 'Project assigned successfully.']);
            } else {
                $response[] = response()->json(['message' => 'This project is already assigned to this department.']);
            }
        }

        //Syncs the prepared users with positions with the corresponding department id in the pivot table
        $department->projects()->syncWithoutDetaching($syncData);
        return $response;
    }

    public function updateUserPosition(Department $department, $users)
    {
        $updateData = [];
        $response = [];

        // Get the list of user_ids already assigned to the department
        $existingAssignments = $department->users()->pluck('user_id')->toArray();

        // Create an associative array where key is user id and value is the updated position for that user in the department
        foreach ($users as $user) {
            if (in_array($user['id'], $existingAssignments)) {
                // If user exists in the department, update their position
                $updateData[$user['id']] = ['position' => $user['position']];
                $response[] = ['message' => "User ID {$user['id']}: role updated successfully in department with ID {$department->id}."];
            } else {
                $response[] = ['message' => "User ID {$user['id']}: is not assigned to department with ID {$department->id}."];
            }
        }

        // Syncs the users' positions, updating the pivot table for the corresponding department
        $department->users()->syncWithoutDetaching($updateData);

        return $response;
    }


    public function update($data, $department)
    {
        //Update existing department record with new data
        $department->update($data);
        return $department;
    }

    public function delete($department)
    {
        //Delete department record
        $department->delete();
    }

}
