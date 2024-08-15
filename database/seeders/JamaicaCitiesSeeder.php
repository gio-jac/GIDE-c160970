<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\machine_reports\City;

class JamaicaCitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $city = 5;
        City::create(['name' => 'Kingston', 'country_id' => $city]);
        City::create(['name' => 'Portmore', 'country_id' => $city]);
        City::create(['name' => 'Montego Bay', 'country_id' => $city]);
        City::create(['name' => 'Spanish Town', 'country_id' => $city]);
        City::create(['name' => 'May Pen', 'country_id' => $city]);
        City::create(['name' => 'Mandeville', 'country_id' => $city]);
        City::create(['name' => 'Old Harbour', 'country_id' => $city]);
        City::create(['name' => 'Savanna-la-Mar', 'country_id' => $city]);
        City::create(['name' => 'Ocho Rios', 'country_id' => $city]);
        City::create(['name' => 'Linstead', 'country_id' => $city]);
        City::create(['name' => 'Port Antonio', 'country_id' => $city]);
        City::create(['name' => "Saint Ann's Bay", 'country_id' => $city]);
        City::create(['name' => 'Morant Bay', 'country_id' => $city]);
        City::create(['name' => 'Yallahs', 'country_id' => $city]);
        City::create(['name' => 'Hayes', 'country_id' => $city]);
        City::create(['name' => 'Santa Cruz', 'country_id' => $city]);
    }
}
