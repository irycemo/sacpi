<?php

namespace App\Models;

use App\Models\Pago;
use Illuminate\Database\Eloquent\Model;

class PagoDetalle extends Model
{

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function pago(){
        return $this->belongsTo(Pago::class);
    }

}
