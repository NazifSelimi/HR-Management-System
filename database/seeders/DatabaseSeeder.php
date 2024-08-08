<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(DepartmentsUsersSeeder::class);
        $this->call(ProjectUsersSeeder::class);
        $this->call(DepartmentProjectsSeeder::class);

    }
}
