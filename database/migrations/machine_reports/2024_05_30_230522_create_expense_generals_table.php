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
        Schema::create('expense_generals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expense_id');
            $table->string('uuid')->nullable();
            $table->integer('selectExpense')->default(0);
            $table->string('city')->nullable();
            $table->decimal('amount', 8, 2)->default(0)->nullable();
            $table->decimal('tip', 8, 2)->default(0)->nullable();
            $table->date('dateExpense');
            $table->foreign('expense_id')->references('id')->on('expenses');
            $table->timestamps();

        });

        /**
            *column type values 
            *   0  LODGING	
            *   1  TRANSPORT: AIR, RAIL, ETC	
            *   2  TRANSPORT: RENTAL CAR, LIMO, ETC	
            *   3  TRANSPORT: LOCAL TAXI, TOLLS & PUBLIC TRNSIT	
            *   4  TRANSPORT: AUTO EXPENSES	
            *   5  MEALS: BREAKFAST	
            *   6  MEALS: LUNCH	
            *   7  MEALS: DINNER	
            *   8  ENTERTAINMENT	
            *   9  MISCELANEUS	

        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_generals');
    }
};
