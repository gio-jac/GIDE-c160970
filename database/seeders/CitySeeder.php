<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        City::create(['name' => 'Guadalajara', 'state_id' => 4]);
        City::create(['name' => 'Acapulco', 'state_id' => 3]);
        City::create(['name' => 'Azcapotzalco', 'state_id' => 1]);
        City::create(['name' => 'Zaragoza', 'state_id' => 7]);
        City::create(['name' => 'Cuauhtémoc', 'state_id' => 1]);
        City::create(['name' => 'Zapopan', 'state_id' => 4]);
        City::create(['name' => 'Iztapalapa', 'state_id' => 1]);
        City::create(['name' => 'Iztacalco', 'state_id' => 1]);
    }
}
