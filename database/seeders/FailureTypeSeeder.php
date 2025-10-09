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
        FailureType::create(['name' => 'ADJUSTMENT', 'es' => 'AJUSTE', 'pt' => 'AJUSTES']);
        FailureType::create(['name' => 'UPDATE', 'es' => 'ACTUALIZAR', 'pt' => 'ATUALIZACAO']);
        FailureType::create(['name' => 'CHANGE OIL', 'es' => 'CAMBIO ACEITE', 'pt' => 'COMPLETAR OLEO']);
        FailureType::create(['name' => 'UNINSTALLATION', 'es' => 'DESINSTALACIÓN', 'pt' => 'DESISNTALACAO']);
        FailureType::create(['name' => 'ADJUST CONNECTORS', 'es' => 'AJUSTAR CONECTORES', 'pt' => 'ELIMINADO MAU CONTATO']);
        FailureType::create(['name' => 'INSTALLATION', 'es' => 'INSTALACIÓN', 'pt' => 'INSTALACAO']);
        FailureType::create(['name' => 'CLEANING', 'es' => 'LIMPIAR', 'pt' => 'LIMPEZA']);
        FailureType::create(['name' => 'REINSTALLATION', 'es' => 'REINSTALACIÓN', 'pt' => 'REINSTALACAO']);
        FailureType::create(['name' => 'RESET', 'es' => 'REINICIAR', 'pt' => 'RESET']);
        FailureType::create(['name' => 'REPLACE PARTS', 'es' => 'SUSTITUCIÓN DE PIEZAS', 'pt' => 'SUBSTITUICAO DE PECA']);
        FailureType::create(['name' => 'PREVENTIVE', 'es' => 'PREVENTIVO', 'pt' => 'PREVENTIVA']);
        FailureType::create(['name' => 'UNPRODUCTIVE', 'es' => 'NO PRODUCTIVO', 'pt' => 'IMPRODUTIVO']);
        FailureType::create(['name' => 'TRAINING', 'es' => 'ENTRENAMIENTO', 'pt' => 'TREINAMENTO']);
        FailureType::create(['name' => 'PREVENTIVE MAINTENANCE, 500 HRS', 'es' => 'MANTENIMIENTO PREVENTIVO, 500 HRS', 'pt' => 'MANUTENÇÃO PREVENTIVA, 500 HRS']);
        FailureType::create(['name' => 'PREVENTIVE MAINTENANCE, 1000 HRS', 'es' => 'MANTENIMIENTO PREVENTIVO, 1000 HRS', 'pt' => 'MANUTENÇÃO PREVENTIVA, 1000 HRS']);
        FailureType::create(['name' => 'PREVENTIVE MAINTENANCE, 2000 HRS', 'es' => 'MANTENIMIENTO PREVENTIVO, 2000 HRS', 'pt' => 'MANUTENÇÃO PREVENTIVA, 2000 HRS']);
    }
}
