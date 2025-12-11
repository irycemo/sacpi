<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\FactorIncremento as Model;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Log;

class FactorIncremento extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public $areas = [];

    public Model $modelo_editar;

    protected function rules(){
        return [
            'modelo_editar.factor' => 'required|numeric',
            'modelo_editar.año' => 'required|numeric',
         ];
    }

    public function crearModeloVacio(){
        $this->modelo_editar = Model::make();
    }

    public function abrirModalEditar(Model $modelo){

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

            $this->dispatch('mostrarMensaje', ['success', "El factor de incremento se creó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al crear factor de incremento por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function actualizar(){

        $this->validate();

        try{

            $this->modelo_editar->actualizado_por = auth()->user()->id;
            $this->modelo_editar->save();

            $this->resetearTodo($borrado = true);

            $this->dispatch('mostrarMensaje', ['success', "El factor de incremento se actualizó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al actualizar factor de incremento por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function borrar(){

        try{

            $permiso = Model::find($this->selected_id);

            $permiso->delete();

            $this->resetearTodo($borrado = true);

            $this->dispatch('mostrarMensaje', ['success', "El factor de incremento se eliminó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al borrar factor de incremento por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    #[Computed]
    public function factores(){

        return Model::with('creadoPor', 'actualizadoPor')
                                ->orderBy($this->sort, $this->direction)
                                ->paginate($this->pagination);

    }

    public function render()
    {
        return view('livewire.admin.factor-incremento')->extends('layouts.admin');
    }

}
