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
        Schema::table('expense_tickets', function (Blueprint $table) {
            $table->string('ticketPdf')->nullable()->after('ticket');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('expense_tickets', function (Blueprint $table) {
            $table->dropColumn('ticketPdf');
        });
    }
};
