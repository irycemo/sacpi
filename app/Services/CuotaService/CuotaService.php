<?php

namespace App\Services\CuotaService;

use App\Models\Parametro;

class CuotaService{

    public function execute(Parametro $parametros, float $valor_catastral, int $año_efectos, int $tipo_predio){

        $tipo_cuota = 'superior';

        $tasa = match (true) {
            $año_efectos <= 1980 =>
                $tipo_predio == 1
                    ? $parametros->tasa_urbanos_1980
                    : $parametros->tasa_rusticos_1980,

            $año_efectos >= 1981 && $año_efectos <= 1983 =>
                $tipo_predio == 1
                    ? $parametros->tasa_urbanos_81a83
                    : $parametros->tasa_rusticos_81a83,

            $año_efectos >= 1984 && $año_efectos <= 1985 =>
                $tipo_predio == 1
                    ? $parametros->tasa_urbanos_84y85
                    : $parametros->tasa_rusticos_84y85,

            $año_efectos >= 1986 =>
                $tipo_predio == 1
                    ? $parametros->tasa_urbanos_1986
                    : $parametros->tasa_rusticos_1986,
        };

        /* dd($tasa); */

        $impuesto_anual = ($tasa/100) * $valor_catastral;

        switch ($tipo_predio)
        {
            case 1:
                if ($impuesto_anual < $parametros->cuota_minima_predial_urbanos){
                    $impuesto_anual = $parametros->cuota_minima_predial_urbanos;
                    $tipo_cuota = "minima";
                }

                break;
            case 2:
                if ($impuesto_anual < $parametros->cuota_minima_predial_rusticos){
                    $impuesto_anual = $parametros->cuota_minima_predial_rusticos;
                    $tipo_cuota = "minima";
                }

                break;
            case 3:
                if ($impuesto_anual < $parametros->cuota_minima_ejidal_urbanos){
                    $impuesto_anual = $parametros->cuota_minima_ejidal_urbanos;
                    $tipo_cuota = "minima";
                }

                break;
            case 4:
                if ($impuesto_anual < $parametros->cuota_minima_ejidal_rusticos){
                    $impuesto_anual = $parametros->cuota_minima_ejidal_rusticos;
                    $tipo_cuota = "minima";
                }
                break;
        }

        return [
            'tipo_cuota' => $tipo_cuota,
            'tasa' => $tasa,
            'impuesto_anual' => $impuesto_anual,
        ];

    }

}