<?php

namespace App\Livewire\Predio;

use Livewire\Component;
use App\Models\Invitacion;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exceptions\GeneralException;
use App\Services\RezagoService\RezagoService;

class Invitaciones extends Component
{

    public $predio;
    public $tipo_cuota;

    public function generarInvitacion(){

        try {

            $pdf = null;

            DB::transaction(function () use(&$pdf){

                $data = (new RezagoService($this->predio, $this->tipo_cuota))->construirRezagos(['facturado', 'rezago']);

                $oficina = auth()->user()->oficina;

                $monto = collect($data)->sum('subtotal');

                $invitacion = Invitacion::create([
                    'año' => now()->format('Y'),
                    'folio' => (Invitacion::where('año', now()->format('Y'))->where('usuario', auth()->user()->clave)->max('folio') ?? 0) + 1,
                    'usuario' => auth()->user()->clave,
                    'predio_id' => $this->predio->id,
                    'monto' => $monto,
                    'creado_por' => auth()->id()
                ]);

                $pdf = Pdf::loadView('invitaciones.invitacion', [
                    'data' => $data,
                    'oficina' => $oficina->nombre,
                    'predio' => $this->predio,
                    'monto' => $monto
                ]);

                $pdf->render();

                $dom_pdf = $pdf->getDomPDF();

                $canvas = $dom_pdf->get_canvas();

                $canvas->page_text(480, 745, "Página: {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(1, 1, 1));

                $canvas->page_text(35, 745, 'Invitación: ', null, 9, array(1, 1, 1));

            });

            $this->predio->refresh();

            return response()->streamDownload(
                fn () => print($pdf->output()),
                $this->predio->cuentaPredial() . '-invitacion.pdf'
            );

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['error', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al generar invitación por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function notificar(Invitacion $invitacion){

        try {

            $invitacion->update([
                'fecha_notificacion' => now()->toDateString(),
                'actualizado_por' => auth()->id()
            ]);

            $this->dispatch('mostrarMensaje', ['success', "Se notificó con éxito."]);

            $this->predio->refresh();

        } catch (\Throwable $th) {

            Log::error("Error al notificar invitación por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function render()
    {
        return view('livewire.predio.invitaciones');
    }
}
