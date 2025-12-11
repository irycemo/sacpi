<?php

namespace App\Livewire\Admin;

use App\Models\Rol;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use App\Constantes\Constantes;
use App\Traits\ComponentesTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Usuarios extends Component
{

    use WithPagination;
    use ComponentesTrait;

    public $roles;
    public $permisos;
    public $areas;
    public $localidades;
    public $oficinas;

    public User $modelo_editar;
    public $role;

    public $filters = [
        'rol' => '',
        'localidad' => '',
        'area' => ''
    ];

    protected function rules(){
        return [
            'modelo_editar.name' => 'required',
            'modelo_editar.email' => 'required|email|unique:users,email,' . $this->modelo_editar->id,
            'modelo_editar.status' => 'required|in:activo,inactivo',
            'role' => 'required',
         ];
    }

    protected $validationAttributes  = [
        'role' => 'rol',
    ];

    public function crearModeloVacio(){
        $this->modelo_editar =  User::make();
    }

    public function abrirModalEditar(User $modelo){

        $this->resetearTodo();
        $this->modal = true;
        $this->editar = true;

        if($this->modelo_editar->isNot($modelo))
            $this->modelo_editar = $modelo;

        $this->role = $modelo['roles'][0]['id'];
    }

    public function guardar(){

        $this->validate();

        try {

            DB::transaction(function () {

                $this->modelo_editar->password = bcrypt('sistema');
                $this->modelo_editar->creado_por = auth()->user()->id;
                $this->modelo_editar->save();

                $this->modelo_editar->roles()->attach($this->role);

                $this->resetearTodo($borrado = true);

                $this->dispatch('mostrarMensaje', ['success', "El usuario se creó con éxito."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al crear usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();
        }

    }

    public function actualizar(){

        $this->validate();

        try{

            DB::transaction(function () {

                $this->modelo_editar->actualizado_por = auth()->user()->id;
                $this->modelo_editar->save();

                $this->modelo_editar->roles()->sync($this->role);

                $this->resetearTodo($borrado = true);

                $this->dispatch('mostrarMensaje', ['success', "El usuario se actualizó con éxito."]);

            });

        } catch (\Throwable $th) {

            Log::error("Error al actualizar usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();
        }

    }

    public function borrar(){

        try{

            $usuario = User::find($this->selected_id);

            $usuario->delete();

            $this->resetearTodo($borrado = true);

            $this->dispatch('mostrarMensaje', ['success', "El usuario se eliminó con éxito."]);

        } catch (\Throwable $th) {

            Log::error("Error al borrar usuario por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);
            $this->resetearTodo();
        }

    }

    public function mount(){

        $this->crearModeloVacio();

        array_push($this->fields, 'role');

        $this->roles = Rol::where('id', '!=', 1)->select('id', 'name')->orderBy('name')->get();

    }

    public function render()
    {

        $usuarios = User::with('creadoPor', 'actualizadoPor')
                            ->where(function($q){
                                $q->where('name', 'LIKE', '%' . $this->search . '%');
                            })
                            ->when($this->filters['rol'], fn($q, $rol) => $q->whereHas('roles', function($q) use($rol){ $q->where('name', $rol); }))
                            ->orderBy($this->sort, $this->direction)
                            ->paginate($this->pagination);

        return view('livewire.admin.usuarios', compact('usuarios'))->extends('layouts.admin');
    }

}
