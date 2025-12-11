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
        Schema::create('valors', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('ejercicio_fiscal');
            $table->decimal('valor_catastral_minimo_urbanos', 10, 4);
            $table->decimal('valor_catastral_minimo_rusticos', 10, 4);
            $table->decimal('inpc_enero', 10, 4)->nullable();
            $table->decimal('inpc_febrero', 10, 4)->nullable();
            $table->decimal('inpc_marzo', 10, 4)->nullable();
            $table->decimal('inpc_abril', 10, 4)->nullable();
            $table->decimal('inpc_mayo', 10, 4)->nullable();
            $table->decimal('inpc_junio', 10, 4)->nullable();
            $table->decimal('inpc_julio', 10, 4)->nullable();
            $table->decimal('inpc_agosto', 10, 4)->nullable();
            $table->decimal('inpc_septiembre', 10, 4)->nullable();
            $table->decimal('inpc_octubre', 10, 4)->nullable();
            $table->decimal('inpc_noviembre', 10, 4)->nullable();
            $table->decimal('inpc_diciembre', 10, 4)->nullable();
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
        Schema::dropIfExists('valors');
    }
};
