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
                $table->boolean('updated_translation')->default(false);
            });
        });
        Schema::table('failures', function (Blueprint $table) {
            $table->after('name', function ($table) {
                $table->boolean('updated_translation')->default(false);
            });
        });
        Schema::table('modules', function (Blueprint $table) {
            $table->after('name', function ($table) {
                $table->boolean('updated_translation')->default(false);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('failure_types', function (Blueprint $table) {
            $table->dropColumn('updated_translation');
        });
    
        Schema::table('failures', function (Blueprint $table) {
            $table->dropColumn('updated_translation');
        });
    
        Schema::table('modules', function (Blueprint $table) {
            $table->dropColumn('updated_translation');
        });
    }
};
