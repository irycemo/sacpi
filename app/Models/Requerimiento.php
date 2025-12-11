<?php

namespace App\Models;

use Carbon\Carbon;
use App\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Requerimiento extends Model
{

    use HasFactory;
    use ModelosTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getFechaNotificacionFormateadaAttribute(){

        return $this->fecha_notificacion
                ? Carbon::parse($this->fecha_notificacion)->format('d/m/Y')
                : null;

    }

}
