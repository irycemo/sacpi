<?php

namespace App\Livewire\Padron\Captura;

use App\Models\Avaluo;
use App\Models\Predio;
use Livewire\Component;
use App\Models\Colindancia;
use App\Models\PredioAvaluo;
use App\Constantes\Constantes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Colindancias extends Component
{
    public $flag = false;

    public $predio;
    public $avaluo_id;
    public $predio_id;

    public $medidas = [];
    public $vientos;

    protected $listeners = ['cargarPredio'];

    protected function rules(){
        return [
            'medidas.*' => 'required',
            'medidas.*.viento' => 'required|string',
            'medidas.*.longitud' => [
                                        'required',
                                        'numeric',
                                        'min:0',
                                    ],
            'medidas.*.descripcion' => 'required',
            'predio' => 'required'
         ];
    }

    protected $validationAttributes  = [
        'medidas.*.viento' => 'viento',
        'medidas.*.longitud' => 'longitud',
        'medidas.*.descripcion' => 'descripción',
    ];

    protected $messages = [
        'predio.required' => '. Primero debe cargar el predio'
    ];

    public function updatedMedidas($value, $index){

        $i = explode('.', $index);

        if(isset($this->medidas[$i[0]]['viento']) && $this->medidas[$i[0]]['viento'] == 'ANEXO'){

            $this->medidas[$i[0]]['longitud'] = 0;

        }

    }

    public function cargarPredio($id, $flag = null){

        $this->reset('medidas');

        if($flag){

            $this->flag = true;

            $this->predio = Predio::with('colindancias')->find($id);

        }else{

            $this->predio = PredioAvaluo::with('colindancias', 'avaluo')->find($id);

        }

        foreach ($this->predio->colindancias as $colindancia) {

            $this->medidas[] = [
                'id' => $colindancia->id,
                'viento' => $colindancia->viento,
                'longitud' => $colindancia->longitud,
                'descripcion' => $colindancia->descripcion,
            ];

        }

        if(count($this->medidas) == 0)
            $this->agregarMedida();

    }

    public function agregarMedida(){

        $this->medidas[] = ['viento' => null, 'longitud' => null, 'descripcion' => null, 'id' => null];

    }

    public function borrarMedida($index){

        $this->validate(['predio' => 'required']);

        if(!$this->flag)
            $this->authorize('update',$this->predio->avaluo);

        try {

            DB::transaction(function () use($index){

                $this->predio->colindancias()->where('id', $this->medidas[$index]['id'])->delete();

                $this->audit();

            });

        } catch (\Throwable $th) {
            Log::error("Error al borrar colindancia por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);
        }

        unset($this->medidas[$index]);

        $this->medidas = array_values($this->medidas);

    }

    public function guardar(){

        if(!$this->flag && ($this->predio && $this->predio->avaluo && $this->predio->avaluo->estado == 'notificado')){

            $this->authorize('update',$this->predio->avaluo);

            $this->dispatch('mostrarMensaje', ['error', "No puedes modificar un avalúo notificado."]);

            return;

        }

        $this->validate();

        try {

            DB::transaction(function () {

                foreach ($this->medidas as $key =>$medida) {

                    if($medida['id'] == null){

                        $aux = $this->predio->colindancias()->create([
                            'viento' => $medida['viento'],
                            'longitud' => $medida['longitud'],
                            'descripcion' => $medida['descripcion'],
                        ]);

                        $this->medidas[$key]['id'] = $aux->id;

                    }else{

                        Colindancia::find($medida['id'])->update([
                            'viento' => $medida['viento'],
                            'longitud' => $medida['longitud'],
                            'descripcion' => $medida['descripcion'],
                        ]);

                    }

                }

                $this->audit();

                $this->dispatch('mostrarMensaje', ['success', "Las colindacias se guardaron con éxito"]);

            });

        } catch (\Throwable $th) {
            Log::error("Error al crear medidas por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);
        }

    }

    public function audit(){

        if($this->avaluo_id){

            $avaluo = Avaluo::find($this->avaluo_id);

            $avaluo->touch();

            $avaluo->audits()->latest()->first()->update(['tags' => 'Actualizó colindancias']);

        }else{

            $this->predio->touch();

            $this->predio->audits()->latest()->first()->update(['tags' => 'Actualizó colindancias']);

        }
    }

    public function mount(){

        $this->vientos = Constantes::VIENTOS;

        $this->medidas = [
            ['viento' => null, 'longitud' => null, 'descripcion' => null, 'id' => null]
        ];

        if($this->avaluo_id){

            $avaluo = Avaluo::with('predioAvaluo')->find($this->avaluo_id);

            $this->cargarPredio($avaluo->predioAvaluo->id);

        }

    }

    public function render()
    {
        return view('livewire.padron.captura.colindancias');
    }
}
