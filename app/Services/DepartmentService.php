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

        //Creates an associative array where key is user id and value is position of that user in that department
        foreach ($request->users as $user) {
            $syncData[$user['id']] = ['position' => $user['position']];
        }

        //Syncs the prepared users with positions with the corresponding department id in the pivot table
        $department->users()->sync($syncData);
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
