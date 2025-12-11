<?php

namespace App\Services\RezagoService;

use App\Models\Uma;
use App\Models\Predio;
use App\Models\Factura;
use App\Traits\IncpTrait;

class RezagoService{

    use IncpTrait;

    public Uma $uma;
    public $requerimiento;

    public function __construct(public Predio $predio, public string $tipo_cuota)
    {

        $this->uma = Uma::where('año', now()->year)->first();

        $this->requerimiento = $this->predio->requerimientos()->whereNotNull('fecha_notificacion')->latest()->first();

    }

    public function construirRezagos(array $estados):array
    {

        return Factura::where('predio_id', $this->predio->id)
                        ->whereIn('status', $estados)
                        ->get()
                        ->groupBy('ejercicio_fiscal')
                        ->map(function($facturas){

                            if($this->tipo_cuota == 'minima'){

                                return $this->cuaotaMinimaRezagos($facturas);

                            }else{

                                return $this->cuotaSuperiorRezagos($facturas);

                            }

                        })
                        ->toArray();

    }

    public function cuaotaMinimaRezagos($facturas):array
    {

        $actualizacion = 0;
        $recargos = 0;
        $multa = 0;
        $subtotal = 0;
        $requerimiento = 0;

        foreach($facturas as $factura){

            $inpc_mes_antiguo_periodo_pago = $this->inpcMesDePago(1, $factura->ejercicio_fiscal);

            if ((now()->month -1 ) == 0){ //Caso Enero

                $inpc_mes_anterior_de_pago = $this->inpcMesDePago(12, (now()->year - 1));

            }else{//Resto de los meses

                $inpc_mes_anterior_de_pago = $this->inpcMesDePago((now()->month - 1), now()->year);

            }

            $actualizacion = $actualizacion + (($inpc_mes_anterior_de_pago / $inpc_mes_antiguo_periodo_pago) * $factura->total) - $factura->total;

            $mesesvencidos = $mesesvencidos + (((now()->year - $factura->ejercicio_fiscal) * 12) - 2) + now()->month;

            $recargos = $recargos + ($factura->total + $actualizacion) * (2 * ($mesesvencidos / 100));

        }

        if ($this->predio->tipo_predio == 1){

            $multa = $this->uma->diario * 2;

        }else{

            $multa = $this->uma->diario * 1;

        }

        $subtotal = round($factura->total) + round($actualizacion) + round($recargos) + round($multa);

        if($this->requerimiento && $this->requerimiento->año >= $factura->ejercicio_fiscal){

            $requerimiento = $subtotal * 0.03;

            if($requerimiento < $this->uma->diario){

                $requerimiento = $this->uma->diario;

            }

            $subtotal = $subtotal + round($requerimiento);

        }

        return [
            'ejercicio_fiscal' => $factura->ejercicio_fiscal,
            'impuesto' => $facturas->sum('total'),
            'actualizacion' => round($actualizacion),
            'recargos' => round($recargos),
            'multas' => round($multa),
            'requerimientos' => round($requerimiento),
            'subtotal' => $subtotal
        ];

    }

    public function cuotaSuperiorRezagos($facturas):array
    {

        $actualizacion = 0;
        $impuesto_facturado = 0;
        $recargos = 0;
        $subtotal = 0;
        $requerimiento = 0;

        foreach($facturas as $factura){

            $inpc_mes_antiguo_periodo_pago = match($factura->bimestre){
                1 => $this->inpcMesDePago(1, $factura->ejercicio_fiscal),
                2 => $this->inpcMesDePago(3, $factura->ejercicio_fiscal),
                3 => $this->inpcMesDePago(5, $factura->ejercicio_fiscal),
                4 => $this->inpcMesDePago(7, $factura->ejercicio_fiscal),
                5 => $this->inpcMesDePago(9, $factura->ejercicio_fiscal),
                6 => $this->inpcMesDePago(11, $factura->ejercicio_fiscal),
                default => null
            };

            if ((now()->month - 1) == 0){ //Caso Enero

                $inpc_mes_anterior_de_pago = $this->inpcMesDePago(12, (now()->year - 1));

            }else{ //Resto de los meses

                $inpc_mes_anterior_de_pago = $this->inpcMesDePago((now()->month - 1), now()->year);

            }

            $impuesto_facturado = $impuesto_facturado + $factura->total;

            $actualizacion = $actualizacion + ((($inpc_mes_anterior_de_pago / $inpc_mes_antiguo_periodo_pago) * $factura->total) - $factura->total);

            $mesesvencidos = ((12 - ($factura->bimestre * 2 )) + ((now()->year - 1) - $factura->ejercicio_fiscal) * 12 ) + now()->month;

            $recargos = $recargos + ($factura->total + ((($inpc_mes_anterior_de_pago / $inpc_mes_antiguo_periodo_pago) * $factura->total) - $factura->total)) * (2 * ($mesesvencidos / 100));

        }

        $multa = $facturas->count() * $this->uma->diario;

        $subtotal = round($impuesto_facturado) + round($actualizacion) + round($recargos) + round($multa);

        if($this->requerimiento && $this->requerimiento->año >= $factura->ejercicio_fiscal){

            $requerimiento = $subtotal * 0.03;

            if($requerimiento < $this->uma->diario){

                $requerimiento = $this->uma->diario;

            }

            $subtotal = $subtotal + round($requerimiento);

        }

        return [
            'ejercicio_fiscal' => $factura->ejercicio_fiscal,
            'impuesto' => $impuesto_facturado,
            'actualizacion' => round($actualizacion),
            'recargos'=> round($recargos),
            'multas'=> round($multa),
            'requerimientos'=> round($requerimiento),
            'subtotal'=> $subtotal
        ];

    }

}