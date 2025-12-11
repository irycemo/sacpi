<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Pago;
use App\Models\Bloqueo;
use App\Models\Factura;
use App\Models\Parametro;
use App\Models\Constancia;
use App\Models\Propietario;
use App\Traits\ModelosTrait;
use App\Models\Requerimiento;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Predio extends Model implements Auditable
{

    use HasFactory;
    use ModelosTrait;
    use \OwenIt\Auditing\Auditable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getEstadoColorAttribute()
    {
        return [
            'nuevo' => 'blue-400',
            'activo' => 'green-400',
            'baja' => 'gray-400',
            'bloqueado' => 'black',
        ][$this->status] ?? 'gray-400';
    }

    public function propietarios(){
        return $this->hasMany(Propietario::class);
    }

    public function colindancias(){
        return $this->hasMany(Colindancia::class);
    }

    public function movimientos(){
        return $this->hasMany(Movimiento::class)->orderBy('fecha', 'desc');
    }

    public function bloqueos(){
        return $this->hasMany(Bloqueo::class);
    }

    public function facturas(){
        return $this->hasMany(Factura::class);
    }

    public function facturasEjercicioActual(){
        return $this->hasMany(Factura::class)->where('ejercicio_fiscal', now()->format('Y'))->whereNUll('pago_id');
    }

    public function facturasRezago(){
        return $this->hasMany(Factura::class)->where('status', 'rezago');
    }

    public function pagos(){
        return $this->hasMany(Pago::class);
    }

    public function requerimientos(){
        return $this->hasMany(Requerimiento::class);
    }

    public function constancias(){
        return $this->hasMany(Constancia::class);
    }

    public function invitaciones(){
        return $this->hasMany(Invitacion::class);
    }

    public function bloqueadoActivo(){
        return $this->bloqueos->where('estado', 'activo')->count() > 0 ? true : false;
    }

    public function cuentaPredial(){

        return $this->localidad . '-' . $this->oficina . '-' . $this->tipo_predio . '-' . $this->numero_registro;

    }

    public function claveCatastral(){

        return $this->estado . '-' . $this->region_catastral . '-' . $this->municipio . '-' . $this->zona_catastral . '-' . $this->localidad . '-' . $this->sector . '-' . $this->manzana . '-' . $this->predio . '-' . $this->edificio . '-' . $this->departamento;

    }

    public function anioFechaEfectos(){

        return Carbon::parse($this->fecha_efectos)->year;

    }

    public function ubicacion(){

        return $this->nombre_vialidad . ', ' . $this->numero_exterior . ', ' . $this->nombre_asentamiento;

    }

    public function tipoCuota(){

        $ejercicio_fiscal = Parametro::where('ejercicio_fiscal', Carbon::now()->year)->first();

        $tipocuota = "superior a mínima";

        $anio = $this->anioFechaEfectos();

        switch ($anio)
        {
            case ($anio <= 1980):
                if ($this->tipo_predio == 1)
                    $tasa = $ejercicio_fiscal->tasa_urbanos_1980;
                else
                    $tasa = $ejercicio_fiscal->tasa_rusticos_1980;
                break;
            case ($anio >= 1981 && $anio <= 1983):
                if ($this->tipo_predio == 1)
                    $tasa = $ejercicio_fiscal->tasa_urbanos_81a83;
                else
                    $tasa = $ejercicio_fiscal->tasa_rusticos_81a83;
                break;
            case ($anio >= 1984 && $anio <= 1985):
                if ($this->tipo_predio == 1)
                    $tasa = $ejercicio_fiscal->tasa_urbanos_84y85;
                else
                    $tasa = $ejercicio_fiscal->tasa_rusticos_84y85;
                break;
            case ($anio >= 1986):
                if ($this->tipo_predio == 1)
                    $tasa = $ejercicio_fiscal->tasa_urbanos_1986;
                else
                    $tasa = $ejercicio_fiscal->tasa_rusticos_1986;
                break;
        }

        $impuesto_anual = ($tasa/100) * $this->valor_catastral;

        switch ($this->tipo_predio)
        {
            case 1:
                if ($impuesto_anual < $ejercicio_fiscal->cuota_minima_predial_urbanos){
                    $tipocuota = "mínima";
                }

                break;
            case 2:
                if ($impuesto_anual < $ejercicio_fiscal->cuota_minima_predial_rusticos){
                    $tipocuota = "mínima";
                }

                break;
            case 3:
                if ($impuesto_anual < $ejercicio_fiscal->cuota_minima_ejidal_urbanos){
                    $tipocuota = "mínima";
                }

                break;
            case 4:
                if ($impuesto_anual < $ejercicio_fiscal->cuota_minima_ejidal_rusticos){
                    $tipocuota = "mínima";
                }
                break;
        }

        return $tipocuota;

    }

    public function primerPropietario(){

        $propietario = $this->propietarios->first();

        if(!$propietario) return null;

        return $propietario->persona->nombre . ' ' . $propietario->persona->ap_paterno . ' ' . $propietario->persona->ap_materno . ' ' . $propietario->persona->razon_social;

    }

    public function primerPropietarioDomicilio(){

        $persona = $this->propietarios->first()->persona;

        if(!$persona) return null;

        return trim($persona->calle) . ' ' . $persona->numero_exterior . ' ' . trim($persona->colonia). ' ' . trim($persona->cp). ' ' . trim($persona->ciudad). ' ' . trim($persona->municipio). ' ' . trim($persona->entidad);
    }

    public function tieneAdeudo(){

        $facturas = Factura::select('id', 'predio_id')
                                ->where('predio_id',$this->id)
                                ->whereIn('status', ['FACTURADO','REZAGO'])
                                ->get();

        if ($facturas->count() > 0){

            return true;

        }

        return false;

    }

    public function getFechaEfectosFormateadaAttribute(){
        return Carbon::parse($this->fecha_efectos)->format('d/m/Y');
    }

}
