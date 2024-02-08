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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('address')->default("N/A");
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('client_id');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('client_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
