<?php

namespace App\Livewire\Padron\Captura;

use App\Models\Predio;
use App\Models\Persona;
use Livewire\Component;
use App\Models\Propietario;
use Livewire\Attributes\On;
use App\Constantes\Constantes;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class Propietarios extends Component
{
    public $predio;
    public $predio_id;

    public $propietario;

    public $tipo_propietario;
    public $porcentaje;
    public $porcentaje_nuda;
    public $porcentaje_usufructo;
    public $tipo_persona;
    public $nombre;
    public $ap_paterno;
    public $ap_materno;
    public $curp;
    public $rfc;
    public $razon_social;
    public $fecha_nacimiento;
    public $nacionalidad;
    public $estado_civil;
    public $calle;
    public $numero_exterior_propietario;
    public $numero_interior_propietario;
    public $colonia;
    public $ciudad;
    public $cp;
    public $entidad;
    public $municipio_propietario;
    public $correo;

    public $estados;
    public $estados_civiles;
    public $editar = false;
    public $crear = false;
    public $modal;
    public $modalBorrar;
    public $partes_iguales;

    protected function rules(){
        return [
            'porcentaje' => ['numeric', 'max:100', 'nullable', Rule::requiredIf($this->porcentaje_nuda === null && $this->porcentaje_usufructo === null)],
            'porcentaje_nuda' => 'nullable|numeric|max:100',
            'porcentaje_usufructo' => 'nullable|numeric|max:100',
            'correo' => 'nullable|unique:personas',
            'tipo_persona' => 'required',
            'nombre' => [Rule::requiredIf($this->tipo_persona === 'FÍSICA')],
            'ap_paterno' => [Rule::requiredIf($this->tipo_persona === 'FÍSICA')],
            'ap_materno' => [Rule::requiredIf($this->tipo_persona === 'FÍSICA')],
            'curp' => [
                'nullable',
                'regex:/^[A-Z]{1}[AEIOUX]{1}[A-Z]{2}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM]{1}(AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]{1}[0-9]{1}$/i',
            ],
            'rfc' => [
                'nullable',
                'regex:/^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/',
            ],
            'razon_social' => ['nullable', Rule::requiredIf($this->tipo_persona === 'MORAL')],
            'fecha_nacimiento' => 'nullable',
            'nacionalidad' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'estado_civil' => 'nullable',
            'calle' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'numero_exterior_propietario' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'numero_interior_propietario' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'colonia' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'cp' => 'nullable|numeric',
            'ciudad' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'entidad' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'municipio_propietario' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
        ];
    }

    public function updated($property, $value){

        if(in_array($property, ['porcentaje_nuda', 'porcentaje_usufructo', 'porcentaje']) && $value == ''){

            $this->$property = 0;

        }

        if(in_array($property, ['porcentaje_nuda', 'porcentaje_usufructo'])){

            $this->reset('porcentaje');

        }elseif($property == 'porcentaje'){

            $this->reset(['porcentaje_nuda', 'porcentaje_usufructo']);

        }

    }

    public function updatedTipoPersona(){

        if($this->tipo_persona == 'FÍSICA'){

            $this->reset('razon_social');

        }elseif($this->tipo_persona == 'MORAL'){

            $this->reset([
                'nombre',
                'ap_paterno',
                'ap_materno',
                'curp',
                'fecha_nacimiento',
                'estado_civil',
                'rfc'
            ]);

        }

    }

    public function updatedPartesIguales($value){

        if($value){

            $this->porcentaje_nuda = 0;

            $this->porcentaje_usufructo = 0;

        }

    }

    public function resetear(){

        $this->reset([
            'tipo_propietario',
            'porcentaje_nuda',
            'porcentaje_usufructo',
            'tipo_persona',
            'nombre',
            'ap_paterno',
            'ap_materno',
            'curp',
            'rfc',
            'razon_social',
            'fecha_nacimiento',
            'nacionalidad',
            'estado_civil',
            'calle',
            'numero_exterior_propietario',
            'numero_interior_propietario',
            'colonia',
            'cp',
            'entidad',
            'municipio_propietario',
            'modal',
            'partes_iguales',
            'ciudad',
            'correo',
            'modalBorrar'
        ]);
    }

    #[On('cargarPredio')]
    public function cargarPredio($id){

        $this->predio = Predio::with('propietarios.persona')->find($id);

    }

    public function agregarPropietario(){

        if(!$this->predio->getKey()){

            $this->dispatch('mostrarMensaje', ['error', "Primero debe cargar el predio."]);

            return;

        }

        $this->modal = true;
        $this->crear = true;

    }

    public function guardarPropietario(){

        $this->validate();

        if($this->porcentaje == 0 && $this->porcentaje_nuda == 0 && $this->porcentaje_usufructo == 0){

            $this->dispatch('mostrarMensaje', ['error', "La suma de los porcentajes no puede ser 0."]);

            return;

        }

        if($this->revisarProcentajes()){

            $this->dispatch('mostrarMensaje', ['error', "La suma de los porcentajes no puede exceder el 100%."]);

            return;

        }

        try {

            DB::transaction(function () {

                $persona = Persona::query()
                                    ->where(function($q){
                                        $q->when($this->nombre, fn($q) => $q->where('nombre', $this->nombre))
                                            ->when($this->ap_paterno, fn($q) => $q->where('ap_paterno', $this->ap_paterno))
                                            ->when($this->ap_materno, fn($q) => $q->where('ap_materno', $this->ap_materno));
                                    })
                                    ->when($this->razon_social, fn($q) => $q->orWhere('razon_social', $this->razon_social))
                                    ->when($this->rfc, fn($q) => $q->orWhere('rfc', $this->rfc))
                                    ->when($this->curp, fn($q) => $q->orWhere('curp', $this->curp))
                                    ->first();

                if(!$persona){

                    $persona = Persona::create([
                        'tipo' => $this->tipo_persona,
                        'nombre' => $this->nombre,
                        'ap_paterno' => $this->ap_paterno,
                        'ap_materno' => $this->ap_materno,
                        'curp' => $this->curp,
                        'rfc' => $this->rfc,
                        'razon_social' => $this->razon_social,
                        'fecha_nacimiento' => $this->fecha_nacimiento,
                        'nacionalidad' => $this->nacionalidad,
                        'estado_civil' => $this->estado_civil,
                        'calle' => $this->calle,
                        'numero_exterior' => $this->numero_exterior_propietario,
                        'numero_interior' => $this->numero_interior_propietario,
                        'colonia' => $this->colonia,
                        'ciudad' => $this->ciudad,
                        'correo' => $this->correo,
                        'cp' => $this->cp,
                        'entidad' => $this->entidad,
                        'municipio' => $this->municipio_propietario,
                        'creado_por' => auth()->id()
                    ]);

                }else{

                    $this->validate([
                        'correo' => 'nullable|unique:personas,correo,' . $persona->id,
                        'curp' => 'nullable|unique:personas,curp,' . $persona->id,
                        'rfc' => 'nullable|unique:personas,rfc,' . $persona->id,
                    ]);

                    $persona->update([
                        'tipo' => $this->tipo_persona,
                        'nombre' => $this->nombre,
                        'ap_paterno' => $this->ap_paterno,
                        'ap_materno' => $this->ap_materno,
                        'curp' => $this->curp,
                        'rfc' => $this->rfc,
                        'razon_social' => $this->razon_social,
                        'fecha_nacimiento' => $this->fecha_nacimiento,
                        'nacionalidad' => $this->nacionalidad,
                        'estado_civil' => $this->estado_civil,
                        'calle' => $this->calle,
                        'numero_exterior' => $this->numero_exterior_propietario,
                        'numero_interior' => $this->numero_interior_propietario,
                        'colonia' => $this->colonia,
                        'ciudad' => $this->ciudad,
                        'correo' => $this->correo,
                        'cp' => $this->cp,
                        'entidad' => $this->entidad,
                        'municipio' => $this->municipio_propietario,
                        'actualizado_por' => auth()->id()
                    ]);

                }

                if($this->predio->propietarios()->where('persona_id', $persona->id)->first()){

                    $this->dispatch('mostrarMensaje', ['error', "La persona ya es un propietario."]);

                    return;

                }

                $this->predio->propietarios()->create([
                    'persona_id' => $persona->id,
                    'tipo' => 'PROPIETARIO',
                    'porcentaje_propiedad' => $this->porcentaje,
                    'porcentaje_nuda' => $this->porcentaje_nuda,
                    'porcentaje_usufructo' => $this->porcentaje_usufructo,
                    'creado_por' => auth()->id()
                ]);

                $this->predio->touch();

                $this->predio->audits()->latest()->first()->update(['tags' => 'Agregó propietario']);

                $this->dispatch('mostrarMensaje', ['success', "El propietario se guardó con éxito."]);

                $this->resetear();

                $this->predio->refresh();

                $this->predio->load('propietarios.persona');

            });

        } catch (ValidationException $th) {

            $this->dispatch('mostrarMensaje', ['error', $th->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al guardar propietario en captura del padrón por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function actualizarActor(){

        $this->validate([
            'porcentaje' => ['numeric', 'max:100', 'nullable', Rule::requiredIf($this->porcentaje_nuda === null && $this->porcentaje_usufructo === null)],
            'porcentaje_nuda' => 'nullable|numeric|max:100',
            'porcentaje_usufructo' => 'nullable|numeric|max:100',
            'correo' => 'nullable|unique:personas,correo,' . $this->propietario->persona->id,
            'tipo_persona' => 'required',
            'nombre' => [Rule::requiredIf($this->tipo_persona === 'FÍSICA')],
            'ap_paterno' => [Rule::requiredIf($this->tipo_persona === 'FÍSICA')],
            'ap_materno' => [Rule::requiredIf($this->tipo_persona === 'FÍSICA')],
            'curp' => [
                'nullable',
                'regex:/^[A-Z]{1}[AEIOUX]{1}[A-Z]{2}[0-9]{2}(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[HM]{1}(AS|BC|BS|CC|CS|CH|CL|CM|DF|DG|GT|GR|HG|JC|MC|MN|MS|NT|NL|OC|PL|QT|QR|SP|SL|SR|TC|TS|TL|VZ|YN|ZS|NE)[B-DF-HJ-NP-TV-Z]{3}[0-9A-Z]{1}[0-9]{1}$/i',
            ],
            'rfc' => [
                'nullable',
                'regex:/^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/',
            ],
            'razon_social' => ['nullable', Rule::requiredIf($this->tipo_persona === 'MORAL')],
            'fecha_nacimiento' => 'nullable',
            'nacionalidad' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'estado_civil' => 'nullable',
            'calle' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'numero_exterior_propietario' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'numero_interior_propietario' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'colonia' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'cp' => 'nullable|numeric',
            'ciudad' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'entidad' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
            'municipio_propietario' => 'nullable|' . utf8_encode('regex:/^[áéíóúÁÉÍÓÚñÑa-zA-Z-0-9$#.() ]*$/'),
        ]);

        if($this->porcentaje == 0 && $this->porcentaje_nuda == 0 && $this->porcentaje_usufructo == 0){

            $this->dispatch('mostrarMensaje', ['error', "La suma de los porcentajes no puede ser 0."]);

            return;

        }

        if($this->revisarProcentajes($this->propietario->id)){

            $this->dispatch('mostrarMensaje', ['error', "La suma de los porcentajes no puede exceder el 100%."]);

            return;

        }

        $persona = Persona::query()
                        ->where(function($q){
                            $q->when($this->nombre, fn($q) => $q->where('nombre', $this->nombre))
                                ->when($this->ap_paterno, fn($q) => $q->where('ap_paterno', $this->ap_paterno))
                                ->when($this->ap_materno, fn($q) => $q->where('ap_materno', $this->ap_materno));
                        })
                        ->when($this->razon_social, fn($q) => $q->orWhere('razon_social', $this->razon_social))
                        ->when($this->rfc, fn($q) => $q->orWhere('rfc', $this->rfc))
                        ->when($this->curp, fn($q) => $q->orWhere('curp', $this->curp))
                        ->when($this->correo, fn($q) => $q->orWhere('correo', $this->correo))
                        ->first();

        try {

            DB::transaction(function () use($persona){

                if($persona){

                    $this->propietario->persona->update([
                        'tipo' => $this->tipo_persona,
                        'nombre' => $this->nombre,
                        'ap_paterno' => $this->ap_paterno,
                        'ap_materno' => $this->ap_materno,
                        'razon_social' => $this->razon_social,
                        'fecha_nacimiento' => $this->fecha_nacimiento,
                        'nacionalidad' => $this->nacionalidad,
                        'estado_civil' => $this->estado_civil,
                        'calle' => $this->calle,
                        'rfc' => $this->rfc,
                        'curp' => $this->curp,
                        'numero_exterior' => $this->numero_exterior_propietario,
                        'numero_interior' => $this->numero_interior_propietario,
                        'colonia' => $this->colonia,
                        'ciudad' => $this->ciudad,
                        'correo' => $this->correo,
                        'cp' => $this->cp,
                        'entidad' => $this->entidad,
                        'municipio' => $this->municipio_propietario,
                        'actualizado_por' => auth()->id()
                    ]);

                }else{

                    $this->validate([
                        'correo' => 'nullable|unique:personas,correo',
                        'curp' => 'nullable|unique:personas,curp',
                        'rfc' => 'nullable|unique:personas,rfc',
                    ]);

                    $persona = Persona::create([
                        'tipo' => $this->tipo_persona,
                        'nombre' => $this->nombre,
                        'ap_paterno' => $this->ap_paterno,
                        'ap_materno' => $this->ap_materno,
                        'curp' => $this->curp,
                        'rfc' => $this->rfc,
                        'razon_social' => $this->razon_social,
                        'fecha_nacimiento' => $this->fecha_nacimiento,
                        'nacionalidad' => $this->nacionalidad,
                        'estado_civil' => $this->estado_civil,
                        'calle' => $this->calle,
                        'numero_exterior' => $this->numero_exterior_propietario,
                        'numero_interior' => $this->numero_interior_propietario,
                        'colonia' => $this->colonia,
                        'ciudad' => $this->ciudad,
                        'correo' => $this->correo,
                        'cp' => $this->cp,
                        'entidad' => $this->entidad,
                        'municipio' => $this->municipio_propietario,
                        'creado_por' => auth()->id()
                    ]);

                }

                $this->propietario->update([
                    'persona_id' => $persona->id,
                    'tipo' => $this->tipo_propietario,
                    'porcentaje_proopiedad' => $this->porcentaje,
                    'porcentaje_nuda' => $this->porcentaje_nuda,
                    'porcentaje_usufructo' => $this->porcentaje_usufructo,
                    'actualizado_por' => auth()->id()
                ]);

                $this->dispatch('mostrarMensaje', ['success', "La información se actualizó con éxito."]);

                $this->predio->touch();

                $this->predio->audits()->latest()->first()->update(['tags' => 'Agregó propietario']);

                $this->resetear();

                $this->predio->refresh();

                $this->predio->load('propietarios.persona');

            });

        } catch (ValidationException $th) {

            $this->dispatch('mostrarMensaje', ['error', $th->getMessage()]);

        } catch (\Throwable $th) {

            Log::error("Error al actualizar actor en captura del padrón por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function editarPropietario(Propietario $propietario){

        $this->resetear();

        $this->propietario = $propietario;

        $this->tipo_persona = $this->propietario->persona->tipo;
        $this->tipo_propietario = $this->propietario->tipo;
        $this->porcentaje = $this->propietario->porcentaje;
        $this->porcentaje_nuda = $this->propietario->porcentaje_nuda;
        $this->porcentaje_usufructo = $this->propietario->porcentaje_usufructo;
        $this->nombre = $this->propietario->persona->nombre;
        $this->ap_paterno = $this->propietario->persona->ap_paterno;
        $this->ap_materno = $this->propietario->persona->ap_materno;
        $this->curp = $this->propietario->persona->curp;
        $this->rfc = $this->propietario->persona->rfc;
        $this->razon_social = $this->propietario->persona->razon_social;
        $this->fecha_nacimiento = $this->propietario->persona->fecha_nacimiento;
        $this->nacionalidad = $this->propietario->persona->nacionalidad;
        $this->estado_civil = $this->propietario->persona->estado_civil;
        $this->calle = $this->propietario->persona->calle;
        $this->numero_exterior_propietario = $this->propietario->persona->numero_exterior;
        $this->numero_interior_propietario = $this->propietario->persona->numero_interior;
        $this->colonia = $this->propietario->persona->colonia;
        $this->ciudad = $this->propietario->persona->ciudad;
        $this->ciudad = $this->propietario->persona->ciudad;
        $this->cp = $this->propietario->persona->cp;
        $this->correo = $this->propietario->persona->correo;
        $this->entidad = $this->propietario->persona->entidad;
        $this->municipio_propietario = $this->propietario->persona->municipio;

        $this->modal = true;

        $this->crear = false;

        $this->editar = true;

    }

    public function borrar(Propietario $propietario){

        try {

            $propietario->delete();

            $this->predio->touch();

            $this->predio->audits()->latest()->first()->update(['tags' => 'Borró propietario']);

            $this->dispatch('mostrarMensaje', ['success', "La información se eliminó con éxito."]);

            $this->resetear();

            $this->predio->load('propietarios.persona');

        } catch (\Throwable $th) {

            Log::error("Error al borrar propietario en captura de l padrón por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function borrarPropietarios(){

        if(!$this->predio->getKey()){

            $this->dispatch('mostrarMensaje', ['error', "Primero debe cargar el predio."]);

            return;

        }

        try {

            $this->predio->propietarios()->delete();

            $this->dispatch('mostrarMensaje', ['success', "La información se eliminó con éxito."]);

            $this->resetear();

            $this->predio->refresh();

            $this->predio->load('propietarios.persona');

            $this->predio->touch();

            $this->predio->audits()->latest()->first()->update(['tags' => 'Borró todos los propietarios']);

        } catch (\Throwable $th) {

            Log::error("Error al borrar propietario en captura de l padrón por el usuario: (id: " . auth()->user()->id . ") " . auth()->user()->name . ". " . $th);
            $this->dispatch('mostrarMensaje', ['error', "Ha ocurrido un error."]);

        }

    }

    public function repartirPartesIguales($flag = false){

        $propietarios = $flag ? $this->predio->propietarios->count() + 1 : $this->predio->propietarios->count();

        $porcentaje = 100 / $propietarios;

        foreach ($this->predio->propietarios as $propietario) {

            $propietario->update([
                'porcentaje_nuda' => $porcentaje,
                'porcentaje_usufructo' => $porcentaje
            ]);

        }

        return $porcentaje;

    }

    public function revisarProcentajes($id = null){

        $pn = 0;

        $pu = 0;

        $pp = 0;

        foreach($this->predio->propietarios as $propietario){

            if($id == $propietario->id) continue;

            $pn = $pn + $propietario->porcentaje_nuda;

            $pu = $pu + $propietario->porcentaje_usufructo;

            $pp = $pp + $propietario->porcentaje_propiedad;

        }

        $pp = $pp + (float)$this->porcentaje;

        $pn = $pn + (float)$this->porcentaje_nuda + $pp;

        $pu = $pu + (float)$this->porcentaje_usufructo + $pp;

        if($pn > 100 || $pu > 100)
            return true;
        else
            return false;

    }

    public function guardar(){

        if(!$this->predio->getKey()){

            $this->dispatch('mostrarMensaje', ['error', "Primero debe cargar el predio."]);

            return;

        }

        if($this->predio->propietarios->count() === 0){

            $this->dispatch('mostrarMensaje', ['error', "No hay propietarios."]);

            return;

        }

        $pn = 0;

        $pu = 0;

        $pp = 0;

        foreach($this->predio->propietarios as $propietario){

            $pn = $pn + $propietario->porcentaje_nuda;

            $pu = $pu + $propietario->porcentaje_usufructo;

            $pp = $pp + $propietario->porcentaje_propiedad;

        }

        if($pp != 0){

            if(($pn + $pp) != 100){

                $this->dispatch('mostrarMensaje', ['error', "La suma de los porcentajes de nuda no es el 100%."]);

                return;

            }

            if(($pu + $pp) != 100){

                $this->dispatch('mostrarMensaje', ['error', "La suma de los porcentajes de usufructo no es el 100%."]);

                return;

            }

        }else{

            if($pn != 100){

                $this->dispatch('mostrarMensaje', ['error', "La suma de los porcentajes de nuda no es el 100%."]);

                return;

            }

            if($pu != 100){

                $this->dispatch('mostrarMensaje', ['error', "La suma de los porcentajes de usufructo no es el 100%."]);

                return;

            }

        }

        $this->dispatch('mostrarMensaje', ['success', "Se guardo la información con éxito."]);

    }

    public function mount(){

        $this->estados = Constantes::ESTADOS;

        $this->estados_civiles = Constantes::ESTADO_CIVIL;

        if($this->predio_id)
            $this->predio = Predio::with('propietarios', 'transmitentes')->find($this->predio_id);
        else
            $this->predio = Predio::make();

    }
    public function render()
    {
        return view('livewire.padron.captura.propietarios');
    }
}
