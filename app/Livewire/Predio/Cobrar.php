<?php

namespace App\Livewire\Predio;

use Livewire\Component;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;
use App\Models\Pago;
use App\Models\PagoDetalle;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Models\Predio;
use GuzzleHttp\Psr7\Request;
use NumberFormatter;

class Cobrar extends Component
{
    public $entrego;
    public $totalapagar;
    public $cambio;
    public $rezago;
    public $rfacturas;
    public $cuentacorriente;
    public $tipocuota;
    public $predio;
    Public $ds;
    public $folio_recibo;
    public $total_imp = 0;
    public $total_act = 0;
    public $total_rec = 0;
    public $total_mul = 0;
    public $total_req = 0;
    public $total_app = 0;
    public $total_tot = 0;
    public $periodocc = "";
    public $periodorz = "";

    public function crear_pago_y_actualiza_facturas($bimestres,$anios,$pago){

        //dd($bimestres,$anios);
        $this->folio_recibo = $this->calcularFolio();

        $pagos = Pago::create([
            'predio_id' => $this->predio->id,
            'status' => 'PAGADO',
            'tipo' => 'VENTANILLA',
            'folio_recibo' => $this->folio_recibo,
            'fecha_pago' => Carbon::now(),
            'cajero' => auth()->user()->id,
            'linea_captura' => '',
            'total' => $pago,
            'mensaje' => '',
            'autorizacion' => '',
            'mediopago' => 'EFECTIVO',
            'creado_por' => auth()->user()->id
        ]);

        if ($bimestres === 0 && $anios === 0){ //Todo el adeudo cc + rezagos
            DB::table('facturas')
                ->where('predio_id',$this->predio->id)
                ->whereIn('status',['FACTURADO','REZAGO'])
                ->update(['status' => 'PAGADO','pago_id'=>$pagos->id]);
        }
        else{
            if ($anios > 0){
                DB::table('facturas')
                ->where('predio_id',$this->predio->id)
                ->where('status',['REZAGO'])
                ->where('ejercicio_fiscal','<=',$anios)
                ->update(['status' => 'PAGADO','pago_id'=>$pagos->id]);
            }

            if ($bimestres > 0){
                DB::table('facturas')
                ->where('predio_id',$this->predio->id)
                ->where('status',['FACTURADO'])
                ->where('ejercicio_fiscal',Carbon::now()->year)
                ->where('bimestre','<=',$bimestres)
                ->update(['status' => 'PAGADO','pago_id'=>$pagos->id]);
            }



        }


        $this->generaDetallePago($pagos->id,$bimestres,$anios);
    }



