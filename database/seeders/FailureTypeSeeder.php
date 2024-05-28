<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\machine_reports\FailureType;

class FailureTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FailureType::create(['name' => 'ADJUSTMENT']);
        FailureType::create(['name' => 'UPDATE']);
        FailureType::create(['name' => 'CHANGE OIL']);
        FailureType::create(['name' => 'UNISNTALLATION']);
        FailureType::create(['name' => 'ADJUST CONNECTORS']);
        FailureType::create(['name' => 'INSTALLATION']);
        FailureType::create(['name' => 'CLEANING']);
        FailureType::create(['name' => 'REINSTALLATION']);
        FailureType::create(['name' => 'RESET']);
        FailureType::create(['name' => 'REPLACE PARTS']);
        FailureType::create(['name' => 'PREVENTIVE']);
        FailureType::create(['name' => 'UNPRODUCTIVE']);
        FailureType::create(['name' => 'TRAINING']);
    }
}
