<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentsUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $position = ['Junior','Senior','Manager', 'Intern' ];
        $users = User::all();
        foreach ($users as $user) {
            DB::table('departments_users')->insert([
                'user_id' => $user->id,
                'department_id' => rand(1, 4),
                'position' => $position[array_rand($position)],
            ]);
        }
    }
}
