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
        Schema::create('machine_models', function (Blueprint $table) {
            $table->id();
            $table->string('model')->unique();
            $table->unsignedBigInteger('model_segment_id');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->foreign('model_segment_id')->references('id')->on('model_segments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machine_models');
    }
};
