<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class costCentersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cost_centers')->insert([
            ['cc' => "411201", 'name' => "BNCS Managing Director"],
            ['cc' => "411203", 'name' => "BNCS Finance"],
            ['cc' => "411204", 'name' => "BNCS Controlling"],
            ['cc' => "411205", 'name' => "BNCS Legal"],
            ['cc' => "411206", 'name' => "BNCS Human Resources"],
            ['cc' => "411207", 'name' => "BNCS General IT"],
            ['cc' => "411208", 'name' => "BNCS Real Estate"],
            ['cc' => "411228", 'name' => "BNCS Colombia"],
            ['cc' => "411229", 'name' => "BNCS Chile"],
            ['cc' => "411101", 'name' => "BNCS Sales Manager 1"],
            ['cc' => "411102", 'name' => "BNCS Sales manager 2"],
            ['cc' => "411103", 'name' => "BNCS Sales BackOffice"],
            ['cc' => "411108", 'name' => "BNCS Management"],
            ['cc' => "411109", 'name' => "BNCS Management"],
            ['cc' => "411110", 'name' => "BNCS Management"],
            ['cc' => "415000", 'name' => "BNCS General Operative Director"],
            ['cc' => "415001", 'name' => "BNCS Banxico"],
            ['cc' => "415002", 'name' => "BNCS Banamex"],
            ['cc' => "415003", 'name' => "BNCS  Brinks Panamericano"],
            ['cc' => "415004", 'name' => "BNCS Prosegur"],
            ['cc' => "415005", 'name' => "BNCS Gidemex (Tlalne)"],
            ['cc' => "415006", 'name' => "BNCS Jamaica"],
            ['cc' => "415007", 'name' => "BNCS Commercial Bank Manager"],
            ['cc' => "415008", 'name' => "BNCS Bolivia (adaptation)"],
            ['cc' => "415009", 'name' => "BNCS Trinidad y Tobago"],
            ['cc' => "415010", 'name' => "BNCS Aruba"],
            ['cc' => "415011", 'name' => "BNCS Barbados"],
            ['cc' => "415012", 'name' => "BNCS Curacao"],
            ['cc' => "415013", 'name' => "BNCS Guyana"],
            ['cc' => "415014", 'name' => "BNCS Peru"],
            ['cc' => "415015 CC", 'name' => "Venta de Refacciones CC"],
            ['cc' => "415015 CB", 'name' => "Venta de Refacciones CB"],
            ['cc' => "415016 CC", 'name' => "Entrenamientos CC"],
            ['cc' => "415016 CB", 'name' => "Entrenamientos CB"],
            ['cc' => "415017 CC", 'name' => "Adaptaciones CC"],
            ['cc' => "415017 CB", 'name' => "Adaptaciones CB"],
            ['cc' => "415018 CC", 'name' => "Leasing Equipo contadores M5 CC"],
            ['cc' => "415018 CB", 'name' => "Leasing Equipo contadores M5 CB"],
            ['cc' => "415019 CC", 'name' => "Reparaciones Dealers  CC"],
            ['cc' => "415019 CB", 'name' => "Reparaciones Dealers  CB"],
            ['cc' => "415020", 'name' => "BNCS Venta  M7 Perú"],
            ['cc' => "415021", 'name' => "BNCS SIESA_ Panama_BPS1000_2013_01"],
            ['cc' => "415022", 'name' => "Venta equipos BDS CB"],
            ['cc' => "415027 PNCC", 'name' => "Venta de equipos  Pronote CC"],
            ['cc' => "415027 PNCB", 'name' => "Venta de equipos  Pronote CB"],
            ['cc' => "415027 C4CC", 'name' => "Venta de equipos C4 CC"],
            ['cc' => "415027 C4CB", 'name' => "Venta de equipos C4 CB"],
            ['cc' => "415027 C2CC", 'name' => "Venta de equipos C2 CC"],
            ['cc' => "415027 C2CB", 'name' => "Venta de equipos C2 CB"],
            ['cc' => "415027 C1CC", 'name' => "Venta de equipos C1 CC"],
            ['cc' => "415027 C1CB", 'name' => "Venta de equipos C1 CB"],
            ['cc' => "415027 OS CC", 'name' => "Venta de equipos Other Segment CC"],
            ['cc' => "415027 OS CB", 'name' => "Venta de equipos Other Segment CB"],
            ['cc' => "415027 C5 CC", 'name' => "Venta de equipos C5 CC"],
            ['cc' => "415027 C5 CB", 'name' => "Venta de equipos C5 CB"],
            ['cc' => "415028", 'name' => "BNCS Banco Central de Nicaragua  C5"],
            ['cc' => "415030", 'name' => "Logistic, Warehousing, Purchasing and Backoffice"],
            ['cc' => "415031", 'name' => "Techn. Support/Project Management CC"],
            ['cc' => "415031", 'name' => "Techn. Support/Project Management CB"],
            ['cc' => "415032", 'name' => "BNCS Banjercito"],
            ['cc' => "415033 CC", 'name' => "GDMex_Soporte_Tecnico_LATAM_Refurbish_Overhaul"],
            ['cc' => "415034 CB", 'name' => "GDMex_Soporte_Tecnico_LATAM_Asistencia_Tecnica"],
            ['cc' => "415038", 'name' => "BNCS Venta de BPS X9"],
            ['cc' => "415039 CB", 'name' => "BNCS Software sell CB"],
            ['cc' => "415039 CC", 'name' => "BNCS Software sell CC"],
            ['cc' => "415040", 'name' => "Mantenimiento Banca Comercial (SEPSA)"],
            ['cc' => "415041", 'name' => "Mantenimiento Banca Comercial (SEGURITEC)"],
            ['cc' => "415042", 'name' => "Mantenimiento Banca Comercial (Cometra)"],
            ['cc' => "415043", 'name' => "Mantenimiento Banca Comercial (Armstrong)"],
            ['cc' => "415044", 'name' => "BNCS  BPS X9 Banco de Mexico Fabrica"],
            ['cc' => "415045", 'name' => "BNCS Mantenimiento VMS Software Jamaica and T&T"],
            ['cc' => "415046", 'name' => "BNCS Mantenimiento transportes Lock"],
            ['cc' => "415047", 'name' => "BNCS instalacion en TYT del hardware (GDAM)"],
            ['cc' => "415048", 'name' => "BNCS Branch Colombia"],
            ['cc' => "415049", 'name' => "Venta de equipos C5"],
            ['cc' => "415050", 'name' => "Bonded Warehouse CC"],
            ['cc' => "415050", 'name' => "Bonded Warehouse CB"],
            ['cc' => "415051", 'name' => "GSI venta equipos BPS C5"],
            ['cc' => "415052", 'name' => "Mantenimiento Banca Comercial (Grumer)"],
            ['cc' => "415053", 'name' => "Mantenimiento Banca Comercial (Tecnoval)"],
            ['cc' => "415054", 'name' => "Proyecto Trinidad y Tobago BPS M7, Notapack and Notatrack"],
            ['cc' => "415055", 'name' => "GSI venta equipos Pronotes"],
            ['cc' => "415056", 'name' => "Proyecto Beryllium BPS M5, Notapack and Notatrack"],
            ['cc' => "415057", 'name' => "BNCS Branch Chile"],
            ['cc' => "415058", 'name' => "Intelident venta equipos Pronote"],
            ['cc' => "415059", 'name' => "Instalación de equipos BPS C2 a BBVA BANCOMER"],
            ['cc' => "415060", 'name' => "Mantenimiento equipos BPS C2 BBVA BANCOMER"],
            ['cc' => "415061", 'name' => "Desinstalación e Instalación de MS con Grupo GSI M7"],
            ['cc' => "415062", 'name' => "Brinks Colombia"],
            ['cc' => "415063", 'name' => "Proyecto venta M7 Barbados"],
            ['cc' => "415064", 'name' => "Ventas de equipos CSS a Curacao"],
            ['cc' => "415065", 'name' => "Mantenimiento Banca Comercial (TAMEME)"],
            ['cc' => "415066", 'name' => "Mantenimiento Banca Comercial (REGIO TRASLADOS)"],
            ['cc' => "415067", 'name' => "Mantenimiento Banca Comercial SISSA"],
            ['cc' => "415068", 'name' => "Instalación Suriname M7 (proyecto GD Latam)"]

        ]);
    }
}
