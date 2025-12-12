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
        Schema::create('pagosisais', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('año');
            $table->unsignedInteger('folio');
            $table->unsignedInteger('usuario');
            $table->unsignedInteger('notaria');
            $table->string('aviso_año');
            $table->string('aviso_folio');
            $table->string('aviso_usuario');

            $table->decimal('isai', 10, 4);
            $table->decimal('actualizacion', 10, 4);
            $table->decimal('multas', 10, 4);
            $table->decimal('recargos', 10, 4);
            $table->decimal('total', 10, 4);
            $table->string('status'); //Pagado o Cancelado
            $table->string('tipo'); //Ventanilla o En Línea
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
        Schema::dropIfExists('pagosisais');
    }
};
