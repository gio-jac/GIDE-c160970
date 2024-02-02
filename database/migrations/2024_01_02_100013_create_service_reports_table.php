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
            $table->string('pieces');
            $table->string('sogd');
            $table->decimal('time_on', 8, 2)->default(0);
            $table->string('travel_time');
            $table->unsignedBigInteger('report_type_id');
            $table->string('reported_error');
            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('failure_id');
            $table->unsignedBigInteger('failure_type_id');
            $table->unsignedBigInteger('code_id');
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('branch_manager_id');
            $table->string('actions_taken');
            $table->timestamp('reported')->nullable();
            $table->timestamp('arrival')->nullable();
            $table->timestamp('finished')->nullable();
            $table->timestamp('departure')->nullable();
            $table->unsignedBigInteger('status_id');
            $table->boolean('is_tested')->default(false);
            $table->integer('dt')->default(0);
            $table->string('notes');
            $table->string('signature_client_name')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('machine_id')->references('id')->on('machines');
            $table->foreign('code_id')->references('id')->on('codes');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('shift_id')->references('id')->on('shifts');
            $table->foreign('module_id')->references('id')->on('modules');
            $table->foreign('failure_id')->references('id')->on('failures');
            $table->foreign('failure_type_id')->references('id')->on('failure_types');
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('branch_manager_id')->references('id')->on('branch_managers');
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
