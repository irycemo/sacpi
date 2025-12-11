<?php

namespace App\Livewire\Admin;

use App\Models\Uma;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Log;

class Umas extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public Uma $modelo_editar;

    protected function rules(){
        return [
            'modelo_editar.año' => 'required|numeric|min:2016|unique:umas,año,' . $this->modelo_editar->id,
            'modelo_editar.diario' => 'required|numeric',
            'modelo_editar.mensual' => 'required|numeric',
            'modelo_editar.anual' => 'required|numeric',
         ];
    }

    public function crearModeloVacio(){
        $this->modelo_editar = Uma::make();
    }

    public function abrirModalEditar(Uma $modelo){

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

            $this->dispatch('mostrarMensaje', ['success', "La UMA se creó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al crear UMA por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function actualizar(){

        try{

            $this->modelo_editar->actualizado_por = auth()->user()->id;
            $this->modelo_editar->save();

            $this->resetearTodo($borrado = true);

            $this->dispatch('mostrarMensaje', ['success', "La UMA se actualizó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al actualizar UMA por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function borrar(){

        try{

            $uma = Uma::find($this->selected_id);

            $uma->delete();

            $this->resetearTodo($borrado = true);

            $this->dispatch('mostrarMensaje', ['success', "La UMA se eliminó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al borrar UMA por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    #[Computed]
    public function umas(){

        return Uma::with('creadoPor', 'actualizadoPor')
                    ->where('año', 'like', '%' . $this->search .'%')
                    ->orderBy($this->sort, $this->direction)
                    ->paginate($this->pagination);

    }

    public function render()
    {
        return view('livewire.admin.umas')->extends('layouts.admin');
    }

}
