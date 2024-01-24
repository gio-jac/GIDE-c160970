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
        $row = Failure::create(['name' => "Mecanica"]);
        //$row->types()->attach([2,3,4,5,6,7,8,11]);

        $row = Failure::create(['name' => "Electrica"]);
        //$row->types()->attach([2,3,5,6,9,11,18]);

        $row = Failure::create(['name' => "Electronica"]);
        //$row->types()->attach([2,3,5,6,8,9,11,15,18]);

        $row = Failure::create(['name' => "Red"]);
        //$row->types()->attach([2,3,5,6,8,9,11,18]);

        $row = Failure::create(['name' => "Software"]);
        //$row->types()->attach([2,3,6,8,9,11,19]);

        $row = Failure::create(['name' => "Neumatica"]);
        //$row->types()->attach([1,2,5,6,11,17]);
    }
}
