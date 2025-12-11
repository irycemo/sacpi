<?php

namespace App\Livewire\Predio;
use App\Models\Factura;

use Livewire\Component;

class Rezagos extends Component
{

    public function render()
    {
        $facturas = Factura::where('predio_id',$this->predio->id)
                        ->where('status','REZAGO')
                        ->paginate($this->pagination);

        return view('livewire.predio.rezagos', compact('facturas'));
    }
}
