<?php

namespace App\Livewire\Cobros\Predial;

use App\Models\Uma;
use App\Models\Pago;
use NumberFormatter;
use App\Models\Predio;
use App\Models\Factura;
use Livewire\Component;
use App\Models\Descuento;
use App\Models\Parametro;
use App\Traits\IncpTrait;
use App\Models\PagoDetalle;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Services\CuotaService\CuotaService;
use App\Services\RezagoService\RezagoService;
use App\Services\CuentaCorrienteService\CuentaCorrienteService;

class Predial extends Component
{

    use IncpTrait;

    public $predio;

    public $tipo_couta;
    public $tasa;
    public $uma;
    public $subtotal;
    public $total_a_pagar;
    public $descuento;
    public $descuentos = [];
    public $cuenta_corriente = [];
    public $rezagos = [];
    public $ejercicio_fiscal;
    public $descuentos_tipos;
    public $descuento_tipo;
    public $descuentos_accesorios;
    public $descuento_accesorio;
    public $descuentos_porcentaje;
    public $descuento_porcentaje;

    public $localidad;
    public $oficina;
    public $tipo_predio;
    public $numero_registro;

    public $dinero_recibido;
    public $cambio;
    public $pago;

    public $rezago_años = [];
    public $rezago_impuesto;
    public $cuenta_corriente_impuesto;
    public $cuenta_corriente_recargos;
    public $cuenta_corriente_multas;
    public $cuenta_corriente_reqerimientos;
    public $cuenta_corriente_subtotal;

    protected function rules(){
        return [
            'localidad' => 'required|numeric',
            'oficina' => 'required|numeric',
            'tipo_predio' => 'required|numeric|in:1,2,3,4',
            'numero_registro' => 'required|numeric',
         ];
    }

    protected $validationAttributes  = [
        'dinero_recibido' => 'recibido',

    ];

    public function updatedDineroRecibido(){

        $this->calcularTotal();

    }

    public function calcularTotal(){

        $this->subtotal = (collect($this->cuenta_corriente)->sum('subtotal') + collect($this->rezagos)->sum('subtotal'));

        $total_descuentos = collect($this->descuentos)->sum('monto');

        $this->total_a_pagar = round($this->subtotal - $total_descuentos);

        $this->cambio = ($this->dinero_recibido - $this->total_a_pagar) > 0 ? ($this->dinero_recibido - $this->total_a_pagar) : 0;

    }

    public function agregarDescuento(){

        $this->validate([
            'descuento_tipo' => 'required',
            'descuento_accesorio' => 'required',
            'descuento_porcentaje' => 'required',
        ]);

        if($this->descuento_tipo == 'ambos'){

            $descuento = match($this->descuento_accesorio){
                'impuesto' => $this->calcularDescuento('impuesto', $this->descuento_porcentaje),
                'recargos' => $this->calcularDescuento('recargos', $this->descuento_porcentaje),
                'multas' => $this->calcularDescuento('multas', $this->descuento_porcentaje),
                'todos' => $this->calcularDescuento('subtotal', $this->descuento_porcentaje),
            };

        }elseif($this->descuento_tipo == 'cuenta corriente'){

            $descuento = match($this->descuento_accesorio){
                'impuesto' => $this->calcularDescuento('impuesto', $this->descuento_porcentaje),
                'recargos' => $this->calcularDescuento('recargos', $this->descuento_porcentaje),
                'multas' => $this->calcularDescuento('multas', $this->descuento_porcentaje),
                'todos' => $this->calcularDescuento('subtotal', $this->descuento_porcentaje),
            };

        }elseif($this->descuento_tipo == 'rezago'){

            $descuento = match($this->descuento_accesorio){
                'impuesto' => $this->calcularDescuento('impuesto', $this->descuento_porcentaje),
                'recargos' => $this->calcularDescuento('recargos', $this->descuento_porcentaje),
                'multas' => $this->calcularDescuento('multas', $this->descuento_porcentaje),
                'todos' => $this->calcularDescuento('subtotal', $this->descuento_porcentaje),
            };

        }

        array_push(
                    $this->descuentos,
                    [
                        'tipo' => $this->descuento_tipo,
                        'accesorio' => $this->descuento_accesorio,
                        'porcentaje' =>$this->descuento_porcentaje,
                        'monto' => $descuento
                    ]
                );

        $this->calcularTotal();

    }

