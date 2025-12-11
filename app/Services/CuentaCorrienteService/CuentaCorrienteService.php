<?php

namespace App\Services\CuentaCorrienteService;

use App\Models\Uma;
use App\Models\Predio;
use App\Models\Factura;
use App\Traits\IncpTrait;

class CuentaCorrienteService{

    use IncpTrait;

    public Uma $uma;
    public $requerimiento;

    public function __construct(public Predio $predio, public string $tipo_cuota)
    {

        $this->uma = Uma::where('año', now()->year)->first();

        $this->requerimiento = $this->predio->requerimientos()->whereNotNull('fecha_notificacion')->latest()->first();

    }

    public function construirCuentaCorriente():array
    {

        $cuenta_corriente = [];

        foreach ($this->predio->facturasEjercicioActual as $factura) {

            $data = $this->procesarFactura($factura);

            $cuenta_corriente [] = $data;

        }

        return $cuenta_corriente;

    }

    public function procesarFactura(Factura $factura):array
    {

        if($this->tipo_cuota == 'minima'){

            return $this->cuaotaMinimaCuentaCorriente($factura);

        }else{

            return $this->cuotaSuperiorCuentaCorriente($factura);

        }

    }

    public function cuaotaMinimaCuentaCorriente(Factura $factura):array
    {

        $actualizacion = 0;
        $recargos = 0;
        $multa = 0;
        $requerimiento = 0;

        if (now()->month > 2){

            $inpc_mes_antiguo_periodo_pago = $this->inpcMesDePago(1, now()->year);

            $inpc_mes_anterior_de_pago = $this->inpcMesDePago(now()->month - 1, now()->year);

            if($inpc_mes_antiguo_periodo_pago == 0){

                $actualizacion = 0;

            }else{

                $actualizacion = (($inpc_mes_anterior_de_pago / $inpc_mes_antiguo_periodo_pago) * $factura->total ) - $factura->total;

            }

            $meses_vencidos = now()->month - 2;

            $recargos = ($factura->total + $actualizacion) * (2 * ($meses_vencidos/100));

            if ($this->predio->tipo_predio == 1){

                $multa = $this->uma->diario * 2;

            }else{

                $multa = $this->uma->diario * 1;

            }

            $subtotal = round($factura->total) + round($actualizacion) + round($recargos) + round($multa);

            if($this->requerimiento && $this->requerimiento->año == $factura->ejercicio_fiscal){

                $requerimiento = $subtotal * 0.03;

                if($requerimiento < $this->uma->diario){

                    $requerimiento = $this->uma->diario;

                }

                $subtotal = $subtotal + round($requerimiento);

            }

        }

        return [
            'ejercicio_fiscal' => $factura->ejercicio_fiscal,
            'bimestre' => $factura->bimestre,
            'impuesto' => round($factura->total),
            'actualizacion' => round($actualizacion),
            'recargos' => round($recargos),
            'multas' => round($multa),
            'requerimientos' => round($requerimiento),
            'subtotal' => $subtotal
        ];

    }

