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
        Schema::create('service_visits', function (Blueprint $table) {
            $table->id();
            $table->string('complete_id')->unique();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('shift_id')->constrained('shifts');
            $table->foreignId('branch_id')->constrained('branches');
            $table->foreignId('branch_manager_id')->constrained('branch_managers');
            $table->date('service_date');
            $table->string('service_timezone', 32);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_visits');
    }
};
