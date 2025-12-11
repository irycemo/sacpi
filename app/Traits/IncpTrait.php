<?php

namespace App\Traits;

use App\Exceptions\GeneralException;
use App\Models\Valor;

trait IncpTrait
{

    public function inpcMesDePago($mes, $ejercicio_fiscal){

        $valores = Valor::where('ejercicio_fiscal', $ejercicio_fiscal)->first();

        if(!$valores){

            throw new GeneralException("No hay valores para el ejercicio fiscal " . $ejercicio_fiscal . '.');

        }

        return match($mes){
            1  => $valores->inpc_enero,
            2  => $valores->inpc_febrero,
            3  => $valores->inpc_marzo,
            4  => $valores->inpc_abril,
            5  => $valores->inpc_mayo,
            6  => $valores->inpc_junio,
            7  => $valores->inpc_julio,
            8  => $valores->inpc_agosto,
            9  => $valores->inpc_septiembre,
            10 => $valores->inpc_octubre,
            11 => $valores->inpc_noviembre,
            12 => $valores->inpc_diciembre,
        };

    }

}
