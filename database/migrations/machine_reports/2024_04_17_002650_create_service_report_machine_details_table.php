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
        Schema::create('service_report_machine_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_report_machine_id');
            $table->unsignedBigInteger('module_id')->nullable();
            $table->unsignedBigInteger('failure_id')->nullable();
            $table->unsignedBigInteger('failure_type_id')->nullable();
            $table->timestamps();
            $table->foreign('service_report_machine_id')->references('id')->on('service_report_machine');
            $table->foreign('module_id')->references('id')->on('modules');
            $table->foreign('failure_id')->references('id')->on('failures');
            $table->foreign('failure_type_id')->references('id')->on('failure_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_report_machine_details');
    }
};
