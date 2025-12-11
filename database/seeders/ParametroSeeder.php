<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Parametro;

class ParametroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Parametro::create([
            'oficina_id' => 53,
            'ejercicio_fiscal' => 2023,
            'nombre_titular' => "NOMBRE DEL TITULAR",
            'tasa_isai' => 2,
            'cuota_minima_isai' => 518.70,
            'tasa_recargos_isai' => 2,
            'cuota_minima_predial_urbanos' => 518.7,
            'cuota_minima_predial_rusticos' => 414.96,
            'cuota_minima_ejidal_urbanos' => 414.96,
            'cuota_minima_ejidal_rusticos' => 414.96,
            'tasa_urbanos_1980' => 2.7000,
            'tasa_urbanos_81a83' => 1.1000,
            'tasa_urbanos_84y85' => 0.4000,
            'tasa_urbanos_1986' => 0.3900,
            'tasa_urbanos_ejidales' => 0.0140,
            'tasa_rusticos_1980' => 4.0000,
            'tasa_rusticos_81a83' => 1.1000,
            'tasa_rusticos_84y85' => 0.8000,
            'tasa_rusticos_1986' => 0.3900,
            'tasa_rusticos_ejidales' => 0.1400,
        ]);

        Parametro::create([
            'oficina_id' => 53,
            'ejercicio_fiscal' => 2024,
            'nombre_titular' => "NOMBRE DEL TITULAR",
            'tasa_isai' => 2,
            'cuota_minima_isai' => 543,
            'tasa_recargos_isai' => 2,
            'cuota_minima_predial_urbanos' => 543,
            'cuota_minima_predial_rusticos' => 434,
            'cuota_minima_ejidal_urbanos' => 434,
            'cuota_minima_ejidal_rusticos' => 434,
            'tasa_urbanos_1980' => 2.7000,
            'tasa_urbanos_81a83' => 1.1000,
            'tasa_urbanos_84y85' => 0.4000,
            'tasa_urbanos_1986' => 0.3900,
            'tasa_urbanos_ejidales' => 0.0140,
            'tasa_rusticos_1980' => 4.0000,
            'tasa_rusticos_81a83' => 1.1000,
            'tasa_rusticos_84y85' => 0.8000,
            'tasa_rusticos_1986' => 0.3900,
            'tasa_rusticos_ejidales' => 0.1400,
        ]);

        Parametro::create([
            'oficina_id' => 53,
            'ejercicio_fiscal' => 2025,
            'nombre_titular' => "NOMBRE DEL TITULAR",
            'tasa_isai' => 2,
            'cuota_minima_isai' => 566,
            'tasa_recargos_isai' => 2,
            'cuota_minima_predial_urbanos' => 566,
            'cuota_minima_predial_rusticos' => 453,
            'cuota_minima_ejidal_urbanos' => 453,
            'cuota_minima_ejidal_rusticos' => 453,
            'tasa_urbanos_1980' => 2.7000,
            'tasa_urbanos_81a83' => 1.1000,
            'tasa_urbanos_84y85' => 0.4000,
            'tasa_urbanos_1986' => 0.3900,
            'tasa_urbanos_ejidales' => 0.0140,
            'tasa_rusticos_1980' => 4.0000,
            'tasa_rusticos_81a83' => 1.1000,
            'tasa_rusticos_84y85' => 0.8000,
            'tasa_rusticos_1986' => 0.3900,
            'tasa_rusticos_ejidales' => 0.1400,
        ]);
    }
}
