<?php

namespace App\Models\Excursiones\Imagenes;

use Illuminate\Database\Eloquent\Model;

class ExcursionesImagenes extends Model
{
    protected $table = 'excursiones_imagenes';

    protected $fillable = [
        'id_empresa',
        'id_usuario',
        'id_excursion',
        'titulo',
        'descripcion',
        'leyenda',
        'texto_alternativo',
        'path',
        'principal_tarjetas',
        'principal_portadas',
    ];
}
