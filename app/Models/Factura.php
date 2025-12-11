<?php

namespace App\Models;

use App\Models\Pago;
use App\Models\Predio;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Factura extends Model
{

    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function pago():BelongsTo
    {
        return $this->belongsTo(Pago::class);
    }

    public function predio(){
        return $this->belongsTo(Predio::class);
    }

}
