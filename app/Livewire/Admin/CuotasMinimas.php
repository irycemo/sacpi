<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Cuotaminima;
use Livewire\WithPagination;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Log;

class CuotasMinimas extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public Cuotaminima $modelo_editar;

    protected function rules(){
        return [
            'modelo_editar.municipio' => 'required|numeric',
            'modelo_editar.fecha_inicial' => 'required|date',
            'modelo_editar.fecha_final' => 'required|date',
            'modelo_editar.diario' => 'required|numeric',
            'modelo_editar.mensual' => 'required|numeric',
            'modelo_editar.anual' => 'required|numeric',
            'modelo_editar.umas' => 'required|numeric',
            'modelo_editar.cuota_minima' => 'required|numeric',
         ];
    }

    public function crearModeloVacio(){
        $this->modelo_editar = Cuotaminima::make();
    }

    public function abrirModalEditar(Cuotaminima $modelo){

        $this->resetearTodo();
        $this->modal = true;
        $this->editar = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

    }

    public function guardar(){

        $this->validate();

        try {

            $this->modelo_editar->creado_por = auth()->user()->id;
            $this->modelo_editar->save();

            $this->resetearTodo($borrado = true);

            $this->dispatch('mostrarMensaje', ['success', "La informacióin se creó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al crear valor por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function actualizar(){

        try{

            $this->modelo_editar->actualizado_por = auth()->user()->id;
            $this->modelo_editar->save();

            $this->resetearTodo($borrado = true);

            $this->dispatch('mostrarMensaje', ['success', "La información se actualizó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al actualizar valor por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function borrar(){

        try{

            $Valor = Cuotaminima::find($this->selected_id);

            $Valor->delete();

            $this->resetearTodo($borrado = true);

            $this->dispatch('mostrarMensaje', ['success', "La información se eliminó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al borrar valor por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    #[Computed]
    public function cuotas(){

        return Cuotaminima::where('municipio', 'like', '%' . $this->search .'%')
                    ->orderBy($this->sort, $this->direction)
                    ->paginate($this->pagination);

    }

    public function render()
    {
        return view('livewire.admin.cuotas-minimas')->extends('layouts.admin');
    }
}
