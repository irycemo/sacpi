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
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('predio_id')->constrained();
            $table->foreignId('pago_id')->nullable()->constrained();
            $table->string('status'); //FACTURADO|REFACTURADO|PAGADO|REZAGO
            $table->unsignedInteger('ejercicio_fiscal');
            $table->string('cuota');
            $table->unsignedInteger('bimestre');
            $table->decimal('total', 10, 4)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
