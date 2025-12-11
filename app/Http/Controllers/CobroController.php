<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Uma;
use App\Models\Valor;
use App\Models\Predio;
use App\Models\Factura;
use App\Models\Oficina;
use Illuminate\Http\Request;
use App\Models\ParametrosGenerale;
use Illuminate\Support\Facades\DB;

class CobroController extends Controller
{
    //
    public $cuentacorriente;
    public $rfacturas;
    public $totalapagar = 0;
    public $entrego;
    public $descu;

    public function __invoke(Predio $predio, $tipocuota){


        $predio->load('facturas','propietarios'); //facturas, rezago,requerimientos,pagos

        // $facturas = Factura::where('predio_id',$predio->id)
        //                     ->where('status','REZAGO')
        //                     ->groupBy('ejercicio_fiscal')
        //                     ->get();
        ////$facturas = DB::table('facturas')
        ////            ->select('ejercicio_fiscal', DB::raw('SUM(impuesto_facturado) as impuesto_facturado'))
        ////            ->where('predio_id',$predio->id)
        ////            ->where('status','REZAGO')
        ////            ->groupBy('ejercicio_fiscal')
        ////            ->get();
        //dd($facturas);
        $ccFacturas = Factura::where('predio_id',$predio->id)
                                ->where('ejercicio_fiscal',Carbon::now()->year)
                                ->where('status','FACTURADO')
                                ->get();

        if ($ccFacturas->count() == 0){
            $this->cuentacorriente[] = [];
            $this->rfacturas[] = [];
            return view('predio.cobro', [
                                    'predio' => $predio,
                                    'cuentacorriente' => $this->cuentacorriente,
                                    'rfacturas' => $this->rfacturas,
                                    'totalapagar' => $this->totalapagar,
                                    'tipocuota'=>$tipocuota
                                ]);
        }


        $actualizacion = 0;
        $recargos = 0;
        $multa = 0;

        $umaactual = Uma::where('año',Carbon::now()->year)->first();

        if ($tipocuota === "mínima"){// Todo en el primer bimestre
            $ccFacturas = $ccFacturas->first();
            //dd(Carbon::now()->month-1);
            if (Carbon::now()->month > 2){  //Calcular accesorios solo si ya se vencio el plazo

                $inpcmesantiguoperiodopago = $this->inpcMesDePago(1,Carbon::now()->year);

                $inpcmesanteriordepago = $this->inpcMesDePago(Carbon::now()->month-1,Carbon::now()->year);

                $actualizacion = round((($inpcmesanteriordepago/$inpcmesantiguoperiodopago)*$ccFacturas->impuesto_facturado) - $ccFacturas->impuesto_facturado);

                $mesesvencidos = Carbon::now()->month - 2;

                $recargos = round(($ccFacturas->impuesto_facturado + $actualizacion) * (2 * $mesesvencidos/100));

                $umaactual = Uma::where('año',Carbon::now()->year)->first();

                if ($predio->tipo_predio == 1){ //urbanos
                    $multa = round($umaactual->diario * 2);
                }else{ //rusticos
                    $multa = round($umaactual->diario * 1);
                }

                //Validar en la tabla de requerimientos si esta generado y notificado



            }

            $subtotal = $ccFacturas->impuesto_facturado + $actualizacion + $recargos + $multa;

            $this->totalapagar = $this->totalapagar + $subtotal;



            $this->cuentacorriente[] = [
                [
                    'id'=> 1,
                    'concepto' => $ccFacturas->ejercicio_fiscal, 
                    'impuesto' =>  number_format($ccFacturas->impuesto_facturado,4), 
                    'actualizacion'=>number_format($actualizacion,4), 
                    'recargos'=>number_format($recargos,4), 
                    'multas'=>number_format($multa,4), 
                    'requerimientos'=>0, 
                    'subtotal'=>number_format($subtotal,4)],
            ];

            $facturas = DB::table('facturas')
                    ->select('ejercicio_fiscal', DB::raw('SUM(impuesto_facturado) as impuesto_facturado'))
                    ->where('predio_id',$predio->id)
                    ->where('status','REZAGO')
                    ->groupBy('ejercicio_fiscal')
                    ->get();

        }else{ //Superior a mínima, en bimestre
            //$ccFacturas = $ccFacturas->get();


            //dd($ccFacturas);
            foreach($ccFacturas as $factura){

                $actualizacion = 0;
                $recargos = 0;
                $multa = 0;
                $subtotal = 0;


                if (Carbon::now()->month > 2){  //Calcular accesorios solo si ya se vencio el plazo


                    switch ($factura->bimestre){
                        case 1:
                            $inpcmesantiguoperiodopago = $this->inpcMesDePago(1,$factura->ejercicio_fiscal);
                            break;
                        case 2:
                            $inpcmesantiguoperiodopago = $this->inpcMesDePago(3,$factura->ejercicio_fiscal);
                            break;
                        case 3:
                            $inpcmesantiguoperiodopago = $this->inpcMesDePago(5,$factura->ejercicio_fiscal);
                            break;
                        case 4:
                            $inpcmesantiguoperiodopago = $this->inpcMesDePago(7,$factura->ejercicio_fiscal);
                            break;
                        case 5:
                            $inpcmesantiguoperiodopago = $this->inpcMesDePago(9,$factura->ejercicio_fiscal);
                            break;

                    }

                    $inpcmesanteriordepago = $this->inpcMesDePago(Carbon::now()->month-1,Carbon::now()->year);



                    switch (Carbon::now()->month){
                        case 3:
                        case 4:
                            if (in_array($factura->bimestre, [1])){ // Vencidos B 1
                                $actualizacion = round((($inpcmesanteriordepago/$inpcmesantiguoperiodopago)*$factura->total) - $factura->total);
                                $multa = round($umaactual->diario * 1);
                                $mesesvencidos = Carbon::now()->month - 2;
                                $recargos = $recargos + ($factura->total + ((($inpcmesanteriordepago/$inpcmesantiguoperiodopago) * $factura->total) - $factura->total)) * (2*$mesesvencidos/100);

                            }
                            break;
                        case 5:
                        case 6:
                            if (in_array($factura->bimestre, [1,2])){ // Vencidos B 1,2
                                $actualizacion = round((($inpcmesanteriordepago/$inpcmesantiguoperiodopago)*$factura->total) - $factura->total);
                                $multa = round($umaactual->diario * 1);
                                $mesesvencidos = (Carbon::now()->month - 4);
                                if (in_array($factura->bimestre, [1]))
                                    $mesesvencidos = $mesesvencidos + ($factura->bimestre * 2);
                                $recargos = $recargos + ($factura->total + ((($inpcmesanteriordepago/$inpcmesantiguoperiodopago) * $factura->total) - $factura->total)) * (2*$mesesvencidos/100);
                            }
                            break;
                        case 7:
                        case 8:
                            if (in_array($factura->bimestre, [1,2,3])){ // Vencidos B 1,2,3
                                $actualizacion = round((($inpcmesanteriordepago/$inpcmesantiguoperiodopago)*$factura->total) - $factura->total);
                                $multa = round($umaactual->diario * 1);
                                $mesesvencidos = Carbon::now()->month - 6;
                                if (in_array($factura->bimestre, [1,2]))
                                    $mesesvencidos = $mesesvencidos + ($factura->bimestre * 2);
                                $recargos = $recargos + ($factura->total + ((($inpcmesanteriordepago/$inpcmesantiguoperiodopago) * $factura->total) - $factura->total)) * (2*$mesesvencidos/100);
                            }
                            break;
                        case 9:
                        case 10:
                            if (in_array($factura->bimestre, [1,2,3,4])){ // Vencidos B 1,2,3,4
                                $actualizacion = round((($inpcmesanteriordepago/$inpcmesantiguoperiodopago)*$factura->total) - $factura->total);
                                $multa = round($umaactual->diario * 1);
                                $mesesvencidos = Carbon::now()->month - 8;
                                if (in_array($factura->bimestre, [1,2,3]))
                                    $mesesvencidos = $mesesvencidos + ($factura->bimestre * 2);
                                $recargos = $recargos + ($factura->total + ((($inpcmesanteriordepago/$inpcmesantiguoperiodopago) * $factura->total) - $factura->total)) * (2*$mesesvencidos/100);
                            }
                            break;
                        case 11:
                        case 12:
                            if (in_array($factura->bimestre, [1,2,3,4,5])){ // Vencidos B 1,2,3,4,5
                                $actualizacion = round((($inpcmesanteriordepago/$inpcmesantiguoperiodopago)*$factura->total) - $factura->total);
                                $multa = round($umaactual->diario * 1);
                                $mesesvencidos = Carbon::now()->month - 10;
                                if (in_array($factura->bimestre, [1,2,3,4]))
                                    $mesesvencidos = $mesesvencidos + ($factura->bimestre * 2);
                                $recargos = $recargos + ($factura->total + ((($inpcmesanteriordepago/$inpcmesantiguoperiodopago) * $factura->total) - $factura->total)) * (2*$mesesvencidos/100);
                            }
                            break;

                    }



                }

                $subtotal = $factura->total + $actualizacion + $recargos + $multa;
                //echo "Subtotal CC" . $subtotal . "<br>";
                $this->totalapagar = $this->totalapagar + $subtotal;

                //dd($this->totalapagar);

                $this->cuentacorriente[] = [
                    ['id'=> $factura->bimestre,'concepto' => 'Bimestre '.$factura->bimestre, 'impuesto' =>  round($factura->total), 'actualizacion'=>round($actualizacion), 'recargos'=>round($recargos), 'multas'=>round($multa), 'requerimientos'=>0, 'subtotal'=>round($subtotal)],
                ];
            }

            $facturas = DB::table('facturas')
                    ->select('id','ejercicio_fiscal', 'total','bimestre')
                    ->where('predio_id',$predio->id)
                    ->where('status','REZAGO')
                    ->orderBy('ejercicio_fiscal','desc')
                    ->orderBy('bimestre','desc')
                    ->get();



        }

        //Verificar si hay REZAGO para calcular los accesorios por cada ejercicio fiscal de rezago
        ////////////////////////////////////////////$umaactual = Uma::where('año',Carbon::now()->year)->first();
        if ($facturas->count() > 0){
            //dd($facturas);
            if ($tipocuota === "mínima"){
                foreach($facturas as $factura){
                    //dd($factura);
                    //echo "Facturado: " . $factura->total . "<br>";
                    $actualizacion = 0;
                    $recargos = 0;
                    $multa = 0;


                    $inpcmesantiguoperiodopago = $this->inpcMesDePago(1,$factura->ejercicio_fiscal);
                    if (Carbon::now()->month-1 == 0) //Caso Enero
                        $inpcmesanteriordepago = $this->inpcMesDePago(12,Carbon::now()->year-1);
                    else //Resto de los meses
                        $inpcmesanteriordepago = $this->inpcMesDePago(Carbon::now()->month-1,Carbon::now()->year);
                    $actualizacion = (($inpcmesanteriordepago/$inpcmesantiguoperiodopago)*$factura->total) - $factura->total;

                    $mesesvencidos = (((Carbon::now()->year - $factura->ejercicio_fiscal) * 12) - 2) + Carbon::now()->month;
                    $recargos = ($factura->total + $actualizacion) * (2*$mesesvencidos/100);

                    //echo "Recargos: " . $recargos . "<br>";
                    if ($predio->tipo_predio == 1){ //urbanos
                        $multa = $umaactual->diario * 2;
                    }else{ //rusticos
                        $multa = $umaactual->diario * 1;
                    }




                    $subtotal = round($factura->total) + round($actualizacion) + round($recargos) + round($multa);


                    $this->totalapagar = $this->totalapagar + $subtotal;

                    //Validar en la tabla de requerimientos si esta generado y notificado

                    $this->rfacturas[] = [
                        [
                            'id'=> $factura->ejercicio_fiscal,
                            'impuesto' => number_format(round($factura->total,0),4), 
                            'actualizacion' =>  number_format(round($actualizacion),4), 
                            'recargos'=>number_format(round($recargos),4), 
                            'multas'=>number_format(round($multa),4), 
                            'requerimientos'=>0, 
                            'subtotal'=>number_format(round($subtotal),4)
                        ],
                    ];
                }
            }
            else{ //CSM
                //$anio = Carbon::now()->year - 1;
                $bimestre = 6;
                $actualizacion = 0;
                $impuesto_facturado = 0;
                $recargos = 0;
                $bimestresvencidos = 0;
                $subtotal = 0;
                $lastRecord = $facturas->last();
                //dd($facturas);
                foreach($facturas as $factura){
                    //if ($anio == $factura->ejercicio_fiscal)
                    //{
                        //Por bimestre
                        //Acumulando actualización por Bimestre
                        switch ($factura->bimestre){
                            case 1:
                                $inpcmesantiguoperiodopago = $this->inpcMesDePago(1,$factura->ejercicio_fiscal);
                                break;
                            case 2:
                                $inpcmesantiguoperiodopago = $this->inpcMesDePago(3,$factura->ejercicio_fiscal);
                                break;
                            case 3:
                                $inpcmesantiguoperiodopago = $this->inpcMesDePago(5,$factura->ejercicio_fiscal);
                                break;
                            case 4:
                                $inpcmesantiguoperiodopago = $this->inpcMesDePago(7,$factura->ejercicio_fiscal);
                                break;
                            case 5:
                                $inpcmesantiguoperiodopago = $this->inpcMesDePago(9,$factura->ejercicio_fiscal);
                                break;
                            case 6:
                                $inpcmesantiguoperiodopago = $this->inpcMesDePago(11,$factura->ejercicio_fiscal);
                                break;
                        }


                        if (Carbon::now()->month - 1 == 0) //Caso Enero
                            $inpcmesanteriordepago = $this->inpcMesDePago(12,Carbon::now()->year-1);
                        else //Resto de los meses
                            $inpcmesanteriordepago = $this->inpcMesDePago(Carbon::now()->month-1,Carbon::now()->year);

                        $impuesto_facturado = $impuesto_facturado + $factura->total;

                        $actualizacion = $actualizacion + ((($inpcmesanteriordepago/$inpcmesantiguoperiodopago) * $factura->total) - $factura->total);

                        //echo "Bimestre ". $factura->bimestre ." INPC Antiguo periodo pago: " . $inpcmesantiguoperiodopago . " INPC Anterior pago: ". $inpcmesanteriordepago . "  Aact. ->" . $actualizacion . "<br>";

                        $mesesvencidos = ((12 - ($factura->bimestre * 2 )) + ((Carbon::now()->year - 1) - $factura->ejercicio_fiscal) * 12 ) + Carbon::now()->month;
                        $recargos = $recargos + ($factura->total + ((($inpcmesanteriordepago/$inpcmesantiguoperiodopago) * $factura->total) - $factura->total)) * (2*$mesesvencidos/100);

                        $bimestresvencidos++;

                        //echo "Bimestre: " . $factura->bimestre . "   Meses vencidos: " . $mesesvencidos. "<br>";

                        $bimestre = $bimestre - 1;



                        if ($bimestre == 0 || ($lastRecord->id === $factura->id)){
                            //echo "Ejercicio fiscal ". $factura->ejercicio_fiscal;
                            $multa = $bimestresvencidos * $umaactual->diario;

                            //echo "Recargos: " . $recargos . "<br>";
                            $subtotal = round($impuesto_facturado) + round($actualizacion) + round($recargos) + round($multa);
                            //echo "Subtotal RZ " . $subtotal . "<br>";
                            $this->totalapagar = $this->totalapagar + $subtotal;

                            $this->rfacturas[] = [
                                ['id'=> $factura->ejercicio_fiscal,'impuesto' => number_format(round($impuesto_facturado),4), 'actualizacion' =>  number_format(round($actualizacion),4), 'recargos'=>number_format(round($recargos),4), 'multas'=>number_format(round($multa),4), 'requerimientos'=>0, 'subtotal'=>number_format(round($subtotal),4)],
                            ];


                            $bimestre = 6;
                            $actualizacion = 0;
                            $impuesto_facturado = 0;
                            $recargos = 0;
                            $bimestresvencidos = 0;
                            $subtotal = 0;

                        }


                    //}


                }
                //dd($factura);
                //dd($anio,$actualizacion,$bimestre);


            }

            //dd($this->rfacturas);

        }
        else{
            $this->rfacturas[] = [];
        }


        $oficina = Oficina::with(['descuentos' => function ($query) {
            $query->wherePivot('estatus', 'ACTIVO');
        }])->findOrFail(53);

        $this->descu = $oficina->descuentos;

        //dd($descuentos[0]->porcentaje);

        // Factura::where('predio_id',$predio->id)
        //                         ->where('ejercicio_fiscal',Carbon::now()->year)
        //                         ->where('status','FACTURADO')
        //                         ->get();
        //dd($this->descu);

        return view('predio.cobro', ['predio' => $predio, 'cuentacorriente' => $this->cuentacorriente,'rfacturas' => $this->rfacturas,'totalapagar' => round($this->totalapagar,0),'tipocuota'=>$tipocuota,'descuentos'=>$this->descu]);

    }

    public function inpcMesDePago($mes, $ef){

        $pg = Valor::where('ejercicio_fiscal',$ef)->first();

        return match($mes){
            1 => $pg->inpc_enero,
            2 => $pg->inpc_febrero,
            3 => $pg->inpc_marzo,
            4 => $pg->inpc_abril,
            5 => $pg->inpc_mayo,
            6 => $pg->inpc_junio,
            7 => $pg->inpc_julio,
            8 => $pg->inpc_agosto,
            9 => $pg->inpc_septiembre,
            10 => $pg->inpc_octubre,
            11 => $pg->inpc_noviembre,
            12 => $pg->inpc_diciembre,
        };

    }

}
