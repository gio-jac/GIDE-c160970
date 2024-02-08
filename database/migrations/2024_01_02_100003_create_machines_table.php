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
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->string('serial')->unique();
            $table->integer('transport_hours')->default(0);
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('machine_model_id');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->foreign('machine_model_id')->references('id')->on('machine_models');
            $table->foreign('client_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machines');
    }
};
