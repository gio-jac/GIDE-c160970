<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Country::create(['name' => "Brasil"]);
        Country::create(['name' => "Mexico"]);
        Country::create(['name' => "Chile"]);
        Country::create(['name' => "Colombia"]);
        Country::create(['name' => "Jamaica"]);
    }
}
