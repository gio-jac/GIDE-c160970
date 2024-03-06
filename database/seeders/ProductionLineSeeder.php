<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductionLine;

class ProductionLineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProductionLine::create(['name'=> 'Piso 1']);
        ProductionLine::create(['name'=> 'Planta baja']);
        ProductionLine::create(['name'=> 'GDL']);
    }
}
