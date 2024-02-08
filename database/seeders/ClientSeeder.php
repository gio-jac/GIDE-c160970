<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Mexico
        Client::create(['name' => "ARMSTRONG"]);
        Client::create(['name' => "BANAMEX"]);
        Client::create(['name' => "BANXICO", 'multiple' => true]);
        Client::create(['name' => "COMETRA"]);
        Client::create(['name' => "GRUMER"]);
        Client::create(['name' => "SEGURITEC"]);
        Client::create(['name' => "SEPSA"]);
        Client::create(['name' => "SERPAPROSA"]);
        Client::create(['name' => "T. LOCK"]);
        Client::create(['name' => "TECNOVAL"]);
        Client::create(['name' => "PANAMERICANO"]);
        Client::create(['name' => "TAMEME"]);
    }
}
