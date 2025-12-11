<?php

namespace App\Livewire\Consultas;
use App\Models\Predio;
use App\Traits\ComponentesTrait;
use Livewire\WithPagination;
use Livewire\Component;

class Predios extends Component
{
    use WithPagination;
    use ComponentesTrait;

    public Predio $modelo_editar;

    public function crearModeloVacio(){
        $this->modelo_editar = Predio::make();
    }

    public $filters = [
        'localidad' => '',
        'oficina' => '',
        'tipo' => '',
        'registro' => '',
    ];

    public function updatedFilters() { $this->resetPage(); }

    public function mount(){

        if(!auth()->user()->hasRole('Administrador')){

            $this->filters['oficina'] = auth()->user()->oficina->oficina;

        }

    }

    public function render()
    {
        $predios = Predio::with('actualizadoPor')
                            ->when($this->filters['localidad'], fn($q, $localidad) => $q->where('localidad', $localidad))
                            ->when($this->filters['oficina'], fn($q, $oficina) => $q->where('oficina', $oficina))
                            ->when($this->filters['tipo'], fn($q, $tipo) => $q->where('tipo_predio', $tipo))
                            ->when($this->filters['registro'], fn($q, $registro) => $q->where('numero_registro', $registro))
                            ->when(!auth()->user()->hasRole('Administrador'), function($q){
                                $q->where('oficina', auth()->user()->oficina->oficina);
                            })
                            ->orderBy($this->sort, $this->direction)
                            ->paginate($this->pagination);

        return view('livewire.consultas.predios', compact('predios'))->extends('layouts.admin');
    }
}
