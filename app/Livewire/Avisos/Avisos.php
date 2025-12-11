<?php

namespace App\Livewire\Avisos;

use App\Models\Pagosisai;
use App\Models\Predio;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Uma;
use App\Traits\IncpTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use NumberFormatter;


class Avisos extends Component
{

    use WithPagination;
    use IncpTrait;

    public $folio_aviso;
    public $folio_recibo;
    public $cuenta_predial;

    public $sin_multa = false;
    public $sin_recargo = false;

    public $paginaActual = 1;
    public $paginaAnterior;
    public $paginaSiguiente;
    public $pagination = 10;
    public $aviso_seleccionado;
    public $fecha_reduccion;
    public $fecha_limite_pago;
    public $fecha_presentacion;
    public $multas;
    public $recargos;
    public $actualizacion;
    public $total;
    public $tasa_recargos_isai;

    public $modal = false;

    public function nextPage(){ (int)$this->paginaActual++; $this->dispatch('gotoTop'); }

    public function previousPage(){ (int)$this->paginaActual--; $this->dispatch('gotoTop'); }

    public function updatedSinMulta(){

        $this->calcularAccesorios($this->aviso_seleccionado['isai']);

    }

    public function updatedSinRecargo(){

        $this->calcularAccesorios($this->aviso_seleccionado['isai']);

    }

    public function generarPDF()
    {
        //Obtener la informacion del predio desde el padrón de sacpi
        $cuentapredial = explode("-",$this->cuenta_predial);
        $predio = Predio::where('localidad',$cuentapredial[0])
                        ->where('oficina',$cuentapredial[1])
                        ->where('tipo_predio',$cuentapredial[2])
                        ->where('numero_registro',$cuentapredial[3])
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
            'impuesto' => $this->isai_a_pagar,
            'actualizacion' => $this->actualizacion,
            'multas' => $this->multas,
            'recargos' => $this->recargos,
            'total' => $this->total,
            'importeletra' => $this->importeconletra($this->total),

        ];

        //dd($datos);

        // Cargar la vista y pasarle los datos
        $pdf = Pdf::loadView('reciboisai', ['datos' => $datos]);

        $path = 'isai_F'.$this->folio_aviso.'_'.Carbon::now()->format('dmY_His').'.pdf';

        //dd($path);


        Storage::disk('recibos')->put($path,$pdf->output());

        //$pdf->render();

        //$path = storage_path('app/public/img/reporte.pdf');
        //$pdf->save($path);

        // Descargar el archivo
        //return $pdf->download('reporte.pdf');

        // O mostrarlo en el navegador
        //return $pdf->stream($path);
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

    public function abrirModalCobrar($aviso):void
    {

        $this->aviso_seleccionado = $aviso;

        $this->calcularFechas($this->aviso_seleccionado['fecha_reduccion']);

        $this->calcularAccesorios($this->aviso_seleccionado['isai']);

        $this->modal = true;

    }

    public function calcularAccesorios($isai) : Void
    {

        $this->total = $isai;
        $this->multas = 0;
        $this->recargos = 0;

        if (Carbon::parse($this->fecha_presentacion) > Carbon::parse($this->fecha_limite_pago)){

            $uma_actual = Uma::where('año', now()->year)->first();

            if (!$this->sin_multa) $this->multas = round($uma_actual->diario * 4);

            $fecha_limite_pago = Carbon::parse($this->fecha_limite_pago);

            $meses_vencidos = (int)$fecha_limite_pago->diffInMonths(now());

            $inpc_fecha_pago = $this->inpcMesDePago($fecha_limite_pago->month, $fecha_limite_pago->year);

            $inpc_fecha_actual = $this->inpcMesDePago(now()->month, now()->year);

            $this->actualizacion = round((($inpc_fecha_actual / $inpc_fecha_pago) * $isai) - $isai);

            if (!$this->sin_recargo) $this->recargos = round(($isai + $this->actualizacion) * ($this->tasa_recargos_isai * ($meses_vencidos / 100)));

            $this->total = round($isai + $this->multas + $this->recargos);

        }

    }

