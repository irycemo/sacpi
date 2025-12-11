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
        Schema::create('requerimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('predio_id')->constrained();
            $table->unsignedInteger('año');
            $table->unsignedInteger('folio');
            $table->unsignedInteger('usuario');
            $table->date('fecha_notificacion')->nullable();
            $table->decimal('monto', 10,4);
            $table->string('archivo')->nullable();
            $table->foreignId('creado_por')->nullable()->references('id')->on('users');
            $table->foreignId('actualizado_por')->nullable()->references('id')->on('users');
            $table->timestamps();

            $table->unique(['año', 'folio', 'usuario']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requerimientos');
    }
};
