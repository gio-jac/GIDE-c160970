<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Branch::create([
            'address' => 'Av. Circumvalacion agustin yañes 440 col, Rincon de Agua Azul cp. 44467', 
            'city_id' => '1', 
            'branch_manager_id' => '1', 
            'client_id' => '1',
        ]);
        Branch::create([
            'address' => 'Andres de Urdaneta #35 Colonia: Fraccionamiento hornos C.P 39355', 
            'city_id' => '2', 
            'branch_manager_id' => '2', 
            'client_id' => '4',
        ]);
        Branch::create([
            'address' => 'Prolongación Sabino No. 526, Col. Ampliación del Gas, C.P.02830, Alc. Azcapotzalco, México, CDMX.', 
            'city_id' => '3', 
            'branch_manager_id' => '3', 
            'client_id' => '5',
        ]);
        Branch::create([
            'address' => 'Rio Nilo 445 Entre Gladiola Y Perez Verdia  col. San Carlos 44860 Guadalajara, Jal', 
            'city_id' => '1', 
            'branch_manager_id' => '4', 
            'client_id' => '6',
        ]);
        Branch::create([
            'address' => 'DR. BARRAGAN No. 154 COL. DOCTORES, C.P. 06720, DEL. CUAUHTEMOC, CDMX.', 
            'city_id' => '5', 
            'branch_manager_id' => '5', 
            'client_id' => '7',
        ]);
        Branch::create([
            'address' => 'Dr. Navarro # 25, Col. Doctores, C.P.06720, Delegación Cuauhtémoc, CDMX.', 
            'city_id' => '5', 
            'branch_manager_id' => '6', 
            'client_id' => '11',
        ]);
        Branch::create([
            'address' => 'ARENAL #41 COL. ESPERANZA, ALCALDÍA CUAUHTEMOC', 
            'city_id' => '5', 
            'branch_manager_id' => '7', 
            'client_id' => '12',
        ]);
        Branch::create([
            'address' => 'Calle Centeno 90, Col. Granjas Esmeralda, C.P. 09810 CDMX. Alcaldía Iztapalapa', 
            'city_id' => '7', 
            'branch_manager_id' => '8', 
            'client_id' => '10',
        ]);
        Branch::create([
            'address' => 'Centeno 377C, Granjas México, Iztacalco, 08400 Ciudad de México, CDMX', 
            'city_id' => '8', 
            'branch_manager_id' => '9', 
            'client_id' => '9',
        ]);
    }
}
