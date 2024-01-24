<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Module;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $row = Module::create(['name' => "Loading"]);
        //$row->failures()->attach([1,2,3,4,6]);

        $row = Module::create(['name' => "Input"]);
        //$row->failures()->attach([1,2,3,4,5,6]);

        $row = Module::create(['name' => "Base"]);
        //$row->failures()->attach([1,2,3,4,5,6]);

        $row = Module::create(['name' => "Reject"]);
        //$row->failures()->attach([1,2,3,4,5,6]);

        $row = Module::create(['name' => "Delivery"]);
        //$row->failures()->attach([1,2,3,4,5,6]);

        $row = Module::create(['name' => "Shredder"]);
        //$row->failures()->attach([1,2,3,4,5,6]);

        $row = Module::create(['name' => "SBU"]);
        //$row->failures()->attach([1,2,3]);

        $row = Module::create(['name' => "Dustovac"]);
        //$row->failures()->attach([1,2]);

        $row = Module::create(['name' => "UPS"]);
        //$row->failures()->attach([2,3]);
    }
}