    public function eliminarDescuento($index){

        $this->removerDescuento($this->descuentos[$index]);

        unset($this->descuentos[$index]);

        $this->calcularTotal();

    }

    public function removerDescuento($descuento){

        if($this->rezagos){

            $rezagos_provicional = $this->rezagos = (new RezagoService($this->predio, $this->tipo_couta))->construirRezagos(['rezago']);

            foreach ($this->rezagos as $key => $rezago) {

                $this->rezagos[$key][$descuento['accesorio']] = $rezagos_provicional[$key][$descuento['accesorio']];

            }

        }

        $cuenta_corriente_provicional = (new CuentaCorrienteService($this->predio, $this->tipo_couta))->construirCuentaCorriente();

        foreach ($this->cuenta_corriente as $key => $cuenta) {

            $this->cuenta_corriente[$key][$descuento['accesorio']] = $cuenta_corriente_provicional[$key][$descuento['accesorio']];

        }

        $this->calcularSubtotales();

    }

    public function calcularDescuento($accesorio, $porcentaje){

        if($this->descuento_tipo == 'ambos'){

            $suma = (collect($this->cuenta_corriente)->sum($accesorio) + collect($this->rezagos)->sum($accesorio)) * ($porcentaje / 100);

            foreach ($this->cuenta_corriente as $key => $cuenta_corriente) {

                $this->cuenta_corriente[$key][$accesorio] = $this->cuenta_corriente[$key][$accesorio] - $cuenta_corriente[$accesorio] * ($porcentaje / 100);

            }

            foreach ($this->rezagos as $key => $rezago) {

                $this->rezagos[$key][$accesorio] = $this->rezagos[$key][$accesorio] - $rezago[$accesorio] * ($porcentaje / 100);

            }

            $this->calcularSubtotales();

            return $suma;

        }elseif($this->descuento_tipo == 'cuenta corriente'){

            $suma =  (collect($this->cuenta_corriente)->sum($accesorio)) * ($porcentaje / 100);

            foreach ($this->cuenta_corriente as $key => $cuenta_corriente) {

                $this->cuenta_corriente[$key][$accesorio] = $this->cuenta_corriente[$key][$accesorio] - $cuenta_corriente[$accesorio] * ($porcentaje / 100);

            }

            $this->calcularSubtotales();

            return $suma;

        }elseif($this->descuento_tipo == 'rezago'){

            $suma = (collect($this->rezagos)->sum($accesorio)) * ($porcentaje / 100);

            foreach ($this->rezagos as $key => $rezago) {

                $this->rezagos[$key][$accesorio] = $this->rezagos[$key][$accesorio] - $rezago[$accesorio] * ($porcentaje / 100);

            }

            $this->calcularSubtotales();

            return $suma;

        }

    }

    public function calcularSubtotales(){

        if($this->rezagos){

            foreach ($this->rezagos as $key => $rezago) {

                $this->rezagos[$key]['subtotal'] = (float)$rezago['impuesto'] + (float)$rezago['actualizacion'] + (float)$rezago['recargos'] + $rezago['multas'] + $rezago['requerimientos'];

            }

        }

        foreach ($this->cuenta_corriente as $key => $cuenta_corriente) {

            $this->cuenta_corriente[$key]['subtotal'] = (float)$cuenta_corriente['impuesto'] + (float)$cuenta_corriente['actualizacion'] + (float)$cuenta_corriente['recargos'] + $cuenta_corriente['multas'] + $cuenta_corriente['requerimientos'];

        }

        $this->calcularTotal();

    }

