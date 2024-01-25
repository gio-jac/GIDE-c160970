<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        State::create(['name' => 'CDMX', 'country_id' => 2]);
        State::create(['name' => 'Edo De Mexico', 'country_id' => 2]);
        State::create(['name' => 'Guerrero', 'country_id' => 2]);
        State::create(['name' => 'Jalisco', 'country_id' => 2]);
        State::create(['name' => 'Morelos', 'country_id' => 2]);
        State::create(['name' => 'Nuevo Leon', 'country_id' => 2]);
        State::create(['name' => 'Puebla', 'country_id' => 2]);
        State::create(['name' => 'Tabasco', 'country_id' => 2]);
        State::create(['name' => 'Veracruz', 'country_id' => 2]);
    }
}
