<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Shift;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Shift::create(['name' => "Morning"]);
        Shift::create(['name' => "Afternoon"]);
        Shift::create(['name' => "Night"]);
    }
}
