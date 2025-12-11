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
        Schema::create('descuento_pago', function (Blueprint $table) {
            $table->id();
            $table->foreignId('descuento_id')->constrained();
            $table->foreignId('pago_id')->constrained();
            $table->decimal('monto', 10, 4);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('descuento_pago');
    }
};
