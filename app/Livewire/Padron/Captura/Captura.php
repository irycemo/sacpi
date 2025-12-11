<?php

namespace App\Livewire\Padron\Captura;

use Carbon\Carbon;
use App\Models\Uma;
use App\Models\Predio;
use App\Models\Notaria;
use App\Models\Oficina;
use Livewire\Component;
use App\Constantes\Constantes;
use Illuminate\Validation\Rule;
use App\Models\FactorIncremento;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Services\Coordenadas\Coordenadas;

class Captura extends Component
{
    public $tipoVialidades;
    public $tipoAsentamientos;
    public $acciones_alta;
    public $acciones_baja;
    public $acciones_actualizacion;
    public $documentos;
    public $notarias;
    public $accion;

    public $actualizacion = true;
    public $modalIndexar = false;
    public $modalBaja = false;
    public $label = 'Número de documento';

    public Predio $predio;
    public $origen;
    public $observaciones;

    public $tipos_asentamientos;
    public $nombres_asentamientos = [];
    public $tipos_vialidades;
    public $tipo_asentamiento;
    public $codigos_postales;

    protected function rules(){
        return [
            'predio.numero_registro' => 'required|numeric|min:1',
            'predio.region_catastral' => 'required|numeric|min:1',
            'predio.municipio' => 'required|numeric|min:1',
            'predio.localidad' => 'required|numeric|min:1',
            'predio.sector' => 'required|numeric|min:1',
            'predio.zona_catastral' => 'required|numeric|min:1,|same:predio.localidad',
            'predio.manzana' => 'required|numeric|min:1',
            'predio.predio' => 'required|numeric|min:1',
            'predio.edificio' => 'required|numeric|min:0',
            'predio.departamento' => 'required|numeric|min:0',
            'predio.tipo_predio' => 'required|numeric|min:1|max:2',
            'predio.oficina' => 'required|numeric|min:1',
            'predio.estado' => 'required',
            'predio.tipo_asentamiento' => 'required',
            'predio.nombre_asentamiento' => 'required',
            'predio.tipo_vialidad' => 'required',
            'predio.nombre_vialidad' => 'required',
            'predio.numero_exterior' => 'required',
            'predio.numero_exterior_2' => 'nullable',
            'predio.numero_interior' => 'nullable',
            'predio.numero_adicional_2' => 'nullable',
            'predio.numero_adicional' => 'nullable',
            'predio.codigo_postal' => 'required|numeric',
            'predio.lote_fraccionador' => 'nullable',
            'predio.manzana_fraccionador' => 'nullable',
            'predio.etapa_fraccionador' => 'nullable',
            'predio.nombre_predio'  => 'nullable',
            'predio.nombre_edificio' => 'nullable',
            'predio.clave_edificio' => 'nullable',
            'predio.departamento_edificio' => 'nullable',
            'predio.xutm' => 'nullable|string',
            'predio.yutm' => 'nullable|string',
            'predio.zutm' => 'nullable',
            'predio.lat' => 'required|numeric',
            'predio.lon' => 'required|numeric',
            'predio.superficie_total_terreno' => 'required|numeric',
            'predio.superficie_total_construccion' => 'nullable|numeric',
            'predio.superficie_judicial' => 'nullable|numeric',
            'predio.superficie_notarial' => 'nullable|numeric',
            'predio.valor_catastral' => 'required|numeric',
            'predio.documento_entrada' => Rule::requiredIf(!$this->actualizacion),
            'predio.declarante' => Rule::requiredIf(!$this->actualizacion),
            'predio.documento_numero' => Rule::requiredIf(!$this->actualizacion),
            'predio.fecha_efectos' => Rule::requiredIf(!$this->actualizacion),
            'accion' => 'required',
            'predio.observaciones' => 'required',
            'observaciones' => 'required',
         ];
    }

    public function crearModeloVacio(){
        return Predio::make([
            'estado' => 16,
            'edificio' => 0,
            'departamento' => 0
        ]);
    }

    public function updatedPredioLocalidad(){

        $this->predio->zona_catastral = $this->predio->localidad;

    }

    public function updatedPredioDocumentoEntrada($value){

        if(in_array($value, ['TÍTULO DE PROPIEDAD PARCELARIO','TÍTULO DE PROPIEDAD SOLAR URBANO'])){

            $this->label = 'Número de titulo';

        }elseif(in_array($value, ['ESCRITURA PÚBLICA', 'ESCRITURA PRIVADA'])){

            $this->label = 'Número de escritura';

        }else{

            $this->label = 'Número de documento';

        }

    }

