<?php

namespace App\Models\ExcursionesRecomendaciones;

use Illuminate\Database\Eloquent\Model;

class ExcursionRecomendacion extends Model
{
    protected $table = 'excursiones_recomendaciones';
    
    protected $fillable = [
        'id_empresa',
        'id_excursion',
        'id_usuario',
        'id_recomendacion'
    ];
}
