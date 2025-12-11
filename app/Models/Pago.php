<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Predio;
use App\Models\Factura;
use App\Models\PagoDetalle;
use App\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pago extends Model
{

    use HasFactory;
    use ModelosTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function facturas(){
        return $this->belongsToMany(Factura::class);
    }

    public function descuentos(){
        return $this->belongsToMany(Descuento::class);
    }

    public function predio(){
        return $this->belongsTo(Predio::class);
    }

    public function getFechaPagoFormateadaAttribute(){
        return Carbon::parse($this->attributes['fecha_pago'])->format('d/m/Y');
    }

    public function detalles(){
        return $this->hasMany(PagoDetalle::class);
    }

}
