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
        Schema::table('service_reports', function (Blueprint $table) {
            $table->dropForeign(['service_visit_id']);
        });

        Schema::table('service_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('service_visit_id')->nullable(false)->change();
        });

        Schema::table('service_reports', function (Blueprint $table) {
            $table->foreign('service_visit_id')
                ->references('id')->on('service_visits');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_reports', function (Blueprint $table) {
            $table->dropForeign(['service_visit_id']);
        });

        Schema::table('service_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('service_visit_id')->nullable()->change();
        });

        Schema::table('service_reports', function (Blueprint $table) {
            $table->foreign('service_visit_id')
                ->references('id')->on('service_visits');
        });
    }
};
