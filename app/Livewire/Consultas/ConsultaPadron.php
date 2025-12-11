<?php

namespace App\Livewire\Consultas;

use App\Models\Predio;
use App\Models\Oficina;
use Livewire\Component;
use App\Models\Propietario;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Cache;

class ConsultaPadron extends Component
{

    use WithPagination;

    public $radio = 'clave';

    public $numero_registro;
    public $region_catastral;
    public $municipio;
    public $localidad;
    public $sector;
    public $zona_catastral;
    public $manzana;
    public $tipo_predio;
    public $oficina;

    public $nombre;
    public $ap_paterno;
    public $ap_materno;
    public $razon_social;
    public $rfc;
    public $curp;
    public $ubicacion;
    public $diez = false;
    public $prediosIds;
    public $flag = false;
    public $buscarClave = true;

    public $propietariosIds = [];

    public $selected_id;

    protected function rules(){
        return [
            'numero_registro' => 'required|numeric|min:1',
            'region_catastral' => 'required|numeric|min:1',
            'municipio' => 'required|numeric|min:1',
            'localidad' => 'required|numeric|min:1',
            'sector' => 'required|numeric|min:1',
            'zona_catastral' => 'required|numeric|min:1,|same:localidad',
            'manzana' => 'required|numeric|min:1',
            'tipo_predio' => 'required|numeric|min:1|max:2',
            'oficina' => 'required|numeric|min:1',
         ];
    }

    public function updated($property, $value){

        if($value == ''){

            $this->$property = null;

        }

    }

    public function updatedRadio(){

        $this->reset([
            'nombre',
            'ap_paterno',
            'ap_materno',
            'razon_social',
            'rfc',
            'curp',
            'ubicacion',
            'numero_registro',
            'region_catastral',
            'municipio',
            'localidad',
            'sector',
            'zona_catastral',
            'manzana',
            'tipo_predio',
            'oficina',
        ]);

        $this->oficina = auth()->user()->oficina->oficina;

        $this->municipio = auth()->user()->oficina->municipio;

        $this->region_catastral = auth()->user()->oficina->region;

    }

    public function updatedOficina(){

        if($this->oficina == '') {

            $this->oficina = auth()->user()->oficina->oficina;

        }

        $oficina = Oficina::where('oficina', $this->oficina)->first();

        if(!$oficina){

            $this->oficina = auth()->user()->oficina->oficina;

        }

        $this->municipio = $oficina->municipio;

        $this->region_catastral = $oficina->region;

    }

    public function buscarCuentaPredial(){

        $this->validate([
            'numero_registro' => 'required|numeric|min:1',
            'tipo_predio' => 'required|numeric|min:1|max:2',
            'oficina' => 'required|numeric|min:1',
            'localidad' => 'required|numeric|min:1',
        ]);

        Cache::forget('consulta-predio-' . $this->getId());

        $this->reset(['selected_id', 'flag']);

        if($this->diez){

            Cache::forget('consulta-predios-' . $this->getId());

            return;

        }

        if($this->predio){

            if($this->predio->status == 'bloqueado'){

                $this->dispatch('mostrarMensaje', ['warning', "El predio se encuentra bloqueado."]);

                Cache::forget('consulta-predio-' . $this->getId());

            }

            if($this->predio->status != 'activo'){

                $this->dispatch('mostrarMensaje', ['warning', "El predio no esta activo."]);

                Cache::forget('consulta-predio-' . $this->getId());

            }

            $this->flag = true;

        }

    }

    public function buscarClaveCatastral(){

        $this->validate([
            'region_catastral' => 'required|numeric|min:1',
            'municipio' => 'required|numeric|min:1',
            'localidad' => 'required|numeric|min:1',
            'sector' => 'required|numeric|min:1',
            'zona_catastral' => 'required|numeric|min:1,|same:localidad',
            'manzana' => 'required|numeric|min:1',
        ]);

        $this->reset(['flag', 'diez']);

        Cache::forget('consulta-predios-' . $this->getId());

    }

