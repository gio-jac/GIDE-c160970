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
        Schema::create('expense_others', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expense_id');
            $table->string('general_id')->nullable();
            $table->integer('selectExpense')->default(0);
            $table->string('description')->nullable();
            $table->decimal('amount', 8, 2)->default(0)->nullable();
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
        Schema::dropIfExists('expense_others');
    }
};
