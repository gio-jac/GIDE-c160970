<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserJamaicaSeeder extends Seeder
{
    private $country_id = 5;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'emp' => "E03920",
            'email' => "garnetantonio.bailey@gi-de.com",
            'password' => Hash::make("111"),
            'nombre' =>  "Antonio",
            'apellido_paterno' => "Bailey",
            'apellido_materno' => "Garnet",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "E03674",
            'email' => "albert.thompson@gi-de.com",
            'password' => Hash::make("111"),
            'nombre' =>  "Albert",
            'apellido_paterno' => "Thompson",
            'apellido_materno' => null,
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);

    }
}