    public function cobrar_isai():void
    {


        $predio = Predio::where('localidad', $this->aviso_seleccionado['localidad'])
                        ->where('oficina', $this->aviso_seleccionado['oficina'])
                        ->where('tipo_predio', $this->aviso_seleccionado['tipo_predio'])
                        ->where('numero_registro', $this->aviso_seleccionado['numero_registro'])
                        ->first();

        if (!$predio){

            $this->dispatch('mostrarMensaje', ['warning', "La cuenta predial no existe en el padrón municipal, no es posible realizar el cobro"]);

            return;
        }

        try{

            $this->folio_recibo = $this->calcularFolio();

            /* $pagoisai = Pagosisai::create([
                'año' => now()->format('Y'),
                'folio' => ,
                'usuario' => auth()->user()->clave,
                'notaria' => $this->aviso_seleccionado['notaria'],
                'isai' => $this->aviso_seleccionado['isai'],
                'actualizacion' => $this->actualizacion,
                'multas' => $this->multas,
                'recargos' => $this->recargos,
                'status' => 'pagado',
                'tipo' => 'ventanilla',
                'total' => $this->total,
                'creado_por' => auth()->user()->id
            ]); */

            $this->generarPDF();

            $this->modal = false;
            $this->dispatch('mostrarMensaje', ['success', "Pago realizado con éxito"]);



        } catch (\Throwable $th) {

            Log::error("Error al generar el pago del ISAI por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th->getMessage());
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function calcularFechas($fecha_reduccion):void
    {

        $this->fecha_reduccion = Carbon::parse($fecha_reduccion)->format('Y-m-d');
        $this->fecha_limite_pago = Carbon::parse($fecha_reduccion)->addWeekdays(15)->format('Y-m-d');
        $this->fecha_presentacion = Carbon::today()->format('Y-m-d');

    }

    public function mount(){

        $this->tasa_recargos_isai = auth()->user()->oficina->parametros->where('ejercicio_fiscal', now()->year)->first()->tasa_recargos_isai;

    }

    public function render()
    {


        $json = '[
            {"folio":"2025-10-34","estatus":"AUTORIZADO","cuenta_predial":"1-101-1-266208","notaria":"Notaría 12","fecha_reduccion":"2024-08-15","isai":15000},
            {"folio":"2025-152-94","estatus":"AUTORIZADO","cuenta_predial":"1-101-1-266209","notaria":"Notaría 4","fecha_reduccion":"2025-08-16","isai":20000},
            {"folio":"2025-254-121","estatus":"AUTORIZADO","cuenta_predial":"1-101-1-266210","notaria":"Notaría 7","fecha_reduccion":"2025-08-17","isai":18000},
            {"folio":"2025-18-5","estatus":"AUTORIZADO","cuenta_predial":"1-101-1-266208","notaria":"Notaría 22","fecha_reduccion":"2025-08-18","isai":0},
            {"folio":"2025-100-134","estatus":"AUTORIZADO","cuenta_predial":"1-101-1-266208","notaria":"Notaría 10","fecha_reduccion":"2025-08-19","isai":22000},
            {"folio":"2025-254-14","estatus":"AUTORIZADO","cuenta_predial":"1-101-1-266208","notaria":"Notaría 5","fecha_reduccion":"2025-08-20","isai":17500},
            {"folio":"2025-123-25","estatus":"AUTORIZADO","cuenta_predial":"1-101-1-266208","notaria":"Notaría 18","fecha_reduccion":"2025-08-21","isai":19500},
            {"folio":"2025-478-18","estatus":"AUTORIZADO","cuenta_predial":"1-101-1-266208","notaria":"Notaría 30","fecha_reduccion":"2025-08-22","isai":21000},
            {"folio":"2025-21-201","estatus":"AUTORIZADO","cuenta_predial":"1-101-1-266208","notaria":"Notaría 2","fecha_reduccion":"2025-08-23","isai":16000},
            {"folio":"2025-1-54","estatus":"AUTORIZADO","cuenta_predial":"1-101-1-266208","notaria":"Notaría 15","fecha_reduccion":"2025-08-24","isai":25000},
            {"folio":"2025-10-34","estatus":"AUTORIZADO","cuenta_predial":"1-101-1-266208","notaria":"Notaría 12","fecha_reduccion":"2024-08-15","isai":15000},
            {"folio":"2025-152-94","estatus":"AUTORIZADO","cuenta_predial":"1-101-1-266209","notaria":"Notaría 4","fecha_reduccion":"2025-08-16","isai":20000},
            {"folio":"2025-254-121","estatus":"AUTORIZADO","cuenta_predial":"1-101-1-266210","notaria":"Notaría 7","fecha_reduccion":"2025-08-17","isai":18000},
            {"folio":"2025-18-5","estatus":"AUTORIZADO","cuenta_predial":"1-101-1-266208","notaria":"Notaría 22","fecha_reduccion":"2025-08-18","isai":0},
            {"folio":"2025-100-134","estatus":"AUTORIZADO","cuenta_predial":"1-101-1-266208","notaria":"Notaría 10","fecha_reduccion":"2025-08-19","isai":22000},
            {"folio":"2025-254-14","estatus":"AUTORIZADO","cuenta_predial":"1-101-1-266208","notaria":"Notaría 5","fecha_reduccion":"2025-08-20","isai":17500},
            {"folio":"2025-123-25","estatus":"AUTORIZADO","cuenta_predial":"1-101-1-266208","notaria":"Notaría 18","fecha_reduccion":"2025-08-21","isai":19500},
            {"folio":"2025-478-18","estatus":"AUTORIZADO","cuenta_predial":"1-101-1-266208","notaria":"Notaría 30","fecha_reduccion":"2025-08-22","isai":21000},
            {"folio":"2025-21-201","estatus":"AUTORIZADO","cuenta_predial":"1-101-1-266208","notaria":"Notaría 2","fecha_reduccion":"2025-08-23","isai":16000},
            {"folio":"2025-1-54","estatus":"AUTORIZADO","cuenta_predial":"1-101-1-266208","notaria":"Notaría 15","fecha_reduccion":"2025-08-24","isai":25000}
        ]';

        $avisos = json_decode($json, true);

        return view('livewire.avisos.avisos', compact('avisos'))->extends('layouts.admin');

    }
}
