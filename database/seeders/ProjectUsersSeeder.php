<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $projects = Project::all();
        $role = ['Designer','FrontEnd Developer','Back End Developer', 'UX/UI Designer' ];


        foreach ($users as $user) {
            foreach ($projects as $project) {
                DB::table('projects_users')->insert([
                'user_id' => $user->id,
                'project_id' => $project->id,
                'role' => $role[array_rand($role)],
                ]);
            }
        }
    }
}
