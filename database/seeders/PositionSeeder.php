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
            ['name' => 'Frontend Developer', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Backend Developer', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Full Stack Developer', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Quality Assurance (QA) Engineer', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'DevOps Engineer', 'created_at' => now(), 'updated_at' => now()],

            // IT Support and Services DepartmentService (DepartmentService ID 2)
            ['name' => 'Help Desk Technician', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Network Administrator', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'System Administrator', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'IT Security Specialist', 'created_at' => now(), 'updated_at' => now()],

            // Project Management DepartmentService (DepartmentService ID 3)
            ['name' => 'Project Manager', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Business Analyst', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Scrum Master', 'created_at' => now(), 'updated_at' => now()],

            // Sales and Marketing DepartmentService (DepartmentService ID 4)
            ['name' => 'Sales Representative', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Digital Marketing Specialist', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Content Creator', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'CRM Manager', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('positions')->insert($positions);
    }
}
