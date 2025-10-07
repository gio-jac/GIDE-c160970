<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->insert([
            ['department' => "México"],
            ['department' => "Jamaica"],
            ['department' => "Colombia"],
            ['department' => "Chile"],
            ['department' => "Brasil"],
        ]);
    }
}