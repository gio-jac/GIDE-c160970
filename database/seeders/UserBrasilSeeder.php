<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserBrasilSeeder extends Seeder
{
    private $country_id = 1;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'emp' => "3379",
            'email' => "bruno.gomes@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Bruno",
            'apellido_paterno' => "Lorena",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 10,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3996",
            'email' => "ricardo.costa@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Ricardo",
            'apellido_paterno' => "Costa",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "4029",
            'email' => "teogenes.lima@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Teogenes",
            'apellido_paterno' => "Lima",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3900",
            'email' => "josias.campgnoli@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Josias",
            'apellido_paterno' => "Campgnoli",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3955",
            'email' => "leonardo.silva@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Leonardo",
            'apellido_paterno' => "Silva",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3457",
            'email' => "dalmer.vieira@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Dalmer",
            'apellido_paterno' => "Vieira",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3461",
            'email' => "andre.alves@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "André",
            'apellido_paterno' => "Alves",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3428",
            'email' => "marcelo.serres@gi-de.com ",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Marcelo",
            'apellido_paterno' => "Serres",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3824",
            'email' => "marcus.oliveira@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Marcus",
            'apellido_paterno' => "Oliveira",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3763",
            'email' => "luiz.godoy@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Luiz",
            'apellido_paterno' => "Godoy",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3821",
            'email' => "edinelson.cunha@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Edinelson",
            'apellido_paterno' => "Cunha",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "4078",
            'email' => "raphael.modanez@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Raphael",
            'apellido_paterno' => "Modanez",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3972",
            'email' => "joao.junior@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "João",
            'apellido_paterno' => "Júnior",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3904",
            'email' => "jeferson.santos@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Jeferson",
            'apellido_paterno' => "Santos",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "4017",
            'email' => "alexandre.silva@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Alexandre",
            'apellido_paterno' => "Silva",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3626",
            'email' => "marcos.martins@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Marcos",
            'apellido_paterno' => "Martins",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3691",
            'email' => "felipe.braga@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Felipe",
            'apellido_paterno' => "Braga",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3898",
            'email' => "gelson.santana@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Gelson",
            'apellido_paterno' => "Santana",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3568",
            'email' => "cassio.frota@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Cássio",
            'apellido_paterno' => "dos Anjos Frota",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "4073",
            'email' => "adriano.lima@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Adriano",
            'apellido_paterno' => "Lima",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3797",
            'email' => "thales.goncalves@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Thales",
            'apellido_paterno' => "Silva",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3535",
            'email' => "fabiano.santos@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Fabiano",
            'apellido_paterno' => "Santos",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3552",
            'email' => "elton.pereira@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Elton",
            'apellido_paterno' => "Pereira",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3594",
            'email' => "felipe.rossetto@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Felipe",
            'apellido_paterno' => "Rossetto",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3460",
            'email' => "aidan.brito@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Aidan",
            'apellido_paterno' => "Brito",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3713",
            'email' => "amauri.silva@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Amauri",
            'apellido_paterno' => "Silva",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3382",
            'email' => "dhiogo.silva@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Dhiogo",
            'apellido_paterno' => "Silva",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3554",
            'email' => "breno.silva@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Breno",
            'apellido_paterno' => "Silva",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3556",
            'email' => "eliton.santos@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Eliton",
            'apellido_paterno' => "Santos",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3881",
            'email' => "jose.teixeira@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "José",
            'apellido_paterno' => "Teixeira",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3553",
            'email' => "edinor.junior@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Edinor",
            'apellido_paterno' => "Junior",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3989",
            'email' => "tiago.silva@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Tiago",
            'apellido_paterno' => "Filipe da Silva",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "4016",
            'email' => "anderson.martins@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Anderson",
            'apellido_paterno' => "Martins",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3935",
            'email' => "sergio.dasilva@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Sérgio",
            'apellido_paterno' => "da Silva",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "4038",
            'email' => "armando.lima@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Armando",
            'apellido_paterno' => "Lima",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "4059",
            'email' => "paulo.barros@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Paulo",
            'apellido_paterno' => "Barros",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3778",
            'email' => "nilson.lima@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Nilson",
            'apellido_paterno' => "Lima",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3901",
            'email' => "lincoln.delima@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Lincoln",
            'apellido_paterno' => "de Lima",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3323",
            'email' => "diego.silva@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Diego",
            'apellido_paterno' => "Silva",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3313",
            'email' => "daniel.marinho@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Daniel",
            'apellido_paterno' => "Marinho",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3822",
            'email' => "wallace.barbosa@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Wallace",
            'apellido_paterno' => "Barbosa",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 10,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3199",
            'email' => "alexandre.nascimento@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Alexandre",
            'apellido_paterno' => "Nascimento",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 10,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3003",
            'email' => "fabio.decker@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Fabio",
            'apellido_paterno' => "Decker",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 10,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3016",
            'email' => "antonio.sumida@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Antonio",
            'apellido_paterno' => "Sumida",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 10,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3732",
            'email' => "flavio.ramos@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Flávio",
            'apellido_paterno' => "Ramos",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 10,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3254",
            'email' => "milton.mello@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Milton",
            'apellido_paterno' => "Mello",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 10,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "2039",
            'email' => "carlos.torres@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Carlos",
            'apellido_paterno' => "Torres",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 4,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "3873",
            'email' => "leandro.sanchez@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Leandro",
            'apellido_paterno' => "Sanchez",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 9,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "4048",
            'email' => "rafael.vianna@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Rafael",
            'apellido_paterno' => "Vianna",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 9,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "4006",
            'email' => "grabriel.belizario@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Gabriel",
            'apellido_paterno' => "Belizario",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "4062",
            'email' => "andre.silva@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Andre",
            'apellido_paterno' => "Silva",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "4070",
            'email' => "fabio.dasilva@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Fabio",
            'apellido_paterno' => "da Silva",
            'apellido_materno' => NULL,
            'user_type_id' => 2,
            'user_title_id' => 3,
            'country_id' => $this->country_id,
        ]);
    }
}
