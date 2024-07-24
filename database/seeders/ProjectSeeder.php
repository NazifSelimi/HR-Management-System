<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('projects')->insert([
            [    'name' => 'E-commerce Platform Development',
                'description' => 'Develop a comprehensive e-commerce platform with features like product listings, shopping carts, payment gateways, and user accounts. The project involves both frontend and backend development, as well as integration with third-party APIs for payment and shipping.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mobile Banking App',
                'description' => 'Create a secure mobile banking application that allows users to manage their accounts, transfer funds, pay bills, and view transaction history. This project focuses on high security and user-friendly interface design.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Network Infrastructure Upgrade',
                'description' => 'Upgrade the company’s network infrastructure to improve speed, reliability, and security. This includes installing new hardware, updating software, and implementing advanced network security protocols.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'IT Help Desk Automation',
                'description' => 'Develop and implement an automated help desk system using AI and machine learning to handle common IT support queries, reducing response times and improving efficiency.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Agile Transformation',
                'description' => 'Implement Agile methodologies across the company’s projects to improve flexibility, collaboration, and delivery speed. This project involves training, process re-engineering, and tool implementation.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Client Project Portfolio Management',
                'description' => 'Develop a centralized system for managing all client projects, tracking progress, budgets, and resource allocation. This system helps in providing better transparency and control over multiple projects.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Digital Marketing Campaign Optimization',
                'description' => ' Develop a tool to optimize digital marketing campaigns by analyzing data from various platforms (social media, email, search engines) to improve targeting, engagement, and conversion rates.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Customer Relationship Management (CRM) System',
                'description' => 'Implement a CRM system to manage interactions with current and potential customers. The system helps streamline processes, improve customer service, and increase sales.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
