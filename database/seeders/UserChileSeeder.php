<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserChileSeeder extends Seeder
{
    private $country_id = 3;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'emp' => null,
            'email' => "frankie.segura@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Frankie",
            'apellido_paterno' => "Andres",
            'apellido_materno' => "Segura",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => null,
            'email' => "adrianmiguel.vegatoledo@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Adrian",
            'apellido_paterno' => "Vega",
            'apellido_materno' => "Toledo",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => null,
            'email' => "eduardoivan.godoyfernandez@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Eduardo",
            'apellido_paterno' => "Ivan",
            'apellido_materno' => "Godoy",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => null,
            'email' => "mario.sotolongo@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Mario",
            'apellido_paterno' => "Miguel",
            'apellido_materno' => "Sotolongo",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => null,
            'email' => "sergio.monteroosorio@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Sergio",
            'apellido_paterno' => "Montero",
            'apellido_materno' => "Osorio",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => null,
            'email' => "daniloandres.armengolbaeza@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Danilo",
            'apellido_paterno' => "Andres",
            'apellido_materno' => "Armengol",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => null,
            'email' => "enzoemilio.fuentescastro@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Enzo",
            'apellido_paterno' => "Emilio",
            'apellido_materno' => "Fuentes",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => null,
            'email' => "alisonmichelle.leonleon@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Alison",
            'apellido_paterno' => "Michelle",
            'apellido_materno' => "León",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => null,
            'email' => "tulio.brillay@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Tulio",
            'apellido_paterno' => "Brillay",
            'apellido_materno' => "Navarro",
            'user_type_id' => 2,
            'user_title_id' => 5,
            'country_id' => $this->country_id,
        ]);

    }
}
