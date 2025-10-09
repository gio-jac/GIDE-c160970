<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\machine_reports\Failure;

class FailureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Failure::create(['name' => 'MECHNICAL COUPLING', 'es' => 'ACOPLAMIENTO TÉCNICO', 'pt' => 'ACOPLAMENTO MECANICO']);
        Failure::create(['name' => 'FEEDER', 'es' => 'ALIMENTADOR', 'pt' => 'ALIMENTADOR']);
        Failure::create(['name' => 'HIGH ROOM TEMPERATURE', 'es' => 'ALTA TEMPERATURA AMBIENTE', 'pt' => 'ALTA TEMPERATURA AMBIENTE']);
        Failure::create(['name' => 'BARRA DE SELAGEM', 'es' => 'BARRA DE SELAGEM', 'pt' => 'BARRA DE SELAGEM']);
        Failure::create(['name' => 'VACUUM PUMP', 'es' => 'BOMBA DE VACÍO', 'pt' => 'BOMBA VACUO']);
        Failure::create(['name' => 'BUTTON', 'es' => 'BOTÓN', 'pt' => 'BOTAO']);
        Failure::create(['name' => 'EMERGENCY BUTTON', 'es' => 'BOTÓN DE EMERGENCIA', 'pt' => 'BOTAO EMERGENCIA']);
        Failure::create(['name' => 'SEALING HEAD', 'es' => 'CABEZA DE SELLADO', 'pt' => 'CABECA DE SELAGEM']);
        Failure::create(['name' => 'DAMAGED CABLE', 'es' => 'CABLE DAÑADO', 'pt' => 'CABO DANIFICADO']);
        Failure::create(['name' => 'CAMERA', 'es' => 'CÁMARA', 'pt' => 'CAMERA']);
        Failure::create(['name' => 'OPERATIONAL TRAINING', 'es' => 'ENTRENAMIENTO  OPERATIVA', 'pt' => 'CAPACITACAO OPERACIONAL']);
        Failure::create(['name' => 'TECHNICAL TRAINING', 'es' => 'ENTRENAMIENTO TÉCNICO', 'pt' => 'CAPACITACAO TECNICA']);
        Failure::create(['name' => 'PLC', 'es' => 'PLC', 'pt' => 'CLP']);
        Failure::create(['name' => 'COMPASS VMS', 'es' => 'COMPASS VMS', 'pt' => 'COMPASS VMS']);
        Failure::create(['name' => 'AIR COMPRESSOR', 'es' => 'COMPRESOR DE AIRE', 'pt' => 'COMPRESSOR DE AR']);
        Failure::create(['name' => 'CONFIGURATION', 'es' => 'CONFIGURACIÓN', 'pt' => 'CONFIGURACAO']);
        Failure::create(['name' => 'CONTACTOR', 'es' => 'CONTACTOR', 'pt' => 'CONTATOR']);
        Failure::create(['name' => 'ACCESS CONTROL', 'es' => 'CONTROL DE ACCESO', 'pt' => 'CONTROLE DE ACESSO']);
        Failure::create(['name' => 'BELT', 'es' => 'BANDA', 'pt' => 'CORREIA']);
        Failure::create(['name' => 'ELETRONIC FAILURE', 'es' => 'FALLO ELECTRÓNICO', 'pt' => 'DEFEITO ELETRONICO']);
        Failure::create(['name' => 'MECHANICAL WEAR', 'es' => 'DESGASTE MECÁNICO', 'pt' => 'DESGASTE MECANICO']);
        Failure::create(['name' => 'DESKTOP', 'es' => 'MESA', 'pt' => 'DESKTOP']);
        Failure::create(['name' => 'SOLENOID', 'es' => 'SOLENOIDE', 'pt' => 'DESVIADOR MECANICO']);
        Failure::create(['name' => 'CIRCUIT BREAKER', 'es' => 'BRAKER', 'pt' => 'DISJUNTOR']);
        Failure::create(['name' => 'THOOTHED GEAR', 'es' => 'ENGRANAJE DENTADO', 'pt' => 'ENGRENAGEM']);
        Failure::create(['name' => 'CLOGGING', 'es' => 'CLOCADO', 'pt' => 'ENTUPIMENTO']);
        Failure::create(['name' => 'STABILIZER', 'es' => 'ESTABILIZADOR', 'pt' => 'ESTABILIZADOR']);
        Failure::create(['name' => 'CONVEYOR', 'es' => 'CONVEYOR', 'pt' => 'ESTEIRA']);
        Failure::create(['name' => 'NETWORK FAILURE', 'es' => 'FALLO DE RED', 'pt' => 'FALHA DE REDE']);
        Failure::create(['name' => 'COMPACTION FAILURE', 'es' => 'FALLO DE COMPACTACIÓN', 'pt' => 'FALHA NA COMPACTACAO']);
        Failure::create(['name' => 'OPERATIONAL ERROR', 'es' => 'ERROR OPERATIVO', 'pt' => 'FALHA OPERACIONAL']);
        Failure::create(['name' => 'LACK OF LUBRICATION', 'es' => 'FALTA DE LUBRICACIÓN', 'pt' => 'FALTA DE LUBRIFICACAO']);
        Failure::create(['name' => 'FILTER', 'es' => 'FILTRO', 'pt' => 'FILTRO']);
        Failure::create(['name' => 'POWER SUPPLY', 'es' => 'FUENTE DE ALIMENTACIÓN', 'pt' => 'FONTE DE ALIMENTACAO']);
        Failure::create(['name' => 'FUSE', 'es' => 'FUSIBLE', 'pt' => 'FUSIVEL']);
        Failure::create(['name' => 'PRINTER', 'es' => 'IMPRESORA', 'pt' => 'IMPRESSORA']);
        Failure::create(['name' => 'CUTTING BLADE', 'es' => 'CUCHILLA DE CORTE', 'pt' => 'LAMINA DE CORTE']);
        Failure::create(['name' => 'INTERNET LINK', 'es' => 'ENLACE INTERNET', 'pt' => 'LINK DE INTERNET']);
        Failure::create(['name' => 'HOSE', 'es' => 'MANGUERA', 'pt' => 'MANGUEIRA']);
        Failure::create(['name' => 'MANOMETER', 'es' => 'MANÓMETRO', 'pt' => 'MANOMETRO']);
        Failure::create(['name' => 'BAD CONTACT', 'es' => 'CONTACTO DEFECTUOSO', 'pt' => 'MAU CONTATO']);
        Failure::create(['name' => 'MICRO SWITCH', 'es' => 'MICRO INTERRUPTOR', 'pt' => 'MICRO-CHAVE']);
        Failure::create(['name' => 'FOREIGN CURRENCY', 'es' => 'MONEDA EXTRANJERA', 'pt' => 'MOEDA ESTRANGEIRA']);
        Failure::create(['name' => 'MOTOR', 'es' => 'MOTOR', 'pt' => 'MOTOR']);
        Failure::create(['name' => 'MOUSE', 'es' => 'RATON', 'pt' => 'MOUSE']);
        Failure::create(['name' => 'NOBREAK', 'es' => 'NOBREAK', 'pt' => 'NOBREAK']);
        Failure::create(['name' => 'NVR', 'es' => 'NVR', 'pt' => 'NVR']);
        Failure::create(['name' => 'ORING', 'es' => 'ORING', 'pt' => 'ORING']);
        Failure::create(['name' => 'RAS', 'es' => 'RAS', 'pt' => 'RAS']);
        Failure::create(['name' => 'RELE', 'es' => 'RELE', 'pt' => 'RELE']);
        Failure::create(['name' => 'RESISTANCE', 'es' => 'RESISTENCIA', 'pt' => 'RESISTENCIA']);
        Failure::create(['name' => 'RETEINER', 'es' => 'RETEINER', 'pt' => 'RETENTOR']);
        Failure::create(['name' => 'BALL BARING', 'es' => 'BALEROS', 'pt' => 'ROLAMENTO']);
        Failure::create(['name' => 'LVM DRYER', 'es' => 'LVM SECADOR', 'pt' => 'SECADOR LVM']);
        Failure::create(['name' => 'ASYNCRONOUS', 'es' => 'ASÍNCRONO', 'pt' => 'SEM SINCRONISMO']);
        Failure::create(['name' => 'SENSOR', 'es' => 'SENSOR', 'pt' => 'SENSOR']);
        Failure::create(['name' => 'COMPASS SERVER', 'es' => 'SERVIDOR DE BRÚJULA', 'pt' => 'SERVIDOR DO COMPASS']);
        Failure::create(['name' => 'BPS SOFTWARE', 'es' => 'SOFTWARE BPS', 'pt' => 'SOFTWARE BPS']);
        Failure::create(['name' => 'BROKEN COVER', 'es' => 'CUBIERTA ROTA', 'pt' => 'TAMPA QUEBRADA']);
        Failure::create(['name' => 'KEYBOARD', 'es' => 'TECLADO', 'pt' => 'TECLADO']);
        Failure::create(['name' => 'TEFLON', 'es' => 'TEFLÓN', 'pt' => 'TEFLON']);
        Failure::create(['name' => 'CONTRACT TERMINATION', 'es' => 'RESCISIÓN DE CONTRATO', 'pt' => 'TERMINO DE CONTRATO']);
        Failure::create(['name' => 'TRANSFER', 'es' => 'TRANSFERENCIA', 'pt' => 'TRANSFERENCIA']);
        Failure::create(['name' => 'VALVE', 'es' => 'VÁLVULA', 'pt' => 'VALVULA']);
        Failure::create(['name' => 'PREVENTIVE', 'es' => 'PREVENTIVO', 'pt' => 'PREVENTIVA']);
        Failure::create(['name' => 'UNPRODUCTIVE', 'es' => 'NO PRODUCTIVO', 'pt' => 'IMPRODUTIVA']);
        Failure::create(['name' => 'TRAINING', 'es' => 'ENTRENAMIENTO', 'pt' => 'TREINAMENTO']);
        Failure::create(['name' => 'INSTALLATION', 'es' => 'INSTALACIÓN', 'pt' => 'INSTALAÇÃO']);
    }
}
