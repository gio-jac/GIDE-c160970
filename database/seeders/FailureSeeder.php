<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Failure;

class FailureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Failure::create(['name' => 'MECHNICAL COUPLING']);
        Failure::create(['name' => 'FEEDER']);
        Failure::create(['name' => 'HIGH ROOM TEMPERATURE']);
        Failure::create(['name' => 'BARRA DE SELAGEM']);
        Failure::create(['name' => 'VACUUM PUMP']);
        Failure::create(['name' => 'BUTTON']);
        Failure::create(['name' => 'EMERGENCY BUTTON']);
        Failure::create(['name' => 'SEALING HEAD']);
        Failure::create(['name' => 'DAMAGED CABLE']);
        Failure::create(['name' => 'CAMERA']);
        Failure::create(['name' => 'OPERATIONAL TRAINING']);
        Failure::create(['name' => 'TECHNICAL TRAINING']);
        Failure::create(['name' => 'PLC']);
        Failure::create(['name' => 'COMPASS VMS']);
        Failure::create(['name' => 'AIR COMPRESSOR']);
        Failure::create(['name' => 'CONFIGURATION']);
        Failure::create(['name' => 'CONTACTOR']);
        Failure::create(['name' => 'ACCESS CONTROL']);
        Failure::create(['name' => 'BELT']);
        Failure::create(['name' => 'ELETRONIC FAILURE']);
        Failure::create(['name' => 'MECHANICAL WEAR']);
        Failure::create(['name' => 'DESKTOP']);
        Failure::create(['name' => 'SOLENOID']);
        Failure::create(['name' => 'CIRCUIT BREAKER']);
        Failure::create(['name' => 'THOOTHED GEAR']);
        Failure::create(['name' => 'CLOGGING']);
        Failure::create(['name' => 'STABILIZER']);
        Failure::create(['name' => 'CONVEYOR']);
        Failure::create(['name' => 'NETWORK FAILURE']);
        Failure::create(['name' => 'COMPACTION FAILURE']);
        Failure::create(['name' => 'OPERATIONAL ERROR']);
        Failure::create(['name' => 'LACK OF LUBRICATION']);
        Failure::create(['name' => 'FILTER']);
        Failure::create(['name' => 'POWER SUPPLY']);
        Failure::create(['name' => 'FUSE']);
        Failure::create(['name' => 'PRINTER']);
        Failure::create(['name' => 'CUTTING BLADE']);
        Failure::create(['name' => 'INTERNET LINK']);
        Failure::create(['name' => 'HOSE']);
        Failure::create(['name' => 'MANOMETER']);
        Failure::create(['name' => 'BAD CONTACT']);
        Failure::create(['name' => 'MICRO SWITCH']);
        Failure::create(['name' => 'FOREIGN CURRENCY']);
        Failure::create(['name' => 'MOTOR']);
        Failure::create(['name' => 'MOUSE']);
        Failure::create(['name' => 'NOBREAK']);
        Failure::create(['name' => 'NVR']);
        Failure::create(['name' => 'ORING']);
        Failure::create(['name' => 'RAS']);
        Failure::create(['name' => 'RELE']);
        Failure::create(['name' => 'RESISTANCE']);
        Failure::create(['name' => 'RETEINER']);
        Failure::create(['name' => 'BALL BARING']);
        Failure::create(['name' => 'LVM DRYER']);
        Failure::create(['name' => 'ASYNCRONOUS']);
        Failure::create(['name' => 'SENSOR']);
        Failure::create(['name' => 'COMPASS SERVER']);
        Failure::create(['name' => 'BPS SOFTWARE']);
        Failure::create(['name' => 'BROKEN COVER']);
        Failure::create(['name' => 'KEYBOARD']);
        Failure::create(['name' => 'TEFLON']);
        Failure::create(['name' => 'CONTRACT TERMINATION']);
        Failure::create(['name' => 'TRANSFER']);
        Failure::create(['name' => 'VALVE']);
        Failure::create(['name' => 'PREVENTIVE']);
        Failure::create(['name' => 'UNPRODUCTIVE']);
        Failure::create(['name' => 'TRAINING']);
        Failure::create(['name' => 'INSTALLATION']);
    }
}
