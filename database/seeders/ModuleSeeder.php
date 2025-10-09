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
        Module::create(['name' => 'PRODUCTION MONITORING', 'es' => 'CONTROL DE LA PRODUCCIÓN', 'pt' => 'ACOMPANHAMENTO DE PRODUCAO']);
        Module::create(['name' => 'SORTING ADJUSTMENT', 'es' => 'AJUSTE DE LA CLASIFICACIÓN', 'pt' => 'AJUSTES DE QUALIDADE']);
        Module::create(['name' => 'EXCESSIVE NOISE', 'es' => 'RUIDO EXCESIVO', 'pt' => 'BARULHO EXCESSIVO']);
        Module::create(['name' => 'BATTERY DISCHARGED', 'es' => 'BATERÍA DESCARGADA', 'pt' => 'BATERIA DESCARREGADA']);
        Module::create(['name' => 'UNINSTALLATION', 'es' => 'DESINSTALACIÓN', 'pt' => 'DESINSTALACAO']);
        Module::create(['name' => 'SHUTTING DOWN', 'es' => 'APAGADO', 'pt' => 'DESLIGANDO']);
        Module::create(['name' => 'JAM', 'es' => 'ATASCO', 'pt' => 'ENROSCO']);
        Module::create(['name' => 'SYSTEM DOES NOT SWITCH ON', 'es' => 'EL SISTEMA NO SE ENCIENDE', 'pt' => 'EQUIPAMENTO NAO LIGA']);
        Module::create(['name' => 'PHOTODETECTOR ERROR', 'es' => 'ERROR FOTODETECTOR', 'pt' => 'ERRO DE PHOTODETECTOR']);
        Module::create(['name' => 'SENSOR ERROR ', 'es' => 'ERROR DEL SENSOR ', 'pt' => 'ERRO DE SENSOR']);
        Module::create(['name' => 'OIL FILTER CLOGGED', 'es' => 'FILTRO DE ACEITE OBSTRUIDO', 'pt' => 'ERRO FILTRO OLEO']);
        Module::create(['name' => 'ERROR CODE U1U', 'es' => 'CODIGO ERROR U1U', 'pt' => 'ERRO U1U']);
        Module::create(['name' => 'ERROR CODE U2U', 'es' => 'CODIGO ERROR U2U', 'pt' => 'ERRO U2U']);
        Module::create(['name' => 'HICH REJECT RATE', 'es' => 'ALTO RECHAZO', 'pt' => 'EXCESSO DE REJEITO']);
        Module::create(['name' => 'FEEDER START ERROR', 'es' => 'ERROR DE INICIO DEL ALIMENTADOR', 'pt' => 'FALHA ACIONAMENTO ALIMENTADOR']);
        Module::create(['name' => 'TRANSPORT START ERROR', 'es' => 'ERROR DE INICIO DEL TRANSPORTE', 'pt' => 'FALHA ACIONAMENTO TRANSPORTE']);
        Module::create(['name' => 'POWER SUPPLY FAILURE', 'es' => 'ERROR DE ALIMENTACIÓN', 'pt' => 'FALHA ALIMENTACAO ELETRICA']);
        Module::create(['name' => 'CCTV ERROR', 'es' => 'CCTV ERROR', 'pt' => 'FALHA DE CFTV']);
        Module::create(['name' => 'BANDING SYSTEM FAILING', 'es' => 'FALLO DEL SISTEMA DE BANDAS', 'pt' => 'FALHA DE CINTAGEM']);
        Module::create(['name' => 'COMMUNICATION ERROR', 'es' => 'ERROR DE COMUNICACIÓN', 'pt' => 'FALHA DE COMUNICAÇÃO']);
        Module::create(['name' => 'PERIPHERAL FAILURE', 'es' => 'FALLO DE PERIFÉRICOS', 'pt' => 'FALHA DE PERIFERICOS']);
        Module::create(['name' => 'SOFTWARE FAILURE', 'es' => 'FALLO DE SOFTWARE', 'pt' => 'FALHA DE SOFTWARE']);
        Module::create(['name' => 'TRANSPORT ERROR', 'es' => 'ERROR DE TRANSPORTE', 'pt' => 'FALHA DE TRANSPORTE']);
        Module::create(['name' => 'LOADING CONVEYOR ERROR', 'es' => 'ERROR DE LA CINTA DE CARGA', 'pt' => 'FALHA ESTEIRA CARREGAMENTO']);
        Module::create(['name' => 'MECHNICAL FAILURE', 'es' => 'FALLO MECANICA', 'pt' => 'FALHA MECANICA']);
        Module::create(['name' => 'FEEDER FAILURE', 'es' => 'FALLO DEL ALIMENTADOR', 'pt' => 'FALHA NA ALIMENTACAO']);
        Module::create(['name' => 'BROKEN BELT', 'es' => 'BANDA ROTA', 'pt' => 'BANDA ROTA']);
        Module::create(['name' => 'SHREDDER FAILURE', 'es' => 'FALLO DE DESTRUCTOR', 'pt' => 'FALHA NO DESTRUIDOR']);
        Module::create(['name' => 'STACKER ERROR', 'es' => 'ERROR DEL STACKER', 'pt' => 'FALHA NO STACKER']);
        Module::create(['name' => 'BUNDLER SYSTEM FAILURE', 'es' => 'FALLO DE BUNDLER', 'pt' => 'FALHA NO BUNDLER']);
        Module::create(['name' => 'GRANULATOR ERROR', 'es' => 'ERROR DEL GRANULADOR', 'pt' => 'FALHA NO GRANULADOR']);
        Module::create(['name' => 'MONITOR FAILURE', 'es' => 'FALLO DEL MONITOR', 'pt' => 'FALHA NO MONITOR']);
        Module::create(['name' => 'SERVER ERROR', 'es' => 'ERROR DEL SERVIDOR', 'pt' => 'FALHA NO SERVIDOR']);
        Module::create(['name' => 'VACUUM SYSTEM FAILURE', 'es' => 'FALLO DEL SISTEMA DE VACÍO', 'pt' => 'FALHA NO VÁCUO']);
        Module::create(['name' => 'CONTROL PAINEL ERROR', 'es' => 'ERROR DEL PAINEL DE CONTROL', 'pt' => 'FALHA PAINEL DE COMANDO']);
        Module::create(['name' => 'STRAP DOES NOT CUT', 'es' => 'LA CORREA NO CORTA', 'pt' => 'FITA NAO CORTA']);
        Module::create(['name' => 'INSTALLATION', 'es' => 'INSTALACIÓN', 'pt' => 'INSTALACAO']);
        Module::create(['name' => 'PREVENTIVE MAINTENANCE', 'es' => 'MANTENIMIENTO PREVENTIVO', 'pt' => 'PREVENTIVA']);
        Module::create(['name' => 'OPEN COVER ERROR', 'es' => 'ERROR TAPA ABIERTA', 'pt' => 'TAMPA ABERTA']);
        Module::create(['name' => 'HIGH OIL TEMP. ', 'es' => 'ALTA TEMPERATURA DEL ACEITE ', 'pt' => 'TEMPERATURA ALTA OLEO']);
        Module::create(['name' => 'OPERATING TRAINING', 'es' => 'FORMACIÓN OPERATIVA', 'pt' => 'TREINAMENTO']);
        Module::create(['name' => 'AIR LEAKAGE', 'es' => 'FUGAS DE AIRE', 'pt' => 'VAZAMENTO DE AR']);
        Module::create(['name' => 'OIL LEAKAGE', 'es' => 'FUGAS DE ACEITE', 'pt' => 'VAZAMENTO DE OLEO']);
    }
}
