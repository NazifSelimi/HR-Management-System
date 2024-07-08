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

    public function create($data)
    {
        DB::beginTransaction();
        $department = new Department($data);
        $department->save();
        if($department->id)
        {
            DB::commit();
            return true;
        }
        else{
            DB::rollBack();
            throw new \Exception("Department not created");
        }

    }

    public function update($data, $department)
    {
        DB::beginTransaction();

        if($department->id)
        {
            $department->update($data);
            $department->save();
            DB::commit();
            return true;
        }
        else{
            DB::rollBack();
            throw new \Exception("Department not updated or does not exist");
        }
    }

    public function delete($department)
    {
        $department->delete();
    }

}
