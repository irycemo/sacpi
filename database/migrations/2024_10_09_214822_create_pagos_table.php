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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('predio_id')->constrained();
            $table->string('status'); //Pagado o Cancelado
            $table->string('tipo'); //Ventanilla o En Línea
            $table->unsignedInteger('año');
            $table->unsignedInteger('folio');
            $table->unsignedInteger('usuario');
            $table->date('fecha_pago');

            //Datos bancarios
            $table->string('linea_captura')->nullable();
            $table->string('mensaje')->nullable();
            $table->string('autorizacion')->nullable();
            $table->string('medio_pago')->nullable();

            $table->decimal('sub_total', 10, 4)->nullable();
            $table->decimal('total', 10, 4)->nullable();

            $table->string('observaciones')->nullable();

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
        Schema::dropIfExists('pagos');
    }
};
