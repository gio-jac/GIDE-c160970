<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MachineModels;

class MachineModelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MachineModels::create(['model' => "BPS B1",'model_segment_id' => 1]);
        MachineModels::create(['model' => "BPS C1-D",'model_segment_id' => 1]);
        MachineModels::create(['model' => "BPS C1-F",'model_segment_id' => 1]);
        MachineModels::create(['model' => "BPS C2",'model_segment_id' => 1]);
        MachineModels::create(['model' => "BPS C2 1.0 - 1.5",'model_segment_id' => 1]);
        MachineModels::create(['model' => "BPS C2 2X",'model_segment_id' => 1]);
        MachineModels::create(['model' => "BPS C2 2.10",'model_segment_id' => 1]);
        MachineModels::create(['model' => "BPS C4",'model_segment_id' => 1]);
        MachineModels::create(['model' => "BPS C5",'model_segment_id' => 1]);
        MachineModels::create(['model' => "BPS C6",'model_segment_id' => 1]);
        MachineModels::create(['model' => "COIN100",'model_segment_id' => 1]);
        MachineModels::create(['model' => "COIN 120",'model_segment_id' => 1]);
        MachineModels::create(['model' => "COIN 200",'model_segment_id' => 1]);
        MachineModels::create(['model' => "COIN 300",'model_segment_id' => 1]);
        MachineModels::create(['model' => "CASHWORK ONE",'model_segment_id' => 1]);
        MachineModels::create(['model' => "NGZ COIN SORTER Q12",'model_segment_id' => 1]);
        MachineModels::create(['model' => "PRONOTE 1",'model_segment_id' => 1]);
        MachineModels::create(['model' => "PRONOTE 1.5",'model_segment_id' => 1]);
        MachineModels::create(['model' => "PRONOTE 100",'model_segment_id' => 1]);
        MachineModels::create(['model' => "PRONOTE 120",'model_segment_id' => 1]);
        MachineModels::create(['model' => "PRONOTE 130",'model_segment_id' => 1]);
        MachineModels::create(['model' => "PRONOTE 200",'model_segment_id' => 1]);
        MachineModels::create(['model' => "PRONOTE 300",'model_segment_id' => 1]);
        MachineModels::create(['model' => "PRONOTE 330",'model_segment_id' => 1]);
        MachineModels::create(['model' => "PRONOTE VM",'model_segment_id' => 1]);
        MachineModels::create(['model' => "PRONOTE VM 3.1",'model_segment_id' => 1]);
        MachineModels::create(['model' => "NUMERON",'model_segment_id' => 1]);
        MachineModels::create(['model' => "BPS M3",'model_segment_id' => 2]);
        MachineModels::create(['model' => "BPS M5",'model_segment_id' => 2]);
        MachineModels::create(['model' => "BPS M5 UPGRADE",'model_segment_id' => 2]);
        MachineModels::create(['model' => "BPS M7",'model_segment_id' => 2]);
        MachineModels::create(['model' => "BPS M7 UPGRADE",'model_segment_id' => 2]);
        MachineModels::create(['model' => "NOTATRACC L",'model_segment_id' => 2]);
        MachineModels::create(['model' => "BPS EVO",'model_segment_id' => 2]);
        MachineModels::create(['model' => "BPS 500",'model_segment_id' => 2]);
        MachineModels::create(['model' => "BPS 1000",'model_segment_id' => 2]);
        MachineModels::create(['model' => "BPS 200",'model_segment_id' => 2]);
        MachineModels::create(['model' => "BPS X9",'model_segment_id' => 3]);
        MachineModels::create(['model' => "BPS 2000",'model_segment_id' => 3]);
        MachineModels::create(['model' => "BPS 3000",'model_segment_id' => 3]);
        MachineModels::create(['model' => "OBIS 3",'model_segment_id' => 3]);
        MachineModels::create(['model' => "NOTAMASTER",'model_segment_id' => 3]);

    }
}
