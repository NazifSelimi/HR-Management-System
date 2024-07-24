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
        return $department;
    }

    public function update($data, $department)
    {
        $department->update($data);
        return $department;
    }

    public function delete($department)
    {
        $department->delete();
    }

}
