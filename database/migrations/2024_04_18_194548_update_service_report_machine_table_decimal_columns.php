<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('service_report_machine', function (Blueprint $table) {
            $table->decimal('transport_1', 6, 1)->default(0.0)->change();
            $table->decimal('transport_2', 6, 1)->default(0.0)->change();
            $table->decimal('transport_3', 6, 1)->default(0.0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
