<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            // Software Development DepartmentService (DepartmentService ID 1)
            ['name' => 'Frontend Developer', 'project_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Backend Developer', 'project_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Full Stack Developer', 'project_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Quality Assurance (QA) Engineer', 'project_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'DevOps Engineer', 'project_id' => 2, 'created_at' => now(), 'updated_at' => now()],

            // IT Support and Services DepartmentService (DepartmentService ID 2)
            ['name' => 'Help Desk Technician', 'project_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Network Administrator', 'project_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'System Administrator', 'project_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'IT Security Specialist', 'project_id' => 4, 'created_at' => now(), 'updated_at' => now()],

            // Project Management DepartmentService (DepartmentService ID 3)
            ['name' => 'Project Manager', 'project_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Business Analyst', 'project_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Scrum Master', 'project_id' => 5, 'created_at' => now(), 'updated_at' => now()],

            // Sales and Marketing DepartmentService (DepartmentService ID 4)
            ['name' => 'Sales Representative', 'project_id' => 8, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Digital Marketing Specialist', 'project_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Content Creator', 'project_id' => 7, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'CRM Manager', 'project_id' => 8, 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('positions')->insert($positions);
    }
}
