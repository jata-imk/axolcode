<?php

namespace App\Models\NivelesAfiliacion;

use Illuminate\Database\Eloquent\Model;

class NivelAfiliacion extends Model
{
    protected $table = 'afiliados_niveles';

    protected $fillable = [
        'id_empresa',
        'id_usuario',
        'nombre',
        'comision'
    ];
}