    /*Cuando cambiar de Actualización a Captura */
    public function updatedActualizacion(){

        $this->predio = $this->crearModeloVacio();

        $this->predio->oficina = auth()->user()->oficina->oficina;
        $this->predio->municipio = auth()->user()->oficina->municipio;
        $this->predio->region_catastral = auth()->user()->oficina->region;


    }

    public function updatedPredioOficina(){

        $oficina = Oficina::where('oficina', $this->predio->oficina)->first();

        $this->predio->municipio = $oficina?->municipio;
        $this->predio->region_catastral = $oficina?->region;
        $this->predio->zona_catastral = $this->predio->localidad;

    }

    public function updated($value){

        if(in_array($value, ['predio.xutm', 'predio.yutm','predio.zutm', 'predio.lat', 'predio.lon']))
            $this->convertirCoordenadas();

    }

    public function resetearCoordenadas(){

        $this->reset([
            'predio.xutm',
            'predio.yutm',
            'predio.zutm',
            'predio.lat' ,
            'predio.lon' ,
        ]);

    }

    public function convertirCoordenadas(){

        if($this->predio->xutm && $this->predio->yutm && $this->predio->zutm){

            $ll = (new Coordenadas())->utm2ll($this->predio->xutm, $this->predio->yutm, $this->predio->zutm, true);

            if(!$ll['success']){

                $this->dispatch('mostrarMensaje', ['error', $ll['msg']]);

                return;

            }else{

                $this->predio->lat = $ll['attr']['lat'];
                $this->predio->lon = $ll['attr']['lon'];

            }


        }elseif($this->predio->lat && $this->predio->lon){

            $ll = (new Coordenadas())->ll2utm($this->predio->lat, $this->predio->lon);

            if(!$ll['success']){

                $this->dispatch('mostrarMensaje', ['error', $ll['msg']]);

                return;

            }else{

                if((float)$ll['attr']['zone'] < 13 || (float)$ll['attr']['zone'] > 14){

                    $this->dispatch('mostrarMensaje', ['error', "Las coordenadas no corresponden a una zona válida."]);

                    $this->predio->lat = null;
                    $this->predio->lon = null;

                    return;

                }

                $this->predio->xutm = strval($ll['attr']['x']);
                $this->predio->yutm = strval($ll['attr']['y']);
                $this->predio->zutm = $ll['attr']['zone'];

            }

        }


    }

    public function buscarCuentaPredial(){

        try {

            $this->predio = Predio::where('estado', '!=', 'notificado')
                                    ->where('numero_registro', $this->predio->numero_registro)
                                    ->where('tipo_predio', $this->predio->tipo_predio)
                                    ->where('localidad', $this->predio->localidad)
                                    ->where('oficina', $this->predio->oficina)
                                    ->firstOrFail();

            if($this->predio->bloqueadoActivo()){

                $this->dispatch('mostrarMensaje', ['error', "El predio se encuentra bloqueado."]);
                $this->predio = $this->crearModeloVacio();
                return;

            }

            if($this->predioInactivo()) return;

            $this->dispatch('cargarPredio', id: $this->predio->id, flag: true);

        } catch (\Throwable $th) {

            $this->dispatch('mostrarMensaje', ['error', "No se encontro predio con la cuenta predial ingresada."]);

        }

    }

    public function buscarClaveCatastral(){

        try {

            $this->predio = Predio::where('estado', 16)
                                    ->where('status', '!=', 'notificado')
                                    ->where('region_catastral', $this->predio->region_catastral)
                                    ->where('municipio', $this->predio->municipio)
                                    ->where('zona_catastral', $this->predio->zona_catastral)
                                    ->where('localidad', $this->predio->localidad)
                                    ->where('sector', $this->predio->sector)
                                    ->where('manzana', $this->predio->manzana)
                                    ->where('predio', $this->predio->predio)
                                    ->where('edificio', $this->predio->edificio)
                                    ->where('departamento', $this->predio->departamento)
                                    ->firstOrFail();

            if($this->predio->bloqueadoActivo()){

                $this->dispatch('mostrarMensaje', ['error', "El predio se encuentra bloqueado."]);
                $this->predio = $this->crearModeloVacio();
                return;

            }

            if($this->predioInactivo()) return;

            $this->dispatch('cargarPredio', $this->predio->id, flag: true);

        } catch (\Throwable $th) {

            $this->dispatch('mostrarMensaje', ['error', "No se encontro predio con la clave catastral ingresada."]);

        }

    }

    public function predioInactivo(){

        if($this->predio->status != 'activo'){

            $this->dispatch('mostrarMensaje', ['error', "El predio no esta activo."]);

            $this->predio = $this->crearModeloVacio();

            return true;

        }

    }

