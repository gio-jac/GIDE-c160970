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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('emp', 10)->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nombre');
            $table->string('apellido_paterno');
            $table->string('apellido_materno')->nullable();
            $table->string('telefono')->nullable();
            $table->rememberToken();
            $table->unsignedBigInteger('user_type_id');
            $table->unsignedBigInteger('user_title_id');
            $table->unsignedBigInteger('country_id');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->foreign('user_type_id')->references('id')->on('user_types');
            $table->foreign('user_title_id')->references('id')->on('user_titles');
            $table->foreign('country_id')->references('id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
