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
        Schema::create('propietarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('predio_id')->constrained();
            $table->foreignId('persona_id')->constrained();
            $table->Decimal('porcentaje_propiedad', 15,4)->nullable();
            $table->Decimal('porcentaje_nuda', 15,4)->nullable();
            $table->Decimal('porcentaje_usufructo', 15,4)->nullable();
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
        Schema::dropIfExists('propietarios');
    }
};
