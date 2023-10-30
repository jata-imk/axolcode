<?php

namespace App\Models\ClasesServicios;

use Illuminate\Database\Eloquent\Model;

class ClaseServicio extends Model
{
    protected $table = 'clases_servicios';

    protected $fillable = [
        'id_empresa',
        'id_usuario',
        'nombre',
    ];
}
