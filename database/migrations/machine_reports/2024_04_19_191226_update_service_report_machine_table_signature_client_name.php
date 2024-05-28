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
            $table->after('dt', function ($table) {
                $table->string('signature_client_name')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_report_machine', function (Blueprint $table) {
            $table->dropColumn('signature_client_name');
        });
    }
};
