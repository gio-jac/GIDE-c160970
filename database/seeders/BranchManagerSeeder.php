<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BranchManager;

class BranchManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BranchManager::create(['name' => 'NOE SANDOVAL', 'email' => 'noesandoval@grupoarmstrong.com', 'phone' => '3328358506']);
        BranchManager::create(['name' => 'RADILLA ZAMORA CRISTINA', 'phone' => '5545244905']);
        BranchManager::create(['name' => 'Beatriz Adriana Bolio Rodriguez', 'email' => 'beatriz.bolio@grumermexico.com', 'phone' => '55 5354 7570']);
        BranchManager::create(['name' => 'JACQUELINE BARAJAS', 'phone' => '331 862 4069']);
        BranchManager::create(['name' => 'Miriam Morales', 'phone' => '51342204 EXT 2256']);
        BranchManager::create(['name' => 'LUIS REY CORNEJO', 'email' => 'luis.cornejo@panamericano.mx', 'phone' => '55 2915 9175']);
        BranchManager::create(['name' => 'JOEL NOGUEZ', 'email' => 'jnoguez@mailtameme.com.mx', 'phone' => '55 2241 0489']);
        BranchManager::create(['name' => 'EDITH MARICELA ALVARADO FLORES', 'email' => 'ealvarado@tecnoval.com.mx', 'phone' => '5544557982']);
        BranchManager::create(['name' => 'YOLANDA VARGAS', 'email' => 'yolanda.vargas@tlock.mx', 'phone' => '55 6914 2924']);
    }
}
