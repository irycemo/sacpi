<?php

namespace App\Livewire\Admin;

use App\Models\Oficina;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Oficinas extends Component
{

    use ComponentesTrait;
    use WithPagination;

    public Oficina $modelo_editar;
    public $cabeceras;
    public $sectorInicial;
    public $sectorFinal;
    public $sectores = [];

    protected function rules(){
        return [
            'modelo_editar.oficina' => 'required|numeric',
            'modelo_editar.region' => 'required|numeric',
            'modelo_editar.municipio' => 'required|numeric',
            'modelo_editar.localidad' => 'required|numeric',
            'modelo_editar.nombre' => 'required|string',
            'modelo_editar.ubicacion' => 'required',
            'modelo_editar.titular' => 'required',
            'modelo_editar.email' => 'required|email',
            'modelo_editar.telefonos' => 'required',
            'modelo_editar.autoridad_municipal' => 'nullable',
            'modelo_editar.valuador_municipal' => 'nullable',
            'modelo_editar.cabecera' => 'nullable',
            'modelo_editar.sectores' => 'nullable',
            'modelo_editar.tipo' => 'required',
            'sectorInicial' => 'nullable|numeric|min:1|max:102|lte:sectorFinal',
            'sectorFinal' => 'nullable|numeric|min:1|max:102|gte:sectorInicial'
         ];
    }

    protected $validationAttributes  = [
        'modelo_editar.autoridad_municipal' => 'autoridad municipal',
        'modelo_editar.valuador_municipal' => 'valuador municipal'
    ];

    public function crearModeloVacio(){
        $this->modelo_editar =  Oficina::make();
    }

    public function abrirModalEditar(Oficina $modelo){

        $this->resetearTodo();
        $this->modal = true;
        $this->editar = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

        if($this->modelo_editar->sectores)
            $this->sectores = json_decode($this->modelo_editar->sectores);
    }

    public function guardar(){

        $this->validate();

        try {

            DB::transaction(function (){

                $array = [];

                for ($i=$this->sectorInicial; $i <= $this->sectorFinal ; $i++) {

                    if( $i == 0) continue;

                    array_push($array, (int)$i);

                }

                $this->modelo_editar->sectores = $array;
                $this->modelo_editar->creado_por = auth()->user()->id;
                $this->modelo_editar->save();

                $this->resetearTodo($borrado = true);

                $this->dispatch('mostrarMensaje', ['success', "La oficina se creó con éxito."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al crear oficina por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function actualizar(){

        $this->validate();

        try{

            DB::transaction(function () {

                for ($i=$this->sectorInicial; $i <= $this->sectorFinal ; $i++) {

                    if( $i == 0) continue;

                    if($this->sectores && in_array($i, $this->sectores)) continue;

                    array_push($this->sectores, (int)$i);

                }

                sort($this->sectores);

                $this->modelo_editar->sectores = $this->sectores;
                $this->modelo_editar->actualizado_por = auth()->user()->id;
                $this->modelo_editar->save();

                $this->resetearTodo($borrado = true);

                $this->dispatch('mostrarMensaje', ['success', "La oficina se actualizó con éxito."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al actualizar oficina por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();
        }

    }

    public function borrar(){

        try{

            $usuario = Oficina::find($this->selected_id);

            $usuario->delete();

            $this->resetearTodo($borrado = true);

            $this->dispatch('mostrarMensaje', ['success', "La oficina se eliminó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al borrar oficina por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();
        }

    }

    #[Computed]
    public function oficinas(){

        return Oficina::with('creadoPor', 'actualizadoPor', 'cabeceraMunicipal')
                        ->where('municipio', 'LIKE', '%'. $this->search . '%')
                        ->orWhere('oficina', 'LIKE', '%'. $this->search . '%')
                        ->orWhere('localidad', 'LIKE', '%'. $this->search . '%')
                        ->orWhere('nombre', 'LIKE', '%'. $this->search . '%')
                        ->orWhere('ubicacion', 'LIKE', '%'. $this->search . '%')
                        ->orWhere('titular', 'LIKE', '%'. $this->search . '%')
                        ->orWhere('email', 'LIKE', '%'. $this->search . '%')
                        ->orWhere('telefonos', 'LIKE', '%'. $this->search . '%')
                        ->orWhere('autoridad_municipal', 'LIKE', '%'. $this->search . '%')
                        ->orWhere('valuador_municipal', 'LIKE', '%'. $this->search . '%')
                        ->orderBy($this->sort, $this->direction)
                        ->paginate($this->pagination);

    }

    public function mount(){

        $this->cabeceras = Oficina::whereNull('cabecera')->orderBy('nombre')->get();

        $this->crearModeloVacio();

        array_push($this->fields, 'sectorInicial', 'sectorFinal', 'sectores');

    }

    public function render()
    {
        return view('livewire.admin.oficinas')->extends('layouts.admin');
    }

}