    public function buscarCuentaPredial(){

        $this->validate();

        $this->predio = Predio::where('localidad', $this->localidad)
                                ->where('oficina', $this->oficina)
                                ->where('tipo_predio', $this->tipo_predio)
                                ->where('numero_registro', $this->numero_registro)
                                ->first();

        if (!$this->predio){

            $this->dispatch('mostrarMensaje', ['warning', "El predio no existe."]);

            return;

        }

        $this->consultarTipoCuota();

    }

    public function consultarTipoCuota(){

        $data = (new CuotaService())->execute($this->ejercicio_fiscal, $this->predio->valor_catastral, $this->predio->anioFechaEfectos(), $this->predio->tipo_predio);

        $this->tipo_couta = $data['tipo_cuota'];

        $this->construirCuentaCorriente();

        $this->construirRezagos();

        $this->subtotal = (collect($this->cuenta_corriente)->sum('subtotal') + collect($this->rezagos)->sum('subtotal'));

    }

    public function construirCuentaCorriente(){

        $this->cuenta_corriente = (new CuentaCorrienteService($this->predio, $this->tipo_couta))->construirCuentaCorriente();

    }

    public function construirRezagos(){

        $this->rezagos = (new RezagoService($this->predio, $this->tipo_couta))->construirRezagos(['rezago']);

    }

