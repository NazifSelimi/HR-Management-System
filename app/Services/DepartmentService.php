<?php

namespace App\Services;

use App\Models\Department;
use Illuminate\Support\Facades\DB;

class DepartmentService
{
    public function getDepartments()
    {
        return Department::all();
    }

    public function getDepartmentById($id)
    {
        return Department::query()->find($id);
    }

    public function create($data)
    {
        $department = new Department($data);
        $department->save();
        if($department->id)
        {
            return true;
        }
        else{
            throw new \Exception("Department not created");
        }

    }

    public function update($data, $department)
    {
        if($department->id)
        {
            $department->update($data);
            return true;
        }
        else{
            throw new \Exception("Department not updated or does not exist");
        }
    }

    public function delete($department)
    {
        $department->delete();
    }

}
