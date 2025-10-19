<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            UPDATE service_reports sr
            JOIN service_visits sv ON sv.complete_id = sr.complete_id
            SET sr.service_visit_id = sv.id
            WHERE sr.service_visit_id IS NULL
                AND sr.complete_id IS NOT NULL
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            UPDATE service_reports sr
            SET service_visit_id = NULL
        ");
    }
};
