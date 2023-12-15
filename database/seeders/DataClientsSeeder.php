<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DataClients;

class DataClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DataClients::create(['client_id' => 1]);
        DataClients::create(['client_id' => 2]);
        DataClients::create(['client_id' => 3]);
        DataClients::create(['client_id' => 4]);
        DataClients::create(['client_id' => 5]);
        DataClients::create(['client_id' => 6]);
        DataClients::create(['client_id' => 7]);
        DataClients::create(['client_id' => 8]);
        DataClients::create(['client_id' => 9]);
        DataClients::create(['client_id' => 10]);
    }
}
