<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\machine_reports\Module;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Module::create(['name'=> 'PRODUCTION MONITORING']);
        Module::create(['name'=> 'SORTING ADJUSTMENT']);
        Module::create(['name'=> 'EXCESSIVE NOISE']);
        Module::create(['name'=> 'BATTERY DISCHARGED']);
        Module::create(['name'=> 'UNINSTALLATION']);
        Module::create(['name'=> 'SHUTTING DOWN']);
        Module::create(['name'=> 'JAM']);
        Module::create(['name'=> 'SYSTEM DOES NOT SWITCH ON']);
        Module::create(['name'=> 'PHOTODETECTOR ERROR']);
        Module::create(['name'=> 'SENSOR ERROR ']);
        Module::create(['name'=> 'OIL FILTER CLOGGED']);
        Module::create(['name'=> 'ERROR CODE U1U']);
        Module::create(['name'=> 'ERROR CODE U2U']);
        Module::create(['name'=> 'HICH REJECT RATE']);
        Module::create(['name'=> 'FEEDER START ERROR']);
        Module::create(['name'=> 'TRANSPORT START ERROR']);
        Module::create(['name'=> 'POWER SUPPLY FAILURE']);
        Module::create(['name'=> 'CCTV ERROR']);
        Module::create(['name'=> 'BANDING SYSTEM FAILING']);
        Module::create(['name'=> 'COMMUNICATION ERROR']);
        Module::create(['name'=> 'PERIPHERAL FAILURE']);
        Module::create(['name'=> 'SOFTWARE FAILURE']);
        Module::create(['name'=> 'TRANSPORT ERROR']);
        Module::create(['name'=> 'LOADING CONVEYOR ERROR']);
        Module::create(['name'=> 'MECHNICAL FAILURE']);
        Module::create(['name'=> 'FEEDER FAILURE']);
        Module::create(['name'=> 'BROKEN BELT']);
        Module::create(['name'=> 'SHREDDER FAILURE']);
        Module::create(['name'=> 'STACKER ERROR']);
        Module::create(['name'=> 'BUNDLER SYSTEM FAILURE']);
        Module::create(['name'=> 'GRANULATOR ERROR']);
        Module::create(['name'=> 'MONITOR FAILURE']);
        Module::create(['name'=> 'SERVER ERROR']);
        Module::create(['name'=> 'VACUUM SYSTEM FAILURE']);
        Module::create(['name'=> 'CONTROL PAINEL ERROR']);
        Module::create(['name'=> 'STRAP DOES NOT CUT']);
        Module::create(['name'=> 'INSTALLATION']);
        Module::create(['name'=> 'PREVENTIVE MAINTENANCE']);
        Module::create(['name'=> 'OPEN COVER ERROR']);
        Module::create(['name'=> 'HIGH OIL TEMP. ']);
        Module::create(['name'=> 'OPERATING TRAINING']);
        Module::create(['name'=> 'AIR LEAKAGE']);
        Module::create(['name'=> 'OIL LEAKAGE']);
    }
}
