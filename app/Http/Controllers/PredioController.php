<?php

namespace App\Http\Controllers;

use App\Models\Predio;
use App\Models\Parametro;
use App\Services\CuotaService\CuotaService;

class PredioController extends Controller
{

    public $tasa;
    public $adeudos = [];
    public $tipocuota = "superior";
    public $impuesto_anual;
    public $anio;
    public $impuesto_redondeado;

    public function verDetalle(Predio $predio)
    {

        $ejercicio_fiscal = Parametro::where('oficina_id', auth()->user()->oficina_id)
                                        ->where('ejercicio_fiscal', now()->year)
                                        ->first();

        if ($ejercicio_fiscal === null){

            abort(403, message:"La oficina no tiene parametros para el ejercicio fiscal actual");

        }

        $this->anio = $predio->anioFechaEfectos();

        $data = (new CuotaService())->execute($ejercicio_fiscal, $predio->valor_catastral, $this->anio, $predio->tipo_predio);

        $data = array_merge($data, [
            'predio' => $predio,
            'ejercicio_fiscal'=> $ejercicio_fiscal,
        ]);

        return view('predio.detail', $data);

    }

    public function verPredio(Predio $predio)
    {

        return view('predio.show', compact('predio'));

    }

}
