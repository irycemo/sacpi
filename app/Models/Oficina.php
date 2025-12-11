<?php

namespace App\Models;

use App\Models\Descuento;
use App\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Oficina extends Model
{

    use HasFactory;
    use ModelosTrait;

    protected $casts = [
        'sectores' => 'array'
    ];

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function cabeceraMunicipal(){
        return $this->belongsTo(Oficina::class, 'cabecera');
    }

    public function localidades(){
        return $this->hasMany(Oficina::class, 'cabecera');
    }

    public function descuentos()
    {
        return $this->belongsToMany(Descuento::class);
    }

    public function parametros(){
        return $this->hasMany(Parametro::class);
    }

}
