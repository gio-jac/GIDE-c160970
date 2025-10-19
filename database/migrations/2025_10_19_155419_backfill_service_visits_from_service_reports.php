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
            INSERT IGNORE INTO service_visits
                (complete_id, user_id, shift_id, branch_id, branch_manager_id, service_date, service_timezone, created_at, updated_at)
            SELECT
                sr.complete_id, sr.user_id, sr.shift_id, sr.branch_id, sr.branch_manager_id, sr.service_date, sr.service_timezone, NOW(), NOW()
            FROM service_reports sr
            WHERE sr.complete_id IS NOT NULL
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
