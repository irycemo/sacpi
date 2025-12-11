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
        Schema::create('oficinas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('region')->nullable();
            $table->unsignedBigInteger('municipio');
            $table->unsignedBigInteger('oficina');
            $table->unsignedBigInteger('localidad');
            $table->string('tipo');
            $table->json('sectores')->nullable();
            $table->string('nombre');
            $table->text('ubicacion')->nullable();
            $table->string('email')->nullable();
            $table->string('telefonos')->nullable();
            $table->foreignId('cabecera')->nullable()->references('id')->on('oficinas');
            $table->foreignId('creado_por')->nullable()->references('id')->on('users');
            $table->foreignId('actualizado_por')->nullable()->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oficinas');
    }
};
