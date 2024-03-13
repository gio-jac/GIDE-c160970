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
        Country::create(['name' => "Brasil", 'code' => 'BR']);
        Country::create(['name' => "Mexico", 'code' => 'MX']);
        Country::create(['name' => "Chile", 'code' => 'CL']);
        Country::create(['name' => "Colombia", 'code' => 'CO']);
        Country::create(['name' => "Jamaica", 'code' => 'JM']);
    }
}
