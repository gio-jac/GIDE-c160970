<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\machine_reports\UserTitles;

class UserTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //UserTitles::create(['titulo' => "Field Engineer JR"]);
        //UserTitles::create(['titulo' => "Field Engineer SR"]);
        //UserTitles::create(['titulo' => "Coordinator"]);
        //UserTitles::create(['titulo' => "Tech Support"]);
        //UserTitles::create(['titulo' => "Tech Support Specialist"]);
        //UserTitles::create(['titulo' => "Manager"]);
        //UserTitles::create(['titulo' => "Finance"]);
        UserTitles::create(['titulo' => "Field Engineer JR"]);
        UserTitles::create(['titulo' => "Field Engineer", "is_active" => false]);
        UserTitles::create(['titulo' => "Field Technician", "is_active" => false]);
        UserTitles::create(['titulo' => "Maintenance Coordinator", "is_active" => false]);
        UserTitles::create(['titulo' => "Manager"]);
        UserTitles::create(['titulo' => "On Site Support", "is_active" => false]);
        UserTitles::create(['titulo' => "Field Engineer SR"]);
        UserTitles::create(['titulo' => "Supervisor", "is_active" => false]);
        UserTitles::create(['titulo' => "System Analyst", "is_active" => false]);
        UserTitles::create(['titulo' => "Tech Support"]);
        UserTitles::create(['titulo' => "Tech Support Specialist"]);
        UserTitles::create(['titulo' => "Coordinator"]);
        UserTitles::create(['titulo' => "Finance"]);
    }
}
