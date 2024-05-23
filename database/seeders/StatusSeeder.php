<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\machine_reports\Status;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::create(['status' => "COMPLETE", 'description' => "COMPLETE" ]);
        Status::create(['status' => "INCOMPLT", 'description' => "INCOMPLETE" ]);
        Status::create(['status' => "RETURN", 'description' => "RETURN" ]);
    }
}
