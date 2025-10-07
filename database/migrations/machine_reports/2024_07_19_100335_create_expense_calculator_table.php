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
        Schema::create('expense_calculators', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expense_id');
            $table->decimal('amount', 8, 2)->default(0)->nullable();
            $table->decimal('change', 8, 2)->default(0)->nullable();
            $table->decimal('total', 8, 2)->default(0)->nullable();
            $table->string('currency')->nullable();
            $table->foreign('expense_id')->references('id')->on('expenses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_calculators');
    }
};
