<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FailureType;

class FailureTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FailureType::create(['name' => "Aire Comprimido"]);
        FailureType::create(['name' => "Ajuste"]);
        FailureType::create(['name' => "Atasco"]);
        FailureType::create(['name' => "Bandas"]);
        FailureType::create(['name' => "Calibración"]);
        FailureType::create(['name' => "Cambio de Refacción"]);
        FailureType::create(['name' => "Carrier"]);
        FailureType::create(['name' => "Colisión"]);
        FailureType::create(['name' => "Comunicación"]);
        FailureType::create(['name' => "Desinstalación"]);
        FailureType::create(['name' => "Dispositivo de Seguridad"]);
        FailureType::create(['name' => "Error de Operación"]);
        FailureType::create(['name' => "Error de Producción"]);
        FailureType::create(['name' => "Falla Eléctrica"]);
        FailureType::create(['name' => "Fotodetector"]);
        FailureType::create(['name' => "Instalación"]);
        FailureType::create(['name' => "Pistón"]);
        FailureType::create(['name' => "Redundancia"]);
        FailureType::create(['name' => "Reinicio de Computadora"]);
    }
}
