<?php

namespace App\Livewire\Admin;

use App\Models\Valor;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\ComponentesTrait;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Log;

class ValoresGenerales extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public Valor $modelo_editar;

    protected function rules(){
        return [
            'modelo_editar.ejercicio_fiscal' => 'required|numeric',
            'modelo_editar.valor_catastral_minimo_urbanos' => 'required|numeric',
            'modelo_editar.valor_catastral_minimo_rusticos' => 'required|numeric',
            'modelo_editar.inpc_enero' => 'required|numeric',
            'modelo_editar.inpc_febrero' => 'required|numeric',
            'modelo_editar.inpc_marzo' => 'required|numeric',
            'modelo_editar.inpc_abril' => 'required|numeric',
            'modelo_editar.inpc_mayo' => 'required|numeric',
            'modelo_editar.inpc_junio' => 'required|numeric',
            'modelo_editar.inpc_julio' => 'required|numeric',
            'modelo_editar.inpc_agosto' => 'required|numeric',
            'modelo_editar.inpc_septiembre' => 'required|numeric',
            'modelo_editar.inpc_octubre' => 'required|numeric',
            'modelo_editar.inpc_noviembre' => 'required|numeric',
            'modelo_editar.inpc_diciembre' => 'required|numeric',
         ];
    }

    public function crearModeloVacio(){
        $this->modelo_editar = Valor::make();
    }

    public function abrirModalEditar(Valor $modelo){

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

            $Valor = Valor::find($this->selected_id);

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
    public function valores(){

        return Valor::with('creadoPor', 'actualizadoPor')
                    ->where('ejercicio_fiscal', 'like', '%' . $this->search .'%')
                    ->orderBy($this->sort, $this->direction)
                    ->paginate($this->pagination);

    }

    public function render()
    {
        return view('livewire.admin.valores-generales')->extends('layouts.admin');
    }
}
