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
        Schema::create('expense_meals', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('expense_id');
            $table->string('general_id')->nullable();
            $table->string('city')->nullable();
            $table->string('selectExpense')->nullable();
            $table->string('restaurant')->nullable();
            $table->decimal('amount', 8, 2)->default(0)->nullable();
            $table->decimal('tip', 8, 2)->default(0)->nullable();
            $table->time('time')->nullable();
            $table->date('dateExpense');
            $table->foreign('expense_id')->references('id')->on('expenses');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_meals');
    }
};
