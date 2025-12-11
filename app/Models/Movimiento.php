<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelosTrait;
use App\Models\Predio;

class Movimiento extends Model
{

    use HasFactory;
    use ModelosTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = ['fecha' => 'date'];

    public function predio(){
        return $this->belongsTo(Predio::class);
    }

}
