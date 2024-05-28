<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\machine_reports\ModelSegments;

class ModelSegmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelSegments::create(['segment' => "C"]);
        ModelSegments::create(['segment' => "M"]);
        ModelSegments::create(['segment' => "X", 'is_multi_transport' => true, 'is_multi_signature' => true]);
        ModelSegments::create(['segment' => "BANKNOTE PAKING SYSTEM"]);
        ModelSegments::create(['segment' => "BANKNOTE DESTRUCTION SYSTEMS"]);
        ModelSegments::create(['segment' => "AIR SUPPLY"]);
        ModelSegments::create(['segment' => "SHREDDER WASTE DISPOSAL"]);
        ModelSegments::create(['segment' => "DUST REMOVAL UNIT"]);
        ModelSegments::create(['segment' => "BPS ECO-SYSTEM"]);
    }
}
