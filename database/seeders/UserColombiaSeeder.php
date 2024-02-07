<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserColombiaSeeder extends Seeder
{
    private $country_id = 4;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'emp' => "E03917",
            'email' => "camilo.montana@gi-de.com",
            'password' => Hash::make("111"),
            'nombre' =>  "Camilo",
            'apellido_paterno' => "Montaña",
            'apellido_materno' => "Hoyos",
            'telefono' => "3133467288",
            'user_type_id' => 2,
            'user_title_id' => 8,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "E03919",
            'email' => "oscar.cabrera@gi-de.com",
            'password' => Hash::make("111"),
            'nombre' =>  "Oscar Andres",
            'apellido_paterno' => "Cabrera",
            'apellido_materno' => "Escobar",
            'telefono' => "3133403251",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "E03918",
            'email' => "david.castro@gi-de.com",
            'password' => Hash::make("111"),
            'nombre' =>  "David Leonardo",
            'apellido_paterno' => "Castro",
            'apellido_materno' => "Manso",
            'telefono' => "3133408310",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);

    }
}
