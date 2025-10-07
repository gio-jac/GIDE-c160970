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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->date('endingDate');
            $table->uuid('uuid');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('cc_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('advanceRequest_id')->nullable();
            $table->integer('daysAway')->default(0);
            $table->integer('daysPersonalAffairs')->default(0);
            $table->integer('totalDaysAway')->default(0);
            $table->string('purposeTravel')->nullable();
            $table->integer('methodOfReimbursment')->default(0);
            $table->date('payAdvanceDate')->nullable();
            $table->decimal('payAdvance', 8, 2)->default(0)->nullable();
            $table->decimal('payToReturn', 8, 2)->default(0)->nullable();
            $table->decimal('totalExpense', 8, 2)->default(0)->nullable();
            $table->string('approveBy')->nullable();
            $table->string('destinyFrom')->nullable();
            $table->string('destinyTo')->nullable();
            $table->string('concept')->nullable();
            $table->date('finishDate')->nullable();
            $table->integer('status')->default(0);
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('cc_id')->references('id')->on('cost_centers');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('advanceRequest_id')->references('id')->on('advance_requests');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
