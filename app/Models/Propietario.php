<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelosTrait;
use App\Models\Predio;
use App\Models\Persona;

class Propietario extends Model
{

    use HasFactory;
    use ModelosTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function persona(){
        return $this->belongsTo(Persona::class);
    }

    public function predio(){
        return $this->belongsTo(Predio::class, 'propietarioable_id');
    }

}
