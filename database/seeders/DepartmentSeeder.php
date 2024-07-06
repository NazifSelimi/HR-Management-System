<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departmentNames = ['Software Development', ' IT Support and Services', 'Project Management', 'Sales and Marketing'];

        foreach ($departmentNames as $departmentName) {
            Department::create([
                'name' => $departmentName,
            ]);
        }
    }
}
