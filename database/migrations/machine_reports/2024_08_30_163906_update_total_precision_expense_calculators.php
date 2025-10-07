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
        Schema::table('expense_calculators', function (Blueprint $table) {
            $table->decimal('total', 12, 6)->default(0)->nullable()->change();
            $table->decimal('amount', 12, 6)->default(0)->nullable()->change();
            $table->decimal('change', 12, 6)->default(0)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expense_calculators', function (Blueprint $table) {
            $table->decimal('total', 8, 2)->default(0)->nullable()->change();
            $table->decimal('amount', 8, 2)->default(0)->nullable()->change();
            $table->decimal('change', 8, 2)->default(0)->nullable()->change();
        });
    }
};
