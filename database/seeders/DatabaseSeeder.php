<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserTypeSeeder::class,
            UserTitleSeeder::class,
            ClientSeeder::class,
            CountrySeeder::class,
            CodeSeeder::class,
            ShiftSeeder::class,
        ]);
    }
}
