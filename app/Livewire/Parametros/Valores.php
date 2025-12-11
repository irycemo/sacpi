<?php

namespace App\Livewire\Parametros;

use App\Models\Parametro;
use Livewire\Component;

class Valores extends Component
{

    public Parametro $parametro;

    protected function rules(){
        return [
            'parametro.nombre_titular' => 'required|string',
            'parametro.tasa_isai' => 'required|numeric',
            'parametro.cuota_minima_isai' => 'required|numeric',
            'parametro.tasa_recargos_isai' => 'required|numeric',
            'parametro.cuota_minima_predial_urbanos' => 'required|numeric',
            'parametro.cuota_minima_predial_rusticos' => 'required|numeric',
            'parametro.cuota_minima_ejidal_urbanos' => 'required|numeric',
            'parametro.cuota_minima_ejidal_rusticos' => 'required|numeric',
            'parametro.folio_contancias' => 'required|numeric',
            'parametro.folio_requerimientos' => 'required|numeric',
            'parametro.folio_constancias' => 'required|numeric',
            'parametro.tasa_urbanos_1980' => 'required|numeric',
            'parametro.tasa_urbanos_81a83' => 'required|numeric',
            'parametro.tasa_urbanos_84y85' => 'required|numeric',
            'parametro.tasa_urbanos_1986' => 'required|numeric',
            'parametro.tasa_urbanos_ejidales' => 'required|numeric',
            'parametro.tasa_rusticos_1980' => 'required|numeric',
            'parametro.tasa_rusticos_81a83' => 'required|numeric',
            'parametro.tasa_rusticos_84y85' => 'required|numeric',
            'parametro.tasa_rusticos_1986' => 'required|numeric',
            'parametro.tasa_rusticos_ejidales' => 'required|numeric',
         ];
    }

    protected $validationAttributes  = [
        'parametro.nombre_titular' => 'nombre del titular',
        'parametro.tasa_isai' => 'tasa de ISAI',
        'parametro.cuota_minima_isai' => 'cuota mínima de ISAI',
        'parametro.tasa_recargos_isai' => 'tasa de recargos de ISAI',
        'parametro.cuota_minima_predial_urbanos' => 'cuota mínima de predial urbanos',
        'parametro.cuota_minima_predial_rusticos' => 'cuota mínima de predial rusticos',
        'parametro.cuota_minima_ejidal_urbanos' => 'cuota mínima de ejidal urbanos',
        'parametro.cuota_minima_ejidal_rusticos' => 'cuota mínima de ejidal rusticos',
        'parametro.tasa_urbanos_1980' => 'tasa predios urbanos 1980',
        'parametro.tasa_urbanos_81a83' => 'tasa predios urbanos 1981-1983',
        'parametro.tasa_urbanos_84y85' => 'tasa predios urbanos 1984-1985',
        'parametro.tasa_urbanos_1986' => 'tasa predios urbanos 1986',
        'parametro.tasa_urbanos_ejidales' => 'tasa predios urbanos ejidales',
        'parametro.tasa_rusticos_1980' => 'tasa predios rusticos 1980',
        'parametro.tasa_rusticos_81a83' => 'tasa predios rusticos 1981-1983',
        'parametro.tasa_rusticos_84y85' => 'tasa predios rusticos 1984-1985',
        'parametro.tasa_rusticos_1986' => 'tasa predios rusticos 1986',
        'parametro.tasa_rusticos_ejidales' => 'tasa predios rusticos ejidales',
    ];

    public function actualizar(){

        $this->validate();

        try {

            $this->parametro->save();

        } catch (\Throwable $th) {
            //throw $th;
        }

    }

    public function mount(){

        $parametro = Parametro::where('oficina_id', auth()->user()->oficina_id)
                                        ->where('ejercicio_fiscal', 2026)
                                        ->first();

        if(!$parametro){

            $this->parametro = Parametro::make();

        }else{

            $this->parametro = $parametro;

        }

    }

    public function render()
    {
        return view('livewire.parametros.valores')->extends('layouts.admin');
    }
}
