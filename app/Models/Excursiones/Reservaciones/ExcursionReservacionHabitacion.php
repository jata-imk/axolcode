<?php

namespace App\Models\Excursiones\Reservaciones;

use Illuminate\Database\Eloquent\Model;

class ExcursionReservacionHabitacion extends Model
{
    protected $table = 'excursiones_reservaciones_habitaciones';

    protected $fillable = [
        'id_excursion_reservacion',
        'hotel',
        'tipo_habitacion',
        'no_reservacion',
        'titular',
        'paxes',
        'observaciones',
    ];
}
