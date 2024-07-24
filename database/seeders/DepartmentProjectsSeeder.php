<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentProjectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = Project::all();

        foreach ($projects as $project) {
                DB::table('departments_projects')->insert([
                    'department_id' => rand(1, 4),
                    'project_id' => $project->id,
                ]);
        }
    }
}
