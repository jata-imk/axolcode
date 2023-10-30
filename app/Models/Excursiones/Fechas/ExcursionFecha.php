<?php

namespace App\Models\Excursiones\Fechas;

use Illuminate\Database\Eloquent\Model;

class ExcursionFecha extends Model
{
    protected $table = 'excursiones_fechas';

    protected $fillable = [
        'id_empresa',
        'id_usuario',
        'id_temporada_costo',
        'fecha_inicio',
        'fecha_fin',
        'cupo',
        'publicar_fecha',
    ];
}
