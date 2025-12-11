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
        Schema::create('pago_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pago_id')->constrained();
            $table->unsignedInteger('ejercicio_fiscal');
            $table->string('concepto'); //Bimestre, año
            $table->string('tipo'); //Cuenta corriente, Rezagos
            $table->decimal('impuesto', 10, 4);
            $table->decimal('actualizacion', 10, 4)->nullable();
            $table->decimal('recargos', 10, 4)->nullable();
            $table->decimal('multas', 10, 4)->nullable();
            $table->decimal('requerimientos', 10, 4)->nullable();
            $table->decimal('subtotal', 10, 4)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pago_detalles');
    }
};