    public function buscarPorPropietario(){

        $this->validate([
            'nombre' => Rule::requiredIf($this->ap_paterno != null || $this->ap_materno != null),
            'ap_paterno' => Rule::requiredIf($this->ap_materno != null || $this->nombre != null),
            'ap_materno' => Rule::requiredIf($this->nombre != null || $this->ap_materno != null),
            'razon_social' => Rule::requiredIf($this->nombre == null && $this->ap_materno == null && $this->ap_paterno == null && $this->rfc == null && $this->curp == null),
            'rfc' => Rule::requiredIf($this->nombre == null && $this->ap_materno == null && $this->ap_paterno == null && $this->razon_social == null && $this->curp == null),
            'curp' => Rule::requiredIf($this->nombre == null && $this->ap_materno == null && $this->ap_paterno == null && $this->rfc == null && $this->razon_social == null),
        ]);

        $this->reset('flag');

        Cache::forget('consulta-predios-' . $this->getId());

        $propietarios = Propietario::whereHas('persona', function($q){
                                                $q->when($this->nombre != '' && $this->nombre != null, function($q){
                                                    $q->where('nombre', $this->nombre);
                                                })
                                                ->when($this->ap_paterno != '' && $this->ap_paterno != null, function($q){
                                                    $q->where('ap_paterno', $this->ap_paterno);
                                                })
                                                ->when($this->ap_materno != '' && $this->ap_materno != null, function($q){
                                                    $q->where('ap_materno', $this->ap_materno);
                                                })
                                                ->when($this->razon_social != '' && $this->razon_social != null, function($q){
                                                    $q->where('razon_social', $this->razon_social);
                                                })
                                                ->when($this->rfc != '' && $this->rfc != null, function($q){
                                                    $q->where('rfc', $this->rfc);
                                                })
                                                ->when($this->curp != '' && $this->curp != null, function($q){
                                                    $q->where('curp', $this->curp);
                                                });
                                        })
                                        ->where('propietarioable_type', 'App\Models\Predio')
                                        ->get();

        $this->propietariosIds = $propietarios->pluck('propietarioable_id');

    }

    public function buscarPorUbicacion(){

        $this->validate(['ubicacion' => 'required']);

        $this->reset('flag');

        Cache::forget('consulta-predios-' . $this->getId());

    }

    public function verPredio($predio){

        Cache::forget('consulta-predio-' . $this->getId());

        $this->selected_id = $predio;

        $this->flag = true;

    }

    #[Computed]
    public function prediosLista(){

        $key = 'consulta-predios-' . $this->getId();

        return Cache::remember($key, 300, function(){

            if($this->radio == 'clave' && $this->diez){

                return Predio::whereBetween('numero_registro', [$this->numero_registro - 10 , $this->numero_registro + 10 ])
                                ->where('tipo_predio', $this->tipo_predio)
                                ->where('localidad', $this->localidad)
                                ->where('oficina', $this->oficina)
                                ->paginate(20);

            }elseif($this->radio == 'clave'){

                return Predio::where('status', 'activo')
                        ->where('estado', 16)
                        ->where('region_catastral', $this->region_catastral)
                        ->where('municipio', $this->municipio)
                        ->where('zona_catastral', $this->zona_catastral)
                        ->where('localidad', $this->localidad)
                        ->where('sector', $this->sector)
                        ->where('manzana', $this->manzana)
                        ->where('oficina', $this->oficina)
                        ->paginate(20);

            }elseif($this->radio == 'propietario'){

                return Predio::whereIn('id', $this->propietariosIds)
                                ->where('oficina', $this->oficina)
                                ->orderBy('oficina')
                                ->paginate(20);

            }elseif($this->radio == 'ubicacion'){

                return Predio::whereAny([
                                            'tipo_vialidad',
                                            'tipo_asentamiento',
                                            'nombre_vialidad',
                                            'nombre_asentamiento',
                                            'nombre_predio',
                                            'nombre_edificio',
                                            'clave_edificio',
                                            'departamento_edificio',
                                        ],
                                        'like', '%' . $this->ubicacion . '%'
                                    )
                                    ->where('oficina', $this->oficina)
                                    ->paginate(20);
            }

        });

    }

    #[Computed]
    public function predio(){

        $key = 'consulta-predio-' . $this->getId();

        return Cache::remember($key, 300, function(){

            if(in_array($this->radio, ['clave', 'propietario', 'ubicacion']) && $this->selected_id){

                return Predio::with(
                                'propietarios.persona',
                                'colindancias',
                            )
                            ->whereKey($this->selected_id)
                            ->first();

            }elseif(in_array($this->radio, ['clave', 'propietario', 'ubicacion'])){

                return Predio::with(
                                        'propietarios.persona',
                                        'colindancias',
                                    )
                                    ->where('numero_registro', $this->numero_registro)
                                    ->where('tipo_predio', $this->tipo_predio)
                                    ->where('localidad', $this->localidad)
                                    ->where('oficina', $this->oficina)
                                    ->first();

            }

        });

    }

    public function mount(){

        $this->oficina = auth()->user()->oficina->oficina;

        $this->municipio = auth()->user()->oficina->municipio;

        $this->region_catastral = auth()->user()->oficina->region;

    }

    public function render()
    {
        return view('livewire.consultas.consulta-padron')->extends('layouts.admin');
    }
}
