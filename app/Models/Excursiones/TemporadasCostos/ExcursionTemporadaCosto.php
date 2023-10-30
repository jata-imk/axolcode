<?php

namespace App\Models\Excursiones\TemporadasCostos;

use Illuminate\Database\Eloquent\Model;

class ExcursionTemporadaCosto extends Model
{
    protected $table = 'excursiones_temporadas_costos';

    protected $fillable = [
        'id_empresa',
        'id_usuario',
        'id_excursion',
        'id_temporada',
        'id_clase_servicio',
        'adulto_sencilla',
        'adulto_doble',
        'adulto_triple',
        'adulto_cuadruple',
        'menor_sencilla',
        'menor_doble',
        'menor_triple',
        'menor_cuadruple',
        'infante_sencilla',
        'infante_doble',
        'infante_triple',
        'infante_cuadruple',
    ];
}
