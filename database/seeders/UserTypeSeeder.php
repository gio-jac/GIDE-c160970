<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserTypes;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserTypes::create([
            'tipo' => "Admin",
        ]);
        UserTypes::create([
            'tipo' => "Engineer",
        ]);
    }
}