    public function cobrar(){
        //dd($this->cuentacorriente,$this->rezago);




        if ($this->entrego === null){
            $this->dispatch('mostrarMensaje', ['error', "Favor de especificar el monto que entrego"]);
            return;
        }

        if ($this->entrego <= 0){
            $this->dispatch('mostrarMensaje', ['error', "El pago no puede ser negativo o igual a cero"]);
            return;
        }

        if ($this->totalapagar <= 0){
            $this->dispatch('mostrarMensaje', ['error', "El monto a pagar no puede ser negativo o igual a cero"]);
            return;
        }


        try{
            //iniciar el cobro por el adeudo más antiguo

                if ($this->entrego >= $this->totalapagar){ //Se cobra la totalidad de cuenta corriente + rezago

                    //Cobrar todo el adeudo cuenta corriente + rezagos
                    //Alta en pagos y actualizar status en facturas
                    DB::transaction(function () {


                        $c_rezago = collect($this->rezago)->flatten(1); //Aplastamos el arreglo (sacando el nivel interno)
                        $c_cc = collect($this->cuentacorriente)->flatten(1);

                        $this->crear_pago_y_actualiza_facturas($c_cc->max('id'),$c_rezago->min('id'),$this->totalapagar);


                    });

                        //dd($this->total_imp,$this->total_act,$this->total_rec,$this->total_mul,$this->total_req,$this->total_tot,);

                        //$this->crear_pago_y_actualiza_facturas($bimestre,$anio,$montopagar);
                        //$this->cambio = $this->entrego - $montopagar;
                        $this->cambio = $this->entrego - $this->totalapagar;
                        $this->generarPDF();

                        ///////////////////////////$this->dispatch('mostrarMensaje', ['success', "El cobro del adeudo se realizó con éxito"]);

                        ///////////////////////////redirect()->route('predio_cobro',['predio'=> $this->predio->id,'tipocuota'=>$this->tipocuota]);
                        //Redireccionar al Detalle

                }else{
                    $anio=0;
                    $bimestre=0;
                    $montopagar=0;
                    $resto = $this->entrego;
                    $pos = count($this->rezago);
                    if ($this->rezago){
                        foreach (array_reverse($this->rezago) as $item){
                            if ($resto >= (float) str_replace(",","",$item[0]['subtotal'])){
                                $resto -= (float) str_replace(",","",$item[0]['subtotal']);
                                $montopagar += (float) str_replace(",","",$item[0]['subtotal']);
                                $pos--;
                                $anio = $item[0]['id'];

                            }

                            else
                                break;

                        }

                        if ($pos === count($this->rezago)){
                            $this->dispatch('mostrarMensaje', ['error', "El monto entregado no cubre nada del adeudo"]);
                            return;
                        }
                        else{


                            if ($pos === 0){ //Cubre todo el rezago
                                if ($this->tipocuota === "mínima"){
                                    $this->dispatch('mostrarMensaje', ['error', "Cuota mínima"]);
                                    //Aqui nunca va entrar ya que solo va a poder pagar el rezago
                                }
                                else
                                {

                                    //$this->dispatch('mostrarMensaje', ['error', "Cuota superior a mínima"]);


                                    foreach ($this->cuentacorriente as $item){

                                        if ($resto >= (float) $item[0]['subtotal']){

                                            $resto -= (float) $item[0]['subtotal'];
                                            $montopagar += (float) $item[0]['subtotal'];
                                            $bimestre++;
                                        }
                                        else
                                            break;

                                    }

                                }

                            }
                        }


                    }
                    else{
                        $this->dispatch('mostrarMensaje', ['error', "El monto entregado no cubre nada del adeudo"]);
                        return;
                    }

                    $this->crear_pago_y_actualiza_facturas($bimestre,$anio,$montopagar);
                    $this->cambio = $this->entrego - $montopagar;

                    $this->dispatch('mostrarMensaje', ['success', "El cobro parcial del aduedo se realizó con éxito"]);

                    //Genera PDF
                    $path = 'predial_F.pdf';
                    $pdf = $this->generarPDF();
                    return response()->streamDownload(
                        fn () => print($pdf->output()),
                        $path
                    );
                    //Fin de Genera PDF
                    //$this->generarPDF();



                    //dd($anio,$bimestre);

                    //Cobrar del predio bimestre <= $bimestre    rezago <= $anio


                    //////////////////////////////////////redirect()->route('predio_cobro',['predio'=> $this->predio->id,'tipocuota'=>$this->tipocuota]);

                }
            //}



            //Cobrando la totalidad del adeudo

        } catch (\Throwable $th) {
            Log::error("Error al crear cobro de impuesto predial por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);
        }



    }

    function importeconletra($numero)
    {
        $formatter = new NumberFormatter("es", NumberFormatter::SPELLOUT);

        // Separar parte entera y decimal
        $entero = floor($numero);
        $decimal = round(($numero - $entero) * 100);

        $texto = ucfirst($formatter->format($entero)) . " pesos";

        if ($decimal > 0) {
            $texto .= " con " . $decimal . "/100 M.N.";
        } else {
            $texto .= " 00/100 M.N.";
        }

        return $texto;
    }

    public function generarPDF()
    {

        //Obtener la informacion del predio desde el padrón de sacpi
        //$cuentapredial = explode("-",$this->cuenta_predial);
        $predio = Predio::where('localidad',$this->predio->localidad)
                        ->where('oficina',$this->predio->oficina)
                        ->where('tipo_predio',$this->predio->tipo_predio)
                        ->where('numero_registro',$this->predio->numero_registro)
                        ->first();

        //dd($predio);

        // Datos que quieres pasar a la vista
        $datos = [
            'foliorecibo' => Carbon::now()->format('Y').'-'.$this->folio_recibo.'-'.auth()->user()->id,
            'fechayhora' => Carbon::now()->format('d-m-Y H:i:s'),
            'contribuyente' => $predio->primerPropietario(),
            'cuenta_predial' => $predio->cuentaPredial(),
            'clave_catastral' => $predio->claveCatastral(),
            'valor_catastral' => $predio->valor_catastral,
            'ubicacion_predio' => $predio->Ubicacion(),
            'notificacion' => $predio->primerPropietarioDomicilio(),
            'impuesto' => $this->total_imp,
            'actualizacion' => $this->total_act,
            'multas' => $this->total_mul,
            'recargos' => $this->total_rec,
            'total' => $this->total_tot,
            'pago' => $this->entrego,
            'cambio' => $this->cambio,
            'periodopagocc' => $this->periodocc,
            'periodopagorz' => $this->periodorz,
            'importeletra' => $this->importeconletra($this->total_tot),

        ];

        //dd($datos);

        // Cargar la vista y pasarle los datos
        $pdf = Pdf::loadView('recibopredial', ['datos' => $datos]);



        return $pdf;
        //dd($path);


        /////////////////////////////Storage::disk('recibos')->put($path,$pdf->output());

        ////////////////////////////////////////////$pdf->render();
        ////////////////////////////////////////////return $pdf;

        //return $pdf->stream($path);



        //$path = storage_path('app/public/img/reporte.pdf');
        //$pdf->save($path);

        // Descargar el archivo
        //return $pdf->download('reporte.pdf');

        // O mostrarlo en el navegador
        //return $pdf->stream($path);
    }

    public function generaDetallePago($pago_id,$b,$a){
        //$bimestres

        if ($this->cuentacorriente){
            foreach ($this->cuentacorriente as $item){
                if ($item[0]['id'] <= $b){
                    $this->periodocc = $this->periodocc . $item[0]['concepto'] . ",";
                    PagoDetalle::create([
                        'pago_id' => $pago_id,
                        'ejercicio_fiscal' => Carbon::now()->year,
                        'tipo' => 'CUENTA CORRIENTE',
                        'concepto' => $item[0]['concepto'],
                        'impuesto' => $item[0]['impuesto'],
                        'actualizacion' => $item[0]['actualizacion'],
                        'recargos' => $item[0]['recargos'],
                        'multas' => $item[0]['multas'],
                        'requerimientos' => $item[0]['requerimientos'],
                        'subtotal' => $item[0]['subtotal'],
                        'creado_por' => auth()->user()->id
                    ]);
                    $this->total_imp += $item[0]['impuesto'];
                    $this->total_act += $item[0]['actualizacion'];
                    $this->total_rec += $item[0]['recargos'];
                    $this->total_mul += $item[0]['multas'];
                    $this->total_req += $item[0]['requerimientos'];
                }


            }

        }
        //$anios
        if ($this->rezago){

            foreach ($this->rezago as $item){
                if ($item[0]['id'] <= $a){
                    $this->periodorz =  $this->periodorz . $item[0]['id'] . ",";
                    PagoDetalle::create([
                        'pago_id' => $pago_id,
                        'ejercicio_fiscal' => $item[0]['id'],
                        'tipo' => 'REZAGO',
                        'concepto' => $item[0]['id'],
                        'impuesto' => (float) str_replace(",","",$item[0]['impuesto']),
                        'actualizacion' => (float) str_replace(",","",$item[0]['actualizacion']),
                        'recargos' => (float) str_replace(",","",$item[0]['recargos']),
                        'multas' => (float) str_replace(",","",$item[0]['multas']),
                        'requerimientos' => (float) str_replace(",","",$item[0]['requerimientos']),
                        'subtotal' => (float) str_replace(",","",$item[0]['subtotal']),
                        'creado_por' => auth()->user()->id
                    ]);
                    $this->total_imp += (float) str_replace(",","",$item[0]['impuesto']);
                    $this->total_act += (float) str_replace(",","",$item[0]['actualizacion']);
                    $this->total_rec += (float) str_replace(",","",$item[0]['recargos']);
                    $this->total_mul += (float) str_replace(",","",$item[0]['multas']);
                    $this->total_req += (float) str_replace(",","",$item[0]['requerimientos']);
                }

            }

        }
        $this->total_tot += $this->total_imp + $this->total_act + $this->total_rec + $this->total_mul + $this->total_req;
    }

    public function calcularFolio():int{

        $foliosiguiente = Pago::whereRaw('YEAR(fecha_pago) = ?',Carbon::now()->year)
                                ->where('cajero', auth()->user()->id)
                                ->max('folio_recibo');

        //dd($foliosiguiente);
        $foliosiguiente++;
        return $foliosiguiente;

    }

    public function descuento($id){



        foreach ($this->cuentacorriente as $item){
            $this->total_imp += $item[0]['impuesto'];
        }
        dd($this->total_imp);
    }


    public function render()
    {

        return view('livewire.predio.cobrar');
        //return view('livewire.predio.cobrar',compact('cambio'));
    }
}
