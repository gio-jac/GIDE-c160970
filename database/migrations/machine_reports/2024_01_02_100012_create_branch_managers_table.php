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
        Schema::create('branch_managers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default("N/A");
            $table->string('email')->default("N/A");
            $table->string('phone')->default("N/A");
            $table->unsignedBigInteger('branch_id');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->foreign('branch_id')->references('id')->on('branches');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_managers');
    }
};