    public function cuotaSuperiorCuentaCorriente(Factura $factura):array
    {

        $actualizacion = 0;
        $recargos = 0;
        $multa = 0;
        $subtotal = 0;
        $requerimiento = 0;

        if (now()->month > 2){

            $inpc_mes_antiguo_periodo_pago = match($factura->bimestre){
                1 => $this->inpcMesDePago(1, $factura->ejercicio_fiscal),
                2 => $this->inpcMesDePago(3, $factura->ejercicio_fiscal),
                3 => $this->inpcMesDePago(5, $factura->ejercicio_fiscal),
                4 => $this->inpcMesDePago(7, $factura->ejercicio_fiscal),
                5 => $this->inpcMesDePago(9, $factura->ejercicio_fiscal),
                6 => $this->inpcMesDePago(11, $factura->ejercicio_fiscal),
                default => null
            };

            $inpc_mes_anterior_de_pago = $this->inpcMesDePago(now()->month - 1, now()->year);

            switch (now()->month){
                case 3:
                case 4:
                    if ($factura->bimestre === 1){ // Vencidos Bimestre 1

                        $actualizacion = (($inpc_mes_anterior_de_pago / $inpc_mes_antiguo_periodo_pago) * $factura->total) - $factura->total;

                        $multa = $this->uma->diario;

                        $meses_vencidos = now()->month - 2;

                        $recargos = $recargos + ($factura->total + ((($inpc_mes_anterior_de_pago / $inpc_mes_antiguo_periodo_pago) * $factura->total) - $factura->total)) * (2 * ($meses_vencidos / 100));

                    }
                    break;
                case 5:
                case 6:
                    if (in_array($factura->bimestre, [1, 2])){ // Vencidos B 1,2

                        $actualizacion = (($inpc_mes_anterior_de_pago / $inpc_mes_antiguo_periodo_pago) * $factura->total) - $factura->total;

                        $multa = $this->uma->diario;

                        $meses_vencidos = now()->month - 4;

                        if ($factura->bimestre == 1){

                            $meses_vencidos = $meses_vencidos + ($factura->bimestre * 2);

                        }

                        $recargos = $recargos + ($factura->total + ((($inpc_mes_anterior_de_pago / $inpc_mes_antiguo_periodo_pago) * $factura->total) - $factura->total)) * (2 * ($meses_vencidos / 100));

                    }
                    break;
                case 7:
                case 8:
                    if (in_array($factura->bimestre, [1, 2, 3])){ // Vencidos B 1,2,3

                        $actualizacion = (($inpc_mes_anterior_de_pago / $inpc_mes_antiguo_periodo_pago) * $factura->total) - $factura->total;

                        $multa = $this->uma->diario;

                        $meses_vencidos = now()->month - 6;

                        if (in_array($factura->bimestre, [1,2])){

                            $meses_vencidos = $meses_vencidos + ($factura->bimestre * 2);

                        }

                        $recargos = $recargos + ($factura->total + ((($inpc_mes_anterior_de_pago / $inpc_mes_antiguo_periodo_pago) * $factura->total) - $factura->total)) * (2 * ($meses_vencidos / 100));

                    }
                    break;
                case 9:
                case 10:
                    if (in_array($factura->bimestre, [1, 2, 3, 4])){ // Vencidos B 1,2,3,4

                        $actualizacion = (($inpc_mes_anterior_de_pago / $inpc_mes_antiguo_periodo_pago) * $factura->total) - $factura->total;

                        $multa = $this->uma->diario;

                        $meses_vencidos = now()->month - 8;

                        if (in_array($factura->bimestre, [1, 2, 3])){

                            $meses_vencidos = $meses_vencidos + ($factura->bimestre * 2);

                        }

                        $recargos = $recargos + ($factura->total + ((($inpc_mes_anterior_de_pago / $inpc_mes_antiguo_periodo_pago) * $factura->total) - $factura->total)) * (2 * ($meses_vencidos / 100));

                    }
                    break;
                case 11:
                case 12:
                    if (in_array($factura->bimestre, [1, 2, 3, 4, 5])){ // Vencidos B 1,2,3,4,5

                        $actualizacion = (($inpc_mes_anterior_de_pago / $inpc_mes_antiguo_periodo_pago) * $factura->total) - $factura->total;

                        $multa = $this->uma->diario;

                        $meses_vencidos = now()->month - 10;

                        if (in_array($factura->bimestre, [1, 2, 3, 4])){

                            $meses_vencidos = $meses_vencidos + ($factura->bimestre * 2);

                        }

                        $recargos = $recargos + ($factura->total + ((($inpc_mes_anterior_de_pago / $inpc_mes_antiguo_periodo_pago) * $factura->total) - $factura->total)) * (2 * ($meses_vencidos / 100));
                    }
                    break;

            }

            $subtotal = round($factura->total) + round($actualizacion) + round($recargos) + round($multa);

            if($this->requerimiento && $this->requerimiento->año == $factura->ejercicio_fiscal){

                $requerimiento = $subtotal * 0.03;

                if($requerimiento < $this->uma->diario){

                    $requerimiento = $this->uma->diario;

                }

                $subtotal = $subtotal + round($requerimiento);

            }

        }

        return [
            'ejercicio_fiscal' => $factura->ejercicio_fiscal,
            'bimestre' => $factura->bimestre,
            'impuesto' => round($factura->total),
            'actualizacion' => round($actualizacion),
            'recargos' => round($recargos),
            'multas' => round($multa),
            'requerimientos' => round($requerimiento),
            'subtotal' => $subtotal
        ];

    }

}