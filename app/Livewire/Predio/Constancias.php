<?php

namespace App\Livewire\Predio;

use App\Exceptions\GeneralException;
use Livewire\Component;
use App\Models\Constancia;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class Constancias extends Component
{

    public $predio;

    public function generarInvitacion(){

        try {

            $this->validaciones();

            $constancia = Constancia::create([
                'predio_id' => $this->predio->id,
                'año' => now()->format('Y'),
                'folio' => (Constancia::where('año', now()->format('Y'))->where('usuario', auth()->user()->clave)->max('folio') ?? 0) + 1,
                'usuario' => auth()->user()->clave,
                'creado_por' => auth()->id()
            ]);

            $tesorero =  auth()->user()->oficina->parametros->where('ejercicio_fiscal', now()->year)->first()->nombre_titular;

            $pdf = Pdf::loadView('constancias.constancia', [
                'constancia' => $constancia,
                'tesorero' => $tesorero,
                'predio' => $this->predio,
                'oficina' => auth()->user()->oficina
            ]);

            $pdf->render();

            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf->get_canvas();

            $canvas->page_text(480, 745, "Página: {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(1, 1, 1));

            $canvas->page_text(35, 745, 'Constancia: ' . $constancia->año . '-' . $constancia->folio . '-' . $constancia->año, null, 9, array(1, 1, 1));

            $this->predio->refresh();

            return response()->streamDownload(
                fn () => print($pdf->output()),
                $this->predio->cuentaPredial() . '-constancia.pdf'
            );

        } catch (GeneralException $ex) {

            $this->dispatch('mostrarMensaje', ['warning', $ex->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al generar constancia por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function reimprimir(Constancia $constancia){

        try {

            $pdf = Pdf::loadView('constancias.constancia', [
                'constancia' => $constancia,
                'tesorero' => auth()->user()->oficina->parametros->where('ejercicio_fiscal', now()->year)->first()->nombre_titular,
                'predio' => $this->predio,
                'oficina' => auth()->user()->oficina
            ]);

            $pdf->render();

            $dom_pdf = $pdf->getDomPDF();

            $canvas = $dom_pdf->get_canvas();

            $canvas->page_text(480, 745, "Página: {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(1, 1, 1));

            $canvas->page_text(35, 745, 'Constancia: ' . $constancia->año . '-' . $constancia->folio . '-' . $constancia->año, null, 9, array(1, 1, 1));

            $this->predio->refresh();

            return response()->streamDownload(
                fn () => print($pdf->output()),
                $this->predio->cuentaPredial() . '-constancia.pdf'
            );

        } catch (\Throwable $th) {

            Log::error("Error al generar constancia por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function validaciones(){

        $facturas = $this->predio->facturas->whereNull('pago_id')->first();

        if($facturas){

            if(!$this->predio->exento){

                throw new GeneralException("El predio aún tiene adeudos.");

            }

        }

    }

    public function render()
    {
        return view('livewire.predio.constancias');
    }
}
