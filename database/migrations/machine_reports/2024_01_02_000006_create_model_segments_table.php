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
        Schema::create('model_segments', function (Blueprint $table) {
            $table->id();
            $table->string('segment')->unique();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_multi_transport')->default(false);
            $table->boolean('is_multi_signature')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_segments');
    }
};
