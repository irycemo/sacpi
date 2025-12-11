<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Models\Uma;
use App\Models\Cuotaminima;
use Livewire\Component;
use Illuminate\Validation\Rule;


class Isai extends Component
{

    //public $avisoId;

    public $valor_adquisicion;
    public $valor_construccion_vivienda;
    public $valor_construccion_otro;
    public $porcentaje_adquisicion;
    public $sin_reduccion;
    public $valor_catastral;
    public $fecha_reduccion;
    public $fecha_reduccion_carbon;

    public $fecha_limite_pago;
    public $fecha_presentacion;
    public $multas;
    public $recargos;

    public $uma;
    public $cuota_minima;
    public $total;

    //cuando el calculo es mixto
    public $porcentaje_vivienda;
    public $porcentaje_otro_uso;
    public $total_porcentajes;

    public $valor_total_vivienda;
    public $valor_total_otro_uso;
    public $total_valores;

    public $reduccion_vivienda;
    public $reduccion_otro_uso;


    public $uso_de_predio;

    public $base_gravable;
    public $reduccion;
    public $valor_base;
    public $valor_isai;

    public function rules(){

        return [
            'valor_adquisicion' => [
                'required',
                'numeric',
                'min:0'
            ],
            'uso_de_predio' => [
                'required'
            ],
            'fecha_reduccion' => [
                'required'
            ],
            'valor_catastral' => [
                'required'
            ],
            'valor_construccion_vivienda' => [
                Rule::requiredIf($this->uso_de_predio === 'mixto'),
                'nullable',
                'numeric',
                'gt:0'
            ],
            'valor_construccion_otro' => [
                Rule::requiredIf($this->uso_de_predio === 'mixto'),
                'nullable',
                'numeric',
                'gt:0'
            ],
            'porcentaje_adquisicion' => 'nullable|numeric|max:100|gt:0',
            'sin_reduccion' => 'nullable',
        ];

    }

    protected $messages = [
        'valor_adquisicion.required' => 'El campo Valor de adquisición es requerido',
        'uso_de_predio.required' => 'El campo Uso del predio es requerido',
        'fecha_reduccion.required' => 'El campo Fecha de reducción es requerido',
        'valor_catastral.required' => 'El campo Valor Catastral o valor del avalúo es requerido',
        'valor_construccion_vivienda.required' => 'El campo Valor de la Consatrucción tipo vivienda cuando es uso mixto es requerido',
        'valor_construccion_otro.required' => 'El campo Valor de la Consatrucción otro cuando es uso mixto es requerido',
    ];


    public function calcular_fechas(){

        $this->fecha_limite_pago = Carbon::parse($this->fecha_reduccion)->addWeekdays(15)->format('Y-m-d');
        $this->fecha_presentacion = Carbon::today()->format('Y-m-d');

    }


