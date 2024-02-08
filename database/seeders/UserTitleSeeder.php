<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserTitles;

class UserTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserTitles::create(['titulo' => "Especialist Support"]);
        UserTitles::create(['titulo' => "Field Engineer"]);
        UserTitles::create(['titulo' => "Field Technician"]);
        UserTitles::create(['titulo' => "Maintenance Coordinator"]);
        UserTitles::create(['titulo' => "Manager"]);
        UserTitles::create(['titulo' => "On Site Support"]);
        UserTitles::create(['titulo' => "SR Field Engineer"]);
        UserTitles::create(['titulo' => "Supervisor"]);
        UserTitles::create(['titulo' => "System Analyst"]);
        UserTitles::create(['titulo' => "Tech Support"]);
    }
}
