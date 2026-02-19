<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Descuento;
use Livewire\WithPagination;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Log;

class Descuentos extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public Descuento $modelo_editar;

    protected function rules(){
        return [
            'modelo_editar.tipo' => 'required|string',
            'modelo_editar.porcentaje' => 'nullable|numeric',
            'modelo_editar.fecha_inicial' => 'required|date',
            'modelo_editar.fecha_final' => 'required|date',
         ];
    }

    public function crearModeloVacio(){
        $this->modelo_editar = Descuento::make();
    }

    public function abrirModalEditar(Descuento $modelo){

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

            $this->dispatch('mostrarMensaje', ['success', "El descuento se creó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al crear descuento por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function actualizar(){

        try{

            $this->modelo_editar->actualizado_por = auth()->user()->id;
            $this->modelo_editar->save();

            $this->resetearTodo($borrado = true);

            $this->dispatch('mostrarMensaje', ['success', "El descuento se actualizó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al actualizar descuento por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    public function borrar(){

        try{

            $descuento = Descuento::find($this->selected_id);

            $descuento->delete();

            $this->resetearTodo($borrado = true);

            $this->dispatch('mostrarMensaje', ['success', "El descuento se eliminó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al borrar fescuento por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();

        }

    }

    #[Computed]
    public function descuentos(){

        return Descuento::select('id', 'tipo', 'accesorio', 'porcentaje', 'fecha_inicial', 'fecha_final', 'creado_por', 'actualizado_por', 'created_at', 'updated_at')
                    ->with('creadoPor:id,name', 'actualizadoPor:id,name')
                    ->where('tipo', 'like', '%' . $this->search .'%')
                    ->orderBy($this->sort, $this->direction)
                    ->paginate($this->pagination);

    }
    public function render()
    {
        return view('livewire.admin.descuentos')->extends('layouts.admin');
    }
}
