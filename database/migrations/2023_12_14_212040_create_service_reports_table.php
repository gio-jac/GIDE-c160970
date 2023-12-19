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
        Schema::create('service_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('machine_id');
            $table->unsignedBigInteger('shift_id');
            $table->integer('transport')->default(0);
            $table->integer('pieces')->default(0);
            $table->integer('sogd')->default(0);
            $table->integer('time_on')->default(0);
            $table->integer('travel_time')->default(0);
            $table->unsignedBigInteger('report_type_id');
            $table->string('reported_error');
            $table->string('fault_symptom');
            $table->unsignedBigInteger('code_id');
            $table->string('actions_taken');
            $table->timestamp('reported')->nullable();
            $table->timestamp('arrival')->nullable();
            $table->timestamp('finished')->nullable();
            $table->timestamp('departure')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->boolean('is_tested')->default(false);
            $table->integer('dt')->default(0);
            $table->string('notes');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('machine_id')->references('id')->on('machines');
            $table->foreign('code_id')->references('id')->on('codes');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('shift_id')->references('id')->on('shifts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_reports');
    }
};
