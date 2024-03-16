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
            $table->string('complete_id')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('shift_id');
            $table->string('pieces')->nullable();
            $table->string('sogd')->nullable();
            $table->decimal('time_on', 8, 2)->nullable();
            $table->string('travel_time')->nullable();
            $table->unsignedBigInteger('report_type_id')->nullable();
            $table->string('reported_error')->nullable();
            $table->unsignedBigInteger('code_id')->nullable();
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('branch_manager_id');
            $table->string('actions_taken')->nullable();
            $table->timestamp('reported')->nullable();
            $table->timestamp('arrival')->nullable();
            $table->timestamp('finished')->nullable();
            $table->timestamp('departure')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->boolean('is_tested')->default(false)->nullable();;
            $table->string('notes')->nullable();
            $table->string('signature_client_name_1')->nullable();
            $table->string('signature_client_name_2')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('code_id')->references('id')->on('codes');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('shift_id')->references('id')->on('shifts');
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
