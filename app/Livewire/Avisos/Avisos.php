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

    public function generarPDF(Predio $predio, $pago)
    {

        $formatter = new NumberFormatter("es", NumberFormatter::SPELLOUT);

        $total_letra = $formatter->format($this->total);

        $pdf = Pdf::loadView('reciboisai', [
            'pago' => $pago,
            'contribuyente' => $predio->primerPropietario(),
            'cuenta_predial' => $predio->cuentaPredial(),
            'clave_catastral' => $predio->claveCatastral(),
            'valor_catastral' => $predio->valor_catastral,
            'ubicacion_predio' => $predio->Ubicacion(),
            'notificacion' => $predio->primerPropietarioDomicilio(),
            'impuesto' => $this->aviso_seleccionado['isai'],
            'actualizacion' => $this->actualizacion,
            'multas' => $this->multas,
            'recargos' => $this->recargos,
            'total' => $this->total,
            'total_letra' => $total_letra,
            'oficina' => auth()->user()->oficina
        ]);

        return $pdf;

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

    public function cobrar()
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

            $pago_isai = Pagosisai::create([
                'año' => now()->format('Y'),
                'folio' => (Pagosisai::where('año', now()->format('Y'))->where('usuario', auth()->user()->clave)->max('folio') ?? 0) + 1,
                'usuario' => auth()->user()->clave,
                'aviso_año' => $this->aviso_seleccionado['año'],
                'aviso_folio' => $this->aviso_seleccionado['folio'],
                'aviso_usuario' => $this->aviso_seleccionado['usuario'],
                'notaria' => $this->aviso_seleccionado['notaria_numero'],
                'isai' => $this->aviso_seleccionado['isai'],
                'actualizacion' => $this->actualizacion,
                'multas' => $this->multas,
                'recargos' => $this->recargos,
                'status' => 'pagado',
                'tipo' => 'ventanilla',
                'total' => $this->total,
                'creado_por' => auth()->user()->id
            ]);

            $pdf = $this->generarPDF($predio, $pago_isai);

            $this->modal = false;

            $this->dispatch('mostrarMensaje', ['success', "Pago realizado con éxito"]);

            return response()->streamDownload(
                fn () => print($pdf->output()),
                'pago_isai.pdf'
            );

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
            {"año":"2025","folio":"10","usuario":"34","estatus":"AUTORIZADO","localidad":"1","oficina":"101","tipo_predio":"1","numero_registro":"266208","notaria_numero":"12","fecha_reduccion":"2024-08-15","isai":15000},
            {"año":"2025","folio":"152","usuario":"94","estatus":"AUTORIZADO","localidad":"1","oficina":"101","tipo_predio":"1","numero_registro":"266209","notaria_numero":"4","fecha_reduccion":"2025-08-16","isai":20000},
            {"año":"2025","folio":"254","usuario":"121","estatus":"AUTORIZADO","localidad":"1","oficina":"101","tipo_predio":"1","numero_registro":"266210","notaria_numero":"7","fecha_reduccion":"2025-08-17","isai":18000},
            {"año":"2025","folio":"18","usuario":"5","estatus":"AUTORIZADO","localidad":"1","oficina":"101","tipo_predio":"1","numero_registro":"266208","notaria_numero":"22","fecha_reduccion":"2025-08-18","isai":0},
            {"año":"2025","folio":"100","usuario":"134","estatus":"AUTORIZADO","localidad":"1","oficina":"101","tipo_predio":"1","numero_registro":"266208","notaria_numero":"10","fecha_reduccion":"2025-08-19","isai":22000},
            {"año":"2025","folio":"254","usuario":"14","estatus":"AUTORIZADO","localidad":"1","oficina":"101","tipo_predio":"1","numero_registro":"266208","notaria_numero":"5","fecha_reduccion":"2025-08-20","isai":17500},
            {"año":"2025","folio":"123","usuario":"25","estatus":"AUTORIZADO","localidad":"1","oficina":"101","tipo_predio":"1","numero_registro":"266208","notaria_numero":"18","fecha_reduccion":"2025-08-21","isai":19500},
            {"año":"2025","folio":"478","usuario":"18","estatus":"AUTORIZADO","localidad":"1","oficina":"101","tipo_predio":"1","numero_registro":"266208","notaria_numero":"30","fecha_reduccion":"2025-08-22","isai":21000},
            {"año":"2025","folio":"21","usuario":"201","estatus":"AUTORIZADO","localidad":"1","oficina":"101","tipo_predio":"1","numero_registro":"266208","notaria_numero":"2","fecha_reduccion":"2025-08-23","isai":16000},
            {"año":"2025","folio":"1","usuario":"54","estatus":"AUTORIZADO","localidad":"1","oficina":"101","tipo_predio":"1","numero_registro":"266208","notaria_numero":"15","fecha_reduccion":"2025-08-24","isai":25000},
            {"año":"2025","folio":"10","usuario":"34","estatus":"AUTORIZADO","localidad":"1","oficina":"101","tipo_predio":"1","numero_registro":"266208","notaria_numero":"12","fecha_reduccion":"2024-08-15","isai":15000},
            {"año":"2025","folio":"152","usuario":"94","estatus":"AUTORIZADO","localidad":"1","oficina":"101","tipo_predio":"1","numero_registro":"266209","notaria_numero":"4","fecha_reduccion":"2025-08-16","isai":20000},
            {"año":"2025","folio":"254","usuario":"121","estatus":"AUTORIZADO","localidad":"1","oficina":"101","tipo_predio":"1","numero_registro":"266210","notaria_numero":"7","fecha_reduccion":"2025-08-17","isai":18000},
            {"año":"2025","folio":"18","usuario":"5","estatus":"AUTORIZADO","localidad":"1","oficina":"101","tipo_predio":"1","numero_registro":"266208","notaria_numero":"22","fecha_reduccion":"2025-08-18","isai":0},
            {"año":"2025","folio":"100","usuario":"134","estatus":"AUTORIZADO","localidad":"1","oficina":"101","tipo_predio":"1","numero_registro":"266208","notaria_numero":"10","fecha_reduccion":"2025-08-19","isai":22000},
            {"año":"2025","folio":"254","usuario":"14","estatus":"AUTORIZADO","localidad":"1","oficina":"101","tipo_predio":"1","numero_registro":"266208","notaria_numero":"5","fecha_reduccion":"2025-08-20","isai":17500},
            {"año":"2025","folio":"123","usuario":"25","estatus":"AUTORIZADO","localidad":"1","oficina":"101","tipo_predio":"1","numero_registro":"266208","notaria_numero":"18","fecha_reduccion":"2025-08-21","isai":19500},
            {"año":"2025","folio":"478","usuario":"18","estatus":"AUTORIZADO","localidad":"1","oficina":"101","tipo_predio":"1","numero_registro":"266208","notaria_numero":"30","fecha_reduccion":"2025-08-22","isai":21000},
            {"año":"2025","folio":"21","usuario":"201","estatus":"AUTORIZADO","localidad":"1","oficina":"101","tipo_predio":"1","numero_registro":"266208","notaria_numero":"2","fecha_reduccion":"2025-08-23","isai":16000},
            {"año":"2025","folio":"1","usuario":"54","estatus":"AUTORIZADO","localidad":"1","oficina":"101","tipo_predio":"1","numero_registro":"266208","notaria_numero":"15","fecha_reduccion":"2025-08-24","isai":25000}
        ]';

        $avisos = json_decode($json, true);

        return view('livewire.avisos.avisos', compact('avisos'))->extends('layouts.admin');

    }
}
