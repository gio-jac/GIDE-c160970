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
            $table->decimal('transport_1', 5, 1)->default(0.0)->change();
            $table->decimal('transport_2', 5, 1)->default(0.0)->change();
            $table->after('transport_2', function ($table) {
                $table->decimal('transport_3', 5, 1)->default(0.0);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_report_machine', function (Blueprint $table) {
            $table->dropColumn('transport_1');
            $table->dropColumn('transport_2');
            $table->dropColumn('transport_3');
        });
    }
};
