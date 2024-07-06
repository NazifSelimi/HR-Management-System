<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'role_id'=>1,
            'email' => 'admin@admin.com',
        ]);
        \App\Models\User::factory()->create([
            'first_name' => 'User',
            'last_name' => 'User',
            'role_id'=>2,
            'email' => 'user@user.com',
        ]);
        \App\Models\User::factory(100)->create();
    }
}
