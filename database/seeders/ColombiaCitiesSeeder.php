<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\machine_reports\City;

class ColombiaCitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $city = 4;
        City::create(['name' => 'Bogotá', 'country_id' => $city]);
        City::create(['name' => 'Medellín', 'country_id' => $city]);
        City::create(['name' => 'Cali', 'country_id' => $city]);
        City::create(['name' => 'Barranquilla', 'country_id' => $city]);
        City::create(['name' => 'Cartagena', 'country_id' => $city]);
        City::create(['name' => 'Cúcuta', 'country_id' => $city]);
        City::create(['name' => 'Soledad', 'country_id' => $city]);
        City::create(['name' => 'Ibagué', 'country_id' => $city]);
        City::create(['name' => 'Soacha', 'country_id' => $city]);
        City::create(['name' => 'Bucaramanga', 'country_id' => $city]);
        City::create(['name' => 'Villavicencio', 'country_id' => $city]);
        City::create(['name' => 'Santa Marta', 'country_id' => $city]);
        City::create(['name' => 'Valledupar', 'country_id' => $city]);
        City::create(['name' => 'Bello', 'country_id' => $city]);
        City::create(['name' => 'Pereira', 'country_id' => $city]);
    }
}
