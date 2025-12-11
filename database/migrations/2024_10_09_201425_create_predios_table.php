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
        Schema::create('predios', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('activo');
            $table->boolean('exento')->default(0);
            $table->unsignedInteger('estado');
            $table->unsignedInteger('region_catastral');
            $table->unsignedInteger('municipio');
            $table->unsignedInteger('zona_catastral');
            $table->unsignedInteger('localidad');
            $table->unsignedInteger('sector');
            $table->unsignedInteger('manzana');
            $table->unsignedInteger('predio');
            $table->unsignedInteger('edificio');
            $table->unsignedInteger('departamento');
            $table->unsignedInteger('oficina');
            $table->unsignedInteger('tipo_predio');
            $table->unsignedInteger('numero_registro');
            $table->string('tipo_vialidad')->nullable();
            $table->string('tipo_asentamiento')->nullable();
            $table->string('nombre_vialidad')->nullable();
            $table->string('numero_exterior')->nullable();
            $table->string('numero_exterior_2')->nullable();
            $table->string('numero_adicional')->nullable();
            $table->string('numero_adicional_2')->nullable();
            $table->string('numero_interior')->nullable();
            $table->string('nombre_asentamiento')->nullable();
            $table->string('codigo_postal')->nullable();
            $table->string('lote_fraccionador')->nullable();
            $table->string('manzana_fraccionador')->nullable();
            $table->string('etapa_fraccionador')->nullable();
            $table->text('nombre_predio')->nullable();
            $table->string('nombre_edificio')->nullable();
            $table->string('clave_edificio')->nullable();
            $table->string('departamento_edificio')->nullable();
            $table->string('uso_1')->nullable();
            $table->string('uso_2')->nullable();
            $table->string('uso_3')->nullable();
            $table->string('ubicacion_en_manzana')->nullable();
            $table->decimal('superficie_total_terreno', 18,4)->nullable();
            $table->decimal('superficie_total_construccion', 18,4)->nullable();
            $table->decimal('superficie_judicial', 18,4)->nullable();
            $table->decimal('superficie_notarial', 18,4)->nullable();
            $table->decimal('area_comun_terreno', 10, 4)->nullable();
            $table->decimal('area_comun_construccion', 10, 4)->nullable();
            $table->decimal('valor_terreno_comun', 10, 4)->nullable();
            $table->decimal('valor_construccion_comun', 10, 4)->nullable();
            $table->decimal('valor_total_terreno', 18,4)->nullable();
            $table->decimal('valor_total_construccion', 18,4)->nullable();
            $table->decimal('valor_catastral', 18,4)->nullable();
            $table->string('curt')->nullable();
            $table->string('folio_real')->nullable();
            $table->string('xutm')->nullable();
            $table->string('yutm')->nullable();
            $table->unsignedInteger('zutm')->nullable();
            $table->decimal('lon', 11, 8)->nullable();
            $table->decimal('lat', 11, 8)->nullable();
            $table->date('fecha_efectos')->nullable();
            $table->string('documento_entrada')->nullable();
            $table->string('documento_numero')->nullable();
            $table->string('declarante')->nullable();
            $table->text('observaciones')->nullable();
            $table->string('origen')->nullable();
            $table->dateTime('indexado_en')->nullable();
            $table->foreignId('creado_por')->nullable()->references('id')->on('users');
            $table->foreignId('actualizado_por')->nullable()->references('id')->on('users');
            $table->timestamps();

            $table->unique(['localidad', 'oficina', 'tipo_predio', 'numero_registro'], 'cuenta_predial');

            $table->unique(['estado', 'region_catastral', 'municipio', 'zona_catastral', 'localidad', 'sector', 'manzana', 'predio', 'edificio', 'departamento'], 'clave_catastral');

            $table->index(['documento_entrada', 'documento_numero']);

            $table->index('oficina');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('predios');
    }
};
