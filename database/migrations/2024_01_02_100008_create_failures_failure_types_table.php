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
        Schema::create('failures_failure_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('failure_id');
            $table->unsignedBigInteger('failure_type_id');
            $table->timestamps();

            $table->foreign('failure_id')->references('id')->on('failures');
            $table->foreign('failure_type_id')->references('id')->on('failure_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('failures_failure_types');
    }
};
