<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelosTrait;

class Persona extends Model
{

    use HasFactory;
    use ModelosTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
