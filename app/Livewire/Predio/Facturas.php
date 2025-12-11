<?php

namespace App\Livewire\Predio;

use App\Exceptions\GeneralException;
use App\Models\Factura;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Facturas extends Component
{

    public $predio;
    public $tipo_cuota;
    public $impuesto_anual;

    public function quitarAdeudo(){

        try{

            if($this->predio->facturasEjercicioActual()->where('status', 'pagado')->first()){

                throw new GeneralException('No es posible borrar la facturación, existe almenos un pago.');

            }

            $this->predio->facturasEjercicioActual()->delete();

            $this->predio->refresh();

            $this->dispatch('mostrarMensaje', ['success', "Se eliminó el adeudo con éxito."]);

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['error', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al quitar el adeudo por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th->getMessage());
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function generarFacturas(){

        try {

            DB::transaction(function () {

                if($this->tipo_cuota == 'minima'){

                    $this->generarFacturaMinima();

                    $this->dispatch('mostrarMensaje', ['success', "Se generó la factura para cuota mínima."]);

                }else{

                    $this->generarFacturaSuperior();

                    $this->dispatch('mostrarMensaje', ['success', "Se generarón las facturas para los 6 bimestres."]);

                }

            });

        } catch (\Throwable $th) {

            Log::error("Error al generar facturación por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function generarFacturaMinima(){

        Factura::create([
                        'predio_id' => $this->predio->id,
                        'status' => 'facturado',
                        'ejercicio_fiscal' => now()->format('Y'),
                        'cuota' => $this->tipo_cuota,
                        'bimestre' => 1,
                        'total' => $this->impuesto_anual
                    ]);

        $this->predio->refresh();

    }

    public function generarFacturaSuperior(){

        for($i = 1; $i < 7; $i++){

            $factura = Factura::where('predio_id', $this->predio->id)
                                ->whereNotNull('pago_id')
                                ->where('ejercicio_fiscal', now()->format('Y'))
                                ->where('cuota', $this->tipo_cuota)
                                ->where('bimestre', $i)
                                ->first();

            if($factura) continue;

            Factura::create([
                'predio_id' => $this->predio->id,
                'status' => 'facturado',
                'ejercicio_fiscal' => now()->format('Y'),
                'cuota' => $this->tipo_cuota,
                'bimestre' => $i,
                'total' => $this->impuesto_anual / 6
            ]);

        }

        $this->predio->refresh();

    }

    public function render()
    {
        return view('livewire.predio.facturas');
    }
}
