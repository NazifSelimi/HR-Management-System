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
