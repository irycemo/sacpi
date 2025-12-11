<?php

namespace App\Models;

use App\Traits\ModelosTrait;
use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rol extends SpatieRole
{

    use HasFactory;
    use ModelosTrait;

    protected $guarded = ['id', 'created_at', 'updated_at'];

}
