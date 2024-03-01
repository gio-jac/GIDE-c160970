<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //ADMIN
        User::create([
            'emp' => "admin",
            'email' => "admin@admin.com",
            'password' => Hash::make("111"),
            'nombre' => "admin",
            'apellido_paterno' => "admin",
            'apellido_materno' => "admin",
            'user_type_id' => 1,
            'user_title_id' => 1,
            'country_id' => 2,
        ]);
    }
}
