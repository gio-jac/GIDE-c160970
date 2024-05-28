<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\machine_reports\Code;

class CodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Code::create(['code' => "EMC", 'description' => "Mantenimiento Esencial"]);
        Code::create(['code' => "TECH", 'description' => "Soporte por Llamada"]);
        Code::create(['code' => "INST", 'description' => "Instalacion de Equipo"]);
        Code::create(['code' => "SAT", 'description' => "Prueba de Aceptacion en Sitio"]);
        Code::create(['code' => "DEIN", 'description' => "Desinstalacion"]);
        Code::create(['code' => "PM", 'description' => "Mantenimiento Preventivo"]);
        Code::create(['code' => "MISC", 'description' => "Miscelaneos"]);
        Code::create(['code' => "SITE", 'description' => "Soporte en Sitio"]);
    }
}
