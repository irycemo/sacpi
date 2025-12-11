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
        Schema::create('estadisticos', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('ejercicio_fiscal'); //anio_002
            $table->unsignedInteger('eficiencia_recaudatoria'); //efic
            $table->unsignedInteger('total_predios'); //nump
            $table->decimal('recaudado_urbanos', 10, 4); //rurb
            $table->decimal('recaudado_rusticos', 10, 4); //rrus
            $table->unsignedInteger('predios_pagados_urbanos'); //npur
            $table->unsignedInteger('predios_pagados_rusticos'); //nprr

            $table->unsignedInteger('predios_facturados_urbanos_cm'); //nufm
            $table->decimal('valor_catastral_urbanos_cm', 10, 4); //vufm
            $table->decimal('facturacion_urbanos_cm', 10, 4); //iufm
            $table->unsignedInteger('predios_facturados_urbanos_sm'); //nufs
            $table->decimal('valor_catastral_urbanos_sm', 10, 4); //vufs
            $table->decimal('facturacion_urbanos_sm', 10, 4); //iufs

            $table->unsignedInteger('predios_facturados_rusticos_cm'); //nrfm
            $table->decimal('valor_catastral_rusticos_cm', 10, 4); //vrfm
            $table->decimal('facturacion_rusticos_cm', 10, 4); //irfm
            $table->unsignedInteger('predios_facturados_rusticos_sm'); //nrfs
            $table->decimal('valor_catastral_rusticos_sm', 10, 4); //vrfs
            $table->decimal('facturacion_rusticos_sm', 10, 4); //irfs

            $table->unsignedInteger('predios_excentos'); //noex
            $table->decimal('monto_excentos', 10, 4); //imex

            //Segundo Reporte
            $table->unsignedInteger('predios_pagados_rezago_urbanos');
            $table->unsignedInteger('predios_pagados_rezago_rusticos');

            $table->decimal('recaudacion_cuenta_corriente_urbanos', 10, 4);
            $table->decimal('recaudacion_cuenta_corriente_rusticos', 10, 4);

            $table->decimal('recargos_cuenta_corriente', 10, 4);
            $table->decimal('multas_cuenta_corriente', 10, 4);
            $table->decimal('gastos_ejecuacion_cuenta_corriente', 10, 4);

            $table->decimal('recaudacion_rezago_urbanos', 10, 4);
            $table->decimal('recaudacion_rezago_rusticos', 10, 4);
            $table->decimal('recargos_rezago', 10, 4);
            $table->decimal('multas_rezago', 10, 4);
            $table->decimal('gastos_ejecuacion_rezago', 10, 4);

            $table->decimal('recaudacion_isai', 10, 4);
            $table->decimal('multas_recargos_isai', 10, 4);

            $table->foreignId('creado_por')->nullable()->references('id')->on('users');
            $table->foreignId('actualizado_por')->nullable()->references('id')->on('users');

            $table->timestamps();


            //$table->unique('ejercicio_fiscal', 'anio_fiscal');
            //$table->index('ejercicio_fiscal');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estadisticos');
    }
};
