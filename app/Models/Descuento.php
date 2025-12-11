<?php

namespace App\Models;

use App\Models\Oficina;
use App\Traits\ModelosTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Descuento extends Model
{

    use HasFactory;
    use ModelosTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function oficinas()
    {
        return $this->belongsToMany(Oficina::class);
    }

}
