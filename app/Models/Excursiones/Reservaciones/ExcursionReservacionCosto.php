<?php

namespace App\Models\Excursiones\Reservaciones;

use Illuminate\Database\Eloquent\Model;

class ExcursionReservacionCosto extends Model
{
    protected $table = 'excursiones_reservaciones_costos';

    protected $fillable = [
        'id_excursion_reservacion',
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
