<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departmentNames = [
            ['name'=>'Software Development'],
            ['name'=>' IT Support and Services'],
            ['name'=>'Project Management'],
            ['name'=>'Sales and Marketing]']
        ];

        DB::table('departments')->insert($departmentNames);
    }
}