    public function calcularIsai(){

        $this->validate();

        $this->fecha_reduccion_carbon = Carbon::parse($this->fecha_reduccion);


        if($this->fecha_reduccion_carbon->format('Y') >= 2023){

            $this->base_gravable = max($this->valor_catastral, $this->valor_adquisicion);

            if($this->valor_adquisicion > $this->valor_catastral){

                $this->base_gravable = $this->valor_adquisicion;

            }

        }else{

            $this->base_gravable = $this->valor_catastral;

        }

         $this->cuota_minima = CuotaMinima::where('municipio', auth()->user()->oficina->municipio)
                                             ->where('fecha_inicial', '<=', $this->fecha_reduccion_carbon)
                                             ->where('fecha_final', '>=', $this->fecha_reduccion_carbon)
                                             ->first();


        if(!$this->cuota_minima){

            $this->dispatch('mostrarMensaje', ['warning', "La fecha de reducción no cuenta con cuota mínima."]);

            return;

        }

        if($this->uso_de_predio === 'vivienda'){

            $this->reduccion = round($this->reduccionVivienda(), 2);

            if($this->sin_reduccion){

                $this->reduccion = 0;

            }

        }elseif($this->uso_de_predio === 'otro'){

            if($this->fecha_reduccion_carbon->format('Y') <= 2015){

                $this->reduccion = round($this->cuota_minima->diario * 365, 2);

            }else{

                $this->reduccion = round($this->cuota_minima->anual, 2);

            }

            if($this->sin_reduccion){

                $this->reduccion = 0;

            }

        }elseif($this->uso_de_predio === 'mixto'){

            $this->porcentaje_vivienda = ($this->valor_construccion_vivienda * 100) / ($this->valor_construccion_vivienda + $this->valor_construccion_otro);
            $this->porcentaje_otro_uso = 100 - $this->porcentaje_vivienda;
            $this->total_porcentajes = $this->porcentaje_vivienda + $this->porcentaje_otro_uso;

            $this->valor_total_vivienda = $this->base_gravable * ($this->porcentaje_vivienda / 100);
            $this->valor_total_otro_uso = $this->base_gravable * ($this->porcentaje_otro_uso / 100);
            $this->total_valores = $this->valor_total_vivienda + $this->valor_total_otro_uso;

            $this->reduccion_vivienda = $this->reduccionVivienda() * ($this->porcentaje_vivienda / 100);

            if($this->fecha_reduccion_carbon->format('Y') <= 2015){

                $this->reduccion_otro_uso = ($this->cuota_minima->diario * 365) * ($this->porcentaje_otro_uso / 100);

            }else{

                $this->reduccion_otro_uso = $this->cuota_minima->anual * ($this->porcentaje_otro_uso / 100);

            }

            if($this->valor_total_vivienda < $this->reduccion_vivienda){

                $this->reduccion_vivienda = $this->valor_total_vivienda;

            }

            if($this->valor_total_otro_uso < $this->reduccion_otro_uso){

                $this->reduccion_otro_uso = $this->valor_total_otro_uso;

            }

            $this->reduccion = round($this->reduccion_vivienda + $this->reduccion_otro_uso, 2);

            if($this->sin_reduccion){

                $this->reduccion = 0;

            }



        }

        $this->valor_base = round($this->base_gravable - $this->reduccion, 2);

        if($this->valor_base < 0){

            $this->valor_isai = $this->cuota_minima->cuota_minima;

        }else{

            $this->valor_isai = ceil($this->valor_base * .02);

            if($this->valor_isai < $this->cuota_minima->cuota_minima){

                $this->valor_isai = $this->cuota_minima->cuota_minima;

            }

        }

        if(! ($this->valor_adquisicion > $this->valor_catastral)){

            if($this->porcentaje_adquisicion > 0){

                $this->base_gravable = round(($this->base_gravable * $this->porcentaje_adquisicion) / 100, 2);

                $this->reduccion = round(($this->reduccion * $this->porcentaje_adquisicion) / 100, 2);

                $this->valor_base = round(($this->valor_base * $this->porcentaje_adquisicion) / 100, 2);

                $this->valor_isai = ceil(($this->valor_isai * $this->porcentaje_adquisicion) / 100);

            }

            if($this->valor_isai < $this->cuota_minima->cuota_minima){

                $this->valor_isai = $this->cuota_minima->cuota_minima;

            }

        }
        //Calcular accesorios si es necesario
        if (Carbon::parse($this->fecha_presentacion) > Carbon::parse($this->fecha_limite_pago)){
            $umaactual = Uma::where('año',Carbon::now()->year)->first();

            $this->multas = round($umaactual->diario * 4);

            $mesesvencidos = (((Carbon::now()->year - Carbon::parse($this->fecha_presentacion)->year) * 12)) + Carbon::now()->month;
            $actualizacion = 0; //Pendiente de programar, se deja por si es necesario
            $this->recargos = round(($this->valor_isai + $actualizacion) * (2*$mesesvencidos/100));
            $this->total = round($this->valor_isai + $this->multas + $this->recargos);
        }

    }

    public function reduccionVivienda(){

        if($this->fecha_reduccion_carbon->format('Y') <= 2015){

            $couta_minima_anual = $this->cuota_minima->diario * 365;

            if($this->base_gravable > 25 * $couta_minima_anual){

                return 3 * $couta_minima_anual;

            }elseif($this->base_gravable < 25 * $couta_minima_anual){

                return 15 * $couta_minima_anual;

            }

        }else{

            if($this->base_gravable > 25 * $this->cuota_minima->anual){

                return 3 * $this->cuota_minima->anual;

            }elseif($this->base_gravable < 25 * $this->cuota_minima->anual){

                return 15 * $this->cuota_minima->anual;

            }

        }

    }



    public function render()
    {
        return view('livewire.isai')->extends('layouts.admin');
    }
}
