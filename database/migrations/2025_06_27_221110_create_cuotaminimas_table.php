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
        Schema::create('cuotaminimas', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('municipio');
            $table->date('fecha_inicial');
            $table->date('fecha_final');
            $table->decimal('diario', 18,2);
            $table->decimal('mensual', 18,2)->nullable();
            $table->decimal('anual', 18,2)->nullable();
            $table->decimal('umas', 10, 2)->nullable();
            $table->decimal('cuota_minima', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuotaminimas');
    }
};
