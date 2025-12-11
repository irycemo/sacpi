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
        Schema::create('parametros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('oficina_id')->constrained();
            $table->unsignedInteger('ejercicio_fiscal');
            $table->string('nombre_titular');
            $table->decimal('tasa_isai', 10, 4);
            $table->decimal('cuota_minima_isai', 10, 4);
            $table->decimal('tasa_recargos_isai', 10, 4);
            $table->decimal('cuota_minima_predial_urbanos', 10, 4);
            $table->decimal('cuota_minima_predial_rusticos', 10, 4);
            $table->decimal('cuota_minima_ejidal_urbanos', 10, 4);
            $table->decimal('cuota_minima_ejidal_rusticos', 10, 4);
            $table->decimal('tasa_urbanos_1980', 10, 4);
            $table->decimal('tasa_urbanos_81a83', 10, 4);
            $table->decimal('tasa_urbanos_84y85', 10, 4);
            $table->decimal('tasa_urbanos_1986', 10, 4);
            $table->decimal('tasa_urbanos_ejidales', 10, 4);
            $table->decimal('tasa_rusticos_1980', 10, 4);
            $table->decimal('tasa_rusticos_81a83', 10, 4);
            $table->decimal('tasa_rusticos_84y85', 10, 4);
            $table->decimal('tasa_rusticos_1986', 10, 4);
            $table->decimal('tasa_rusticos_ejidales', 10, 4);
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
        Schema::dropIfExists('parametros');
    }
};
