<?php

namespace App\Livewire\Predio;
use App\Models\Pago;
use App\Models\Factura;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Pagos extends Component
{

    public $predio;
    public $pago;
    public $facturas;
    public $motivo;
    public $descuentos;
    public $modal_cancelar = false;
    public $modal_ver = false;

    protected function rules(){

        return [
            'motivo' => 'required|string',
            'pago.actualizado_por' => 'nullable',
            'pago.status' => 'nullable',
        ];

    }

    public function abrirModalCancelar(Pago $pago){

        $this->pago = $pago;

        $this->modal_cancelar = true;

        $this->facturas = Factura::where('pago_id', $this->pago->id)->where('status', 'pagado')->get();

        $this->descuentos = $this->pago->descuentos;

    }

    public function abrirModalVer(Pago $pago){

        $this->pago = $pago;

        $this->modal_ver = true;

        $this->facturas = Factura::where('pago_id', $this->pago->id)->get();

        $this->descuentos = $this->pago->descuentos;

    }

    public function cancelarPago() {

        $this->validate();

        try{

            DB::transaction(function () {

                foreach ($this->facturas as $factura) {

                    $factura->update([
                        'pago_id' => null,
                        'status' => $factura->ejercicio_fiscal == now()->format('Y') ? 'facturado' : 'rezago'
                    ]);

                }

                $this->pago->update([
                    'status' => 'cancelado',
                    'observaciones' => $this->motivo,
                    'actualizado_por' => auth()->id()
                ]);

            });

            $this->reset(['motivo', 'modal_cancelar']);

            $this->dispatch('mostrarMensaje', ['success', "El pago de canceló con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al cancelar el pago por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th->getMessage());
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function mount(){

        $this->predio->load('pagos.creadoPor');

    }

    public function render()
    {
        return view('livewire.predio.pagos');
    }

}
