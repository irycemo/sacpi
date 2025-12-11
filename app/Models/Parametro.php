<?php

namespace App\Models;

use App\Models\Oficina;
use App\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Parametro extends Model
{

    use HasFactory;
    use ModelosTrait;

    public function oficina(){
        return $this->belongsTo(Oficina::class);
    }
}
