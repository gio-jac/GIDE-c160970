<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserMexicoSeeder extends Seeder
{
    private $country_id = 2;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'emp' => "E03814",
            'email' => "cesaralberto.antoniogomez@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Cesar Alberto",
            'apellido_paterno' => "Antonio",
            'apellido_materno' => "Gómez",
            'telefono' => "55 4449 4655",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "E02768",
            'email' => "miguel.castro@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Miguel",
            'apellido_paterno' => "Castro",
            'apellido_materno' => "Peralta",
            'telefono' => "55 5402 2178",
            'user_type_id' => 2,
            'user_title_id' => 5,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "E04015",
            'email' => "stefhany.estebanraygoza@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Stefhany",
            'apellido_paterno' => "Esteban",
            'apellido_materno' => "Raygoza",
            'telefono' => "56 5113 9800",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "E04020",
            'email' => "estebanfernando.felixanaya@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Esteban Fernando",
            'apellido_paterno' => "Felix",
            'apellido_materno' => "Anaya",
            'telefono' => "55 4370 0853",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "E03735",
            'email' => "misael.galindomora@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Misael",
            'apellido_paterno' => "Galindo",
            'apellido_materno' => "Mora",
            'telefono' => "55 4144 9867",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "E03868",
            'email' => "alexander.galvezcruz@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Alexander",
            'apellido_paterno' => "Galvez",
            'apellido_materno' => "Pérez",
            'telefono' => "56 2559 5739",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "E03812",
            'email' => "jonathan.gutierrezsanchez@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Jonathan",
            'apellido_paterno' => "Gutierrez",
            'apellido_materno' => "Sánchez",
            'telefono' => "55 4449 6132",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "E03811",
            'email' => "rodrigoaurelio.ibarramartinez@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Rodrigo Aurelio",
            'apellido_paterno' => "Ibarra",
            'apellido_materno' => "Martínez",
            'telefono' => "55 4449 7347",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "E03830",
            'email' => "epifanio.jimenezperalta@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Epifanio",
            'apellido_paterno' => "Jimenez",
            'apellido_materno' => "Peralta",
            'telefono' => "55 4523 4278",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "E03869",
            'email' => "eduardo.juarezperez@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Eduardo",
            'apellido_paterno' => "Juárez",
            'apellido_materno' => "Pérez",
            'telefono' => "56 2559 6431",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "E03587",
            'email' => "hector.lugo@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Héctor",
            'apellido_paterno' => "Lugo",
            'apellido_materno' => "Orozco",
            'telefono' => "55 8096 7915",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "E03728",
            'email' => "gamaliel.lunajaimes@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Gamaliel",
            'apellido_paterno' => "Luna",
            'apellido_materno' => "Jaimes",
            'telefono' => "55 3479 2737",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "E03540",
            'email' => "josue.martinez@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Josue",
            'apellido_paterno' => "Martinez",
            'apellido_materno' => "Jiménez",
            'telefono' => "55 7909 6010",
            'user_type_id' => 2,
            'user_title_id' => 8,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "E03825",
            'email' => "victormanuel.mendozaramirez@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Victor Manuel",
            'apellido_paterno' => "Mendoza",
            'apellido_materno' => "Ramírez",
            'telefono' => "56 2558 7144",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "E03888",
            'email' => "christiandavid.palaciosrojas@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Christian David",
            'apellido_paterno' => "Palacios",
            'apellido_materno' => "Rojas",
            'telefono' => "56 2559 6433",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "E03889",
            'email' => "alvaro.perezperez@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Alvaro",
            'apellido_paterno' => "Pérez",
            'apellido_materno' => "Pérez",
            'telefono' => "56 2559 6427",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "E03899",
            'email' => "rafale.portillagonzalez@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Rafael",
            'apellido_paterno' => "Portilla",
            'apellido_materno' => "González",
            'telefono' => "56 2559 6432",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "E04014",
            'email' => "carlosmakley.pulidoruiz@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Carlos Makley",
            'apellido_paterno' => "Pulido",
            'apellido_materno' => "Ruiz",
            'telefono' => "56 5112 8143",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "E03900",
            'email' => "jairomisrraim.reyesmendoza@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Jairo Misrraim",
            'apellido_paterno' => "Reyes",
            'apellido_materno' => "Mendoza",
            'telefono' => "56 2559 6428",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "E03930",
            'email' => "oscaralberto.riosmartinez@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Oscar Alberto",
            'apellido_paterno' => "Rios",
            'apellido_materno' => "Martínez",
            'telefono' => "55 4484 1603",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "E03829",
            'email' => "josue.roblesmonroy@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Josue",
            'apellido_paterno' => "Robles",
            'apellido_materno' => "Monroy",
            'telefono' => "56 1998 8574",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "E03465",
            'email' => "said.salinas@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Said",
            'apellido_paterno' => "Salinas",
            'apellido_materno' => "Chávez",
            'telefono' => "55 4356 5100",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "E03545",
            'email' => "gabriel.santosmartinez@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Gabriel",
            'apellido_paterno' => "Santos",
            'apellido_materno' => "Martinez",
            'telefono' => "55 7909 6011",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "E03733",
            'email' => "marcosjorge.vazquezquiroz@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Marcos Jorge",
            'apellido_paterno' => "Vazquez",
            'apellido_materno' => "Quiroz",
            'telefono' => "55 7928 4899",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "E03606",
            'email' => "victor.velasco@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Victor Hugo",
            'apellido_paterno' => "Velasco",
            'apellido_materno' => "Carrillo",
            'telefono' => "55 8095 0285",
            'user_type_id' => 2,
            'user_title_id' => 8,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => "E03015",
            'email' => "ernesto.zaldivar@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Ernesto",
            'apellido_paterno' => "Zaldivar",
            'apellido_materno' => "Muñoz",
            'telefono' => "55 4554 9345",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => null,
            'email' => "jorge.davila@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "De Leon Jorge Luis",
            'apellido_paterno' => "Davila",
            'apellido_materno' => "Diaz",
            'telefono' => "",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => null,
            'email' => "miguel.morales@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Miguel",
            'apellido_paterno' => "Morales",
            'apellido_materno' => "Galvan",
            'telefono' => "",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => null,
            'email' => "alvaro.cervantes@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Alvaro",
            'apellido_paterno' => "Cervantes",
            'apellido_materno' => "Hidalgo",
            'telefono' => "",
            'user_type_id' => 2,
            'user_title_id' => 7,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => null,
            'email' => "jaime.duarte@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Jaime",
            'apellido_paterno' => "Duarte",
            'apellido_materno' => "Hernandez",
            'telefono' => "",
            'user_type_id' => 2,
            'user_title_id' => 8,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => null,
            'email' => "hector.hernandez@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Hector Pedro",
            'apellido_paterno' => "Hernandez",
            'apellido_materno' => "Rueda",
            'telefono' => "",
            'user_type_id' => 2,
            'user_title_id' => 6,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => null,
            'email' => "bernardo.ramirez@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Bernardo Antonio",
            'apellido_paterno' => "Ramirez",
            'apellido_materno' => "Mercado",
            'telefono' => "",
            'user_type_id' => 2,
            'user_title_id' => 8,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => null,
            'email' => "pedro.gonzalez@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Pedro",
            'apellido_paterno' => "Gonzalez",
            'apellido_materno' => "Martinez",
            'telefono' => "",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => null,
            'email' => "clemente.guzman@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Clemente",
            'apellido_paterno' => "Guzman",
            'apellido_materno' => "Vergara",
            'telefono' => "",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => null,
            'email' => "benjamin.mancio@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Benjamin",
            'apellido_paterno' => "Mancio",
            'apellido_materno' => "Venegas",
            'telefono' => "",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => null,
            'email' => "jose.molina@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Jose De Jesus",
            'apellido_paterno' => "Molina",
            'apellido_materno' => "Valencia",
            'telefono' => "",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => null,
            'email' => "erikadaniela.ritocastillo@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Erika Daniela",
            'apellido_paterno' => "Rito",
            'apellido_materno' => "Castillo",
            'telefono' => "",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => null,
            'email' => "luisantonio.fernandezcorona@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Luis Antonio",
            'apellido_paterno' => "Fernandez",
            'apellido_materno' => "Corona",
            'telefono' => "",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => null,
            'email' => "hectorhabid.rosasmendoza@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Hector Habid",
            'apellido_paterno' => "Rosas",
            'apellido_materno' => "Mendoza",
            'telefono' => "",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => null,
            'email' => "benjaminhazael.mirandatapia@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Miranda Tapia",
            'apellido_paterno' => "Benjamin",
            'apellido_materno' => "Hazael",
            'telefono' => "",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => null,
            'email' => "raulhectoresahi.martinezycota@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Esahi Martinez Y Cota",
            'apellido_paterno' => "Raul",
            'apellido_materno' => "Hector",
            'telefono' => "",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => null,
            'email' => "emiliojosue.vegadimas@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Vega Dimas",
            'apellido_paterno' => "Emilio",
            'apellido_materno' => "Josue",
            'telefono' => "",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => null,
            'email' => "rogelioalonso.cisnerosgarcia@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Cisneros Garcia",
            'apellido_paterno' => "Rogelio",
            'apellido_materno' => "Alonso",
            'telefono' => "",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => null,
            'email' => "robertovirgilio.floresgonzalez@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Flores Gonzalez",
            'apellido_paterno' => "Roberto",
            'apellido_materno' => "Virgilio",
            'telefono' => "",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => null,
            'email' => "gustavotonatiuh.valenciaalfaro@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Gustavo Tonatiuh",
            'apellido_paterno' => "Valencia",
            'apellido_materno' => "Alfaro",
            'telefono' => "",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => null,
            'email' => "armandoesau.guerreromorales@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Armando Esau",
            'apellido_paterno' => "Guerrero",
            'apellido_materno' => "Morales",
            'telefono' => "",
            'user_type_id' => 2,
            'user_title_id' => 2,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => null,
            'email' => "norberto.vazquez@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Norberto",
            'apellido_paterno' => "Vazquez",
            'apellido_materno' => "Alberto",
            'telefono' => "",
            'user_type_id' => 2,
            'user_title_id' => 1,
            'country_id' => $this->country_id,
        ]);
        User::create([
            'emp' => null,
            'email' => "carlos.jimenez@gi-de.com",
            'password' => Hash::make("GyD2024$@"),
            'nombre' =>  "Carlos Isrrael",
            'apellido_paterno' => "Jimenez",
            'apellido_materno' => "Preciado",
            'telefono' => "",
            'user_type_id' => 2,
            'user_title_id' => 1,
            'country_id' => $this->country_id,
        ]);

    }
}