    public function cobrar(){

        $this->validate([
            'dinero_recibido' => 'required|numeric|gt:0',
        ]);

        try {

            $this->validarMontoRecibido();

            $formatter = new NumberFormatter("es", NumberFormatter::SPELLOUT);

            $total_letra = $formatter->format($this->total_a_pagar);

            $pdf = Pdf::loadView('recibo_predial', [
                'pago' => $this->pago,
                'predio' => $this->predio,
                'tasa' => $this->tasa,
                'oficina' => auth()->user()->oficina,
                'cuota' => $this->tipo_couta,
                'rezago_años' => $this->rezago_años,
                'rezago_impuesto' => $this->rezago_impuesto,
                'cuenta_corriente_impuesto' => $this->cuenta_corriente_impuesto,
                'cuenta_corriente_recargos' => $this->cuenta_corriente_recargos,
                'cuenta_corriente_multas' => $this->cuenta_corriente_multas,
                'cuenta_corriente_reqerimientos' => $this->cuenta_corriente_reqerimientos,
                'total' => $this->total_a_pagar,
                'total_letra' => $total_letra,
                'descuentos' => collect($this->descuentos)->sum('monto')
            ]);

            $this->predio->refresh();

            $this->construirCuentaCorriente();

            $this->construirRezagos();

            $this->calcularTotal();

            $this->reset(['dinero_recibido']);

            $this->dispatch('mostrarMensaje', ['success', "El pago se generó con éxito."]);

            return response()->streamDownload(
                fn () => print($pdf->output()),
                'pago.pdf'
            );

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al cobrar predial por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function validarMontoRecibido(){

        if(count($this->cuenta_corriente)){

            $valor_minimo_a_cobrar_cuenta_corriente = (float)$this->cuenta_corriente[0]['subtotal'];

            $valor_minimo_a_cobrar = $valor_minimo_a_cobrar_cuenta_corriente;

        }

        if(count($this->rezagos)){

            $valor_minimo_a_cobrar = (float)$this->rezagos[array_key_first($this->rezagos)]['subtotal'];

        }

        if($this->dinero_recibido < $valor_minimo_a_cobrar){

            throw new GeneralException('Lo mínimo que puedes cobrar son: $' . round($valor_minimo_a_cobrar));

        }

        if($this->dinero_recibido >= $this->total_a_pagar){

            $this->generarPagoCompleto();

        }elseif($this->dinero_recibido >= $valor_minimo_a_cobrar){

            $suma = 0;

            if(count($this->rezagos)){

                /* Lo recibido es mayor a todo el rezago y es mayor que el primer bimestre de cuenta corriente */
                if($this->dinero_recibido >= collect($this->rezagos)->sum('subtotal') + $valor_minimo_a_cobrar_cuenta_corriente){

                    $bimestre = null;

                    $suma = collect($this->rezagos)->sum('subtotal');

                    foreach($this->cuenta_corriente as $cuenta){

                        $suma = $suma + (float)$cuenta['subtotal'];

                        $this->cuenta_corriente_impuesto = $this->cuenta_corriente_impuesto + $cuenta['impuesto'];
                        $this->cuenta_corriente_recargos = $this->cuenta_corriente_recargos + $cuenta['recargos'];
                        $this->cuenta_corriente_multas = $this->cuenta_corriente_multas + $cuenta['multas'];
                        $this->cuenta_corriente_reqerimientos = $this->cuenta_corriente_reqerimientos + $cuenta['requerimientos'];

                        if($suma >= $this->dinero_recibido) break;

                        $this->cuenta_corriente_subtotal = $this->cuenta_corriente_subtotal + (float)$cuenta['subtotal'];

                        $bimestre = $cuenta['bimestre'];

                    }

                    $this->rezago_impuesto = collect($this->rezagos)->sum('subtotal');

                    $this->cuenta_corriente_subtotal = $this->cuenta_corriente_subtotal + $this->rezago_impuesto;

                    $this->generarPagoCuentaCorriente($bimestre);

                /* Lo recibido solo cubre una parte del rezago */
                }else{

                    $año = null;

                    foreach($this->rezagos as $key_rezago => $rezago){

                        $suma = $suma + (float)$rezago['subtotal'];

                        array_push($this->rezago_años, $key_rezago);

                        if($suma >= $this->dinero_recibido) break;

                        $this->rezago_impuesto = $this->rezago_impuesto + (float)$rezago['subtotal'];

                        $año = $key_rezago;

                    }

                    $this->generarPagoRezago($año);

                }

            /* No hay rezago */
            }else{

                $bimestre = null;

                foreach($this->cuenta_corriente as  $cuenta){

                    $suma = $suma + (float)$cuenta['subtotal'];

                    $this->cuenta_corriente_impuesto = $this->cuenta_corriente_impuesto + $cuenta['impuesto'];
                    $this->cuenta_corriente_recargos = $this->cuenta_corriente_recargos + $cuenta['recargos'];
                    $this->cuenta_corriente_multas = $this->cuenta_corriente_multas + $cuenta['multas'];
                    $this->cuenta_corriente_reqerimientos = $this->cuenta_corriente_reqerimientos + $cuenta['requerimientos'];

                    if($suma >= $this->dinero_recibido) break;

                    $this->cuenta_corriente_subtotal = $this->cuenta_corriente_subtotal + (float)$cuenta['subtotal'];

                    $bimestre = $cuenta['bimestre'];

                }

                $this->generarPagoCuentaCorriente($bimestre);

            }

        }

    }

    public function generarPagoCompleto(){

        $this->cuenta_corriente_impuesto = collect($this->cuenta_corriente)->sum('impuesto');
        $this->cuenta_corriente_recargos = collect($this->cuenta_corriente)->sum('recargos');
        $this->cuenta_corriente_multas = collect($this->cuenta_corriente)->sum('multas');
        $this->cuenta_corriente_reqerimientos = collect($this->cuenta_corriente)->sum('requerimientos');

        if(count($this->rezagos)){

            $this->rezago_años = array_keys($this->rezagos);

            $this->rezago_impuesto = collect($this->rezagos)->sum('subtotal');

        }

        DB::transaction(function () {

            $this->pago = Pago::create([
                'medio_pago' => 'efectivo',
                'predio_id' => $this->predio->id,
                'status' => 'pagado',
                'tipo' => 'ventanilla',
                'folio' => (Pago::where('año', now()->format('Y'))->where('usuario', auth()->user()->clave)->max('folio') ?? 0) + 1,
                'año' => now()->format('Y'),
                'usuario' => auth()->user()->clave,
                'total' => $this->total_a_pagar,
                'fecha_pago' => now()->toDateString(),
                'creado_por' => auth()->id()
            ]);

            $this->procesarDescuentos($this->pago);

            foreach($this->rezagos as $key => $rezago){

                PagoDetalle::create([
                    'pago_id' => $this->pago->id,
                    'ejercicio_fiscal' => now()->format('Y'),
                    'concepto' => $key,
                    'tipo' => 'rezago',
                    'impuesto' => $rezago['impuesto'],
                    'actualizacion' => $rezago['actualizacion'],
                    'recargos' => $rezago['recargos'],
                    'multas' => $rezago['multas'],
                    'requerimientos' => $rezago['requerimientos'],
                    'subtotal' => $rezago['subtotal'],
                ]);

            }

            foreach($this->cuenta_corriente as $cuenta){

                PagoDetalle::create([
                    'pago_id' => $this->pago->id,
                    'ejercicio_fiscal' => now()->format('Y'),
                    'concepto' => $cuenta['bimestre'],
                    'tipo' => 'cuenta corriente',
                    'impuesto' => $cuenta['impuesto'],
                    'actualizacion' => $cuenta['actualizacion'],
                    'recargos' => $cuenta['recargos'],
                    'multas' => $cuenta['multas'],
                    'requerimientos' => $cuenta['requerimientos'],
                    'subtotal' => $cuenta['subtotal'],
                ]);

            }

            $facturas = Factura::where('predio_id', $this->predio->id)->whereIn('status', ['rezago', 'facturado'])->get();

            foreach ($facturas as $factura) {

                $factura->update(['pago_id' => $this->pago->id, 'status' => 'pagado']);

            }

        });

    }

    public function generarPagoRezago($año){

        DB::transaction(function () use($año){

            $this->pago = Pago::create([
                'medio_pago' => 'efectivo',
                'predio_id' => $this->predio->id,
                'status' => 'pagado',
                'tipo' => 'ventanilla',
                'folio' => (Pago::where('año', now()->format('Y'))->where('usuario', auth()->user()->clave)->max('folio') ?? 0) + 1,
                'año' => now()->format('Y'),
                'usuario' => auth()->user()->clave,
                'total' => $this->rezago_impuesto,
                'fecha_pago' => now()->toDateString(),
                'creado_por' => auth()->id()
            ]);

            $this->procesarDescuentos($this->pago);

            foreach($this->rezagos as $key => $rezago){

                PagoDetalle::create([
                    'pago_id' => $this->pago->id,
                    'ejercicio_fiscal' => now()->format('Y'),
                    'concepto' => $key,
                    'tipo' => 'rezago',
                    'impuesto' => $rezago['impuesto'],
                    'actualizacion' => $rezago['actualizacion'],
                    'recargos' => $rezago['recargos'],
                    'multas' => $rezago['multas'],
                    'requerimientos' => $rezago['requerimientos'],
                    'subtotal' => $rezago['subtotal'],
                ]);

                if($key === $año) break;

            }

            $facturas = Factura::where('predio_id', $this->predio->id)->where('status', 'rezago')->where('ejercicio_fiscal', '<=', $año)->get();

            foreach ($facturas as $factura) {

                $factura->update(['pago_id' => $this->pago->id, 'status' => 'pagado']);

            }

        });

    }

    public function generarPagoCuentaCorriente($bimestre){

        DB::transaction(function () use($bimestre){

            $this->pago = Pago::create([
                'medio_pago' => 'efectivo',
                'predio_id' => $this->predio->id,
                'status' => 'pagado',
                'tipo' => 'ventanilla',
                'folio' => (Pago::where('año', now()->format('Y'))->where('usuario', auth()->user()->clave)->max('folio') ?? 0) + 1,
                'año' => now()->format('Y'),
                'usuario' => auth()->user()->clave,
                'total' => $this->cuenta_corriente_subtotal,
                'fecha_pago' => now()->toDateString(),
                'creado_por' => auth()->id()
            ]);

            $this->procesarDescuentos($this->pago);

            foreach($this->cuenta_corriente as $cuenta){

                PagoDetalle::create([
                    'pago_id' => $this->pago->id,
                    'ejercicio_fiscal' => now()->format('Y'),
                    'concepto' => $cuenta['bimestre'],
                    'tipo' => 'cuenta corriente',
                    'impuesto' => $cuenta['impuesto'],
                    'actualizacion' => $cuenta['actualizacion'],
                    'recargos' => $cuenta['recargos'],
                    'multas' => $cuenta['multas'],
                    'requerimientos' => $cuenta['requerimientos'],
                    'subtotal' => $cuenta['subtotal'],
                ]);

                if($cuenta['bimestre'] === $bimestre) break;

            }

            $facturas_cuenta_corriente = Factura::where('predio_id', $this->predio->id)->where('status', 'facturado')->where('bimestre', '<=', $bimestre)->get();

            foreach ($facturas_cuenta_corriente as $factura_cc) {

                $factura_cc->update(['pago_id' => $this->pago->id, 'status' => 'pagado']);

            }

            $facturas_rezago = Factura::where('predio_id', $this->predio->id)->where('status', 'rezago')->get();

            foreach ($facturas_rezago as $factura_rezago) {

                $factura_rezago->update(['pago_id' => $this->pago->id, 'status' => 'pagado']);

            }

        });

    }

    public function procesarDescuentos($pago){

        foreach ($this->descuentos as $descuento) {

            $descuento_bd = Descuento::where('tipo', $descuento['tipo'])
                                    ->where('accesorio', $descuento['accesorio'])
                                    ->where('porcentaje', $descuento['porcentaje'])
                                    ->first();

            $pago->descuentos()->attach($descuento_bd->id, ['monto' => $descuento['monto']]);

        }

    }

    public function mount(Predio $predio){

        $descuentos = Descuento::where('fecha_inicial', '<=', now()->startOfMonth()->format('Y-m-d'))->where('fecha_final', '>=', now()->endOfMonth()->format('Y-m-d'))->get();

        $this->descuentos_tipos = $descuentos->groupBy('tipo')->keys();

        $this->descuentos_accesorios = $descuentos->groupBy('accesorio')->keys();

        $this->descuentos_porcentaje = $descuentos->groupBy('porcentaje')->keys();

        $this->uma = Uma::where('año', now()->year)->first();

        $this->predio = $predio;

        $this->ejercicio_fiscal = Parametro::where('oficina_id', auth()->user()->oficina_id)
                                    ->where('ejercicio_fiscal', now()->year)
                                    ->first();

        if(! $this->ejercicio_fiscal){

            abort(403, 'No se han registrado los parametros para el año actual.');

        }

        if($this->predio->getKey()){

            $data = (new CuotaService())->execute($this->ejercicio_fiscal, $this->predio->valor_catastral, $this->predio->anioFechaEfectos(), $this->predio->tipo_predio);

            $this->tipo_couta = $data['tipo_cuota'];

            $this->tasa = $data['tasa'];

            $this->construirCuentaCorriente();

            $this->construirRezagos();

            $this->calcularTotal();

        }

        /* if(!$this->predio?->facturasEjercicioActual->count()){

            abort(403, 'El predio no tiene facturación para el ejercicio actual, genrarla en la administración de predios.');

        } */

    }

    public function render()
    {
        return view('livewire.cobros.predial.predial')->extends('layouts.admin');
    }

}
