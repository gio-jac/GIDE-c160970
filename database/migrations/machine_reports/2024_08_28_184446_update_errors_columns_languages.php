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
        Schema::table('failure_types', function (Blueprint $table) {
            $table->after('name', function ($table) {
                $table->string('es', 100)->nullable();
                $table->string('pt', 100)->nullable();
            });
        });
        Schema::table('failures', function (Blueprint $table) {
            $table->after('name', function ($table) {
                $table->string('es', 100)->nullable();
                $table->string('pt', 100)->nullable();
            });
        });
        Schema::table('modules', function (Blueprint $table) {
            $table->after('name', function ($table) {
                $table->string('es', 100)->nullable();
                $table->string('pt', 100)->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('failure_types', function (Blueprint $table) {
            $table->dropColumn('es');
            $table->dropColumn('pt');
        });
    
        Schema::table('failures', function (Blueprint $table) {
            $table->dropColumn('es');
            $table->dropColumn('pt');
        });
    
        Schema::table('modules', function (Blueprint $table) {
            $table->dropColumn('es');
            $table->dropColumn('pt');
        });
    }
};
