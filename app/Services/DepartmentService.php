<?php

namespace App\Services;

use App\Models\Department;
use Illuminate\Support\Facades\DB;

class DepartmentService
{
    public function getDepartments()
    {
        return Department::with(['projects', 'users'])->get();
    }

    public function getDepartmentById($id)
    {
        return Department::with(['projects', 'users'])->find($id);
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
