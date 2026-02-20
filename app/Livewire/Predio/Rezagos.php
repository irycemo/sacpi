<?php

namespace App\Livewire\Predio;
use App\Models\Factura;
use App\Models\Predio;
use Livewire\Component;
use Livewire\WithPagination;

class Rezagos extends Component
{

    use WithPagination;

    public Predio $predio;

    public function simular(){

        $años = ['2021', '2022', '2023', '2024', '2025'];

        for($j = 0; $j < 5; $j++){

            for($i = 1; $i < 7; $i++){

                Factura::create([
                    'predio_id' => $this->predio->id,
                    'status' => 'rezago',
                    'ejercicio_fiscal' => $años[$j],
                    'cuota' => 'superior',
                    'bimestre' => $i,
                    'total' => 550
                ]);

            }

        }

        $this->predio->refresh();

    }

    public function render()
    {
        $facturas = Factura::where('predio_id', $this->predio->id)
                        ->where('status','REZAGO')
                        ->paginate(100);

        return view('livewire.predio.rezagos', compact('facturas'));
    }

}
