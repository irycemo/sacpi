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
        Schema::create('descuento_oficina', function (Blueprint $table) {
            $table->id();
            $table->string('estado');
            $table->foreignId('oficina_id')->constrained()->onDelete('cascade');
            $table->foreignId('descuento_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('descuento_oficina');
    }
};