    public function indexar(){

        if(intval(Carbon::parse($this->predio->indexado_en)->format('Y')) == intval(now()->format('Y'))){

            $this->modalIndexar = false;

            $this->dispatch('mostrarMensaje', ['warning', "El valor catastral del predio ya ha sido indexado al año actual."]);

            return;

        }

        $factores = FactorIncremento::orderBy('año')->get();

        $valor = $this->predio->valor_catastral;

        $año = Carbon::parse($this->predio->fecha_efectos)->format('Y');

        foreach($factores as $factor){

            if($factor->año >= intval($año)){


                $valor = $valor * $factor->factor;

            }

        }

        try {

            DB::transaction(function () use($valor){

                $this->predio->valor_catastral = $valor;

                $this->predio->indexado_en = now();

                $this->predio->save();

                $this->predio->audits()->latest()->first()->update(['tags' => 'Indexó predio']);

                $this->dispatch('mostrarMensaje', ['success', "El valor del predio se indexó correctamente."]);

                $this->modalIndexar = false;

            });

        } catch (\Throwable $th) {

            Log::error("Error al indexar predio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function darDeBaja(){

        $this->validate([
            'origen' => 'required',
            'observaciones' => 'required'
        ]);

        try {

            DB::transaction(function () {

                $this->predio->update([
                    'status' => 'baja',
                    'actualizado_por' => auth()->id(),
                    'observaciones' => $this->predio->observaciones . '. ' . $this->observaciones
                ]);

                $this->predio->audits()->latest()->first()->update(['tags' => 'Dio de baja predio']);

                $this->dispatch('mostrarMensaje', ['success', "El predio se dió de baja correctamente."]);

                $this->modalBaja = false;

                $this->predio = $this->crearModeloVacio();

            });

        } catch (\Throwable $th) {

            Log::error("Error al dar de baja predio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function validarDisponibilidad(){

        $predioCompleto = Predio::where('estado', $this->predio->estado)
                                    ->where('region_catastral', $this->predio->region_catastral)
                                    ->where('municipio', $this->predio->municipio)
                                    ->where('zona_catastral', $this->predio->zona_catastral)
                                    ->where('localidad', $this->predio->localidad)
                                    ->where('sector', $this->predio->sector)
                                    ->where('manzana', $this->predio->manzana)
                                    ->where('predio', $this->predio->predio)
                                    ->where('edificio', $this->predio->edificio)
                                    ->where('departamento', $this->predio->departamento)
                                    ->where('oficina', $this->predio->oficina)
                                    ->where('tipo_predio', $this->predio->tipo_predio)
                                    ->where('numero_registro', $this->predio->numero_registro)
                                    ->first();

        if(!$predioCompleto){

            $cuentaPredial = Predio::where('localidad', $this->predio->localidad)
                                        ->where('oficina', $this->predio->oficina)
                                        ->where('tipo_predio', $this->predio->tipo_predio)
                                        ->where('numero_registro', $this->predio->numero_registro)
                                        ->first();

            if($cuentaPredial){

                $this->dispatch('mostrarMensaje', ['error', "La cuenta predial ya existe en el padrón con otra clave catastral, verifique."]);

                return true;

            }

            $claveCatastral = Predio::where('status', '!=', 'notificado')
                                        ->where('estado', $this->predio->estado)
                                        ->where('region_catastral', $this->predio->region_catastral)
                                        ->where('municipio', $this->predio->municipio)
                                        ->where('zona_catastral', $this->predio->zona_catastral)
                                        ->where('localidad', $this->predio->localidad)
                                        ->where('sector', $this->predio->sector)
                                        ->where('manzana', $this->predio->manzana)
                                        ->where('predio', $this->predio->predio)
                                        ->where('edificio', $this->predio->edificio)
                                        ->where('departamento', $this->predio->departamento)
                                        ->first();

            if($claveCatastral){

                $this->dispatch('mostrarMensaje', ['error', "La clave catastral ya existe en el padrón con otra cuenta predial, verifique."]);

                return true;

            }

        }

    }

    public function validarSector(){

        $oficina = Oficina::where('localidad', $this->predio->localidad)
                            ->where('oficina', $this->predio->oficina)
                            ->first();

        if(!$oficina){

            $this->dispatch('mostrarMensaje', ['error', "No se encontraron oficinas con los datos ingresados."]);

            return true;

        }

        $sectores = json_decode($oficina->sectores, true);

        if(!$sectores){

            $this->dispatch('mostrarMensaje', ['error', "La zona no tiene sectores."]);

            return true;

        }

        if(!in_array($this->predio->sector, $sectores)){

            $this->dispatch('mostrarMensaje', ['error', "El sector no corresponde a la zona."]);

            return true;

        }

        if($oficina->municipio != $this->predio->municipio){

            $this->dispatch('mostrarMensaje', ['error', "El municipio no corresponde a la oficina."]);

            return true;

        }

    }

    public function validarTitulo(){

        $predio = Predio::whereIn('documento_entrada', ['TÍTULO DE PROPIEDAD PARCELARIO', 'TÍTULO DE PROPIEDAD SOLAR URBANO'])
                            ->where('documento_numero', $this->predio->documento_numero)
                            ->first();

        if($predio){

            $this->dispatch('mostrarMensaje', ['error', "el título de propiedad ya esta registrado, verifique."]);

            return true;

        }

    }

    public function crear(){

        if ($this->revisaUMA()){

            $this->dispatch('mostrarMensaje', ['error', "El valor de la UMA del ejercicio fiscal actual no estan dada de alta, favor de verificar"]);

            return;

        }

        $this->validate();

        if($this->validarDisponibilidad() || $this->validarSector() || $this->validarTitulo()) return;

        try {

            DB::transaction(function () {

                $this->predio->creado_por = auth()->id();
                $this->predio->valor_catastral = $this->revisarValorMinimo($this->predio->valor_catastral);
                $this->predio->save();

                $this->predio->audits()->latest()->first()->update(['tags' => 'Dió de alta predio']);

                $this->predio->movimientos()->create([
                    'nombre' => $this->accion,
                    'fecha' => now()->toDateString(),
                    'descripcion' => $this->observaciones,
                    'creado_por' => auth()->id()
                ]);

                $this->dispatch('cargarPredio', id:$this->predio->id, flag:true);

                $this->dispatch('mostrarMensaje', ['success', "El predio se dió de alta correctamente."]);

                $this->reset(['origen', 'observaciones']);

                $this->actualizacion = true;

            });

        } catch (\Throwable $th) {

            Log::error("Error al crear predio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function actualizar(){

        $this->validate();

        if ($this->revisaUMA()){
            $this->dispatch('mostrarMensaje', ['error', "El valor de la UMA del ejercicio fiscal actual no estan dada de alta, favor de verificar"]);
            return;
        }

        if($this->validarDisponibilidad() || $this->validarSector()) return;

        try {

            DB::transaction(function () {

                $this->predio->actualizado_por = auth()->id();
                $this->predio->observaciones = $this->observaciones . '. ' . $this->observaciones;
                $this->predio->valor_catastral = $this->revisarValorMinimo($this->predio->valor_catastral);
                $this->predio->save();

                $this->predio->audits()->latest()->first()->update(['tags' => 'Actualizo información de identificación']);

                $this->predio->movimientos()->create([
                    'nombre' => $this->accion,
                    'fecha' => now()->toDateString(),
                    'descripcion' => $this->observaciones,
                    'creado_por' => auth()->id()
                ]);

                $this->dispatch('mostrarMensaje', ['success', "El predio se actualizó correctamente."]);

                $this->reset(['origen', 'observaciones']);

            });

        } catch (\Throwable $th) {

            Log::error("Error al actualizar predio por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Hubo un error."]);

        }

    }

    public function revisaUMA(){

        $uma = Uma::where('año', now()->format('Y'))->first();

        if ($uma === null)

            return true;

        else

            return false;

    }

    public function revisarValorMinimo($valor){

        $uma = Uma::where('año', now()->format('Y'))->first();

        if($this->predio->tipo_predio == 1 && $this->predio->valor_catastral < $uma->minimo_urbano) return $uma->minimo_urbano;

        if($this->predio->tipo_predio == 2 && $this->predio->valor_catastral < $uma->minimo_rustico) return $uma->minimo_rustico;

        return ceil($valor);

    }

    public function mount(){

        $this->acciones_alta = array_keys(Constantes::MOVIMIENTOS, 'ALTA');

        $this->acciones_baja = array_keys(Constantes::MOVIMIENTOS, 'BAJA');

        $this->acciones_actualizacion = array_keys(Constantes::MOVIMIENTOS, 'ACTUALIZACION');

        $this->tipoVialidades = Constantes::TIPO_VIALIDADES;

        $this->tipoAsentamientos = Constantes::TIPO_ASENTAMIENTO;

        $this->documentos = Constantes::DOCUMENTO_ENTRADA;

        $this->notarias = Notaria::all();

        $this->predio = $this->crearModeloVacio();

        $this->predio->oficina = auth()->user()->oficina->oficina;

        $this->predio->municipio = auth()->user()->oficina->municipio;

        $this->predio->region_catastral = auth()->user()->oficina->region;

    }

    public function render()
    {
        return view('livewire.padron.captura.captura')->extends('layouts.admin');
    }
}
