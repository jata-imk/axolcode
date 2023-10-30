<?php

namespace App\Models\Excursiones\Reservaciones;

use Illuminate\Database\Eloquent\Model;

class ExcursionReservacionPax extends Model
{
    protected $table = 'excursiones_reservaciones_paxes';

    protected $fillable = [
        'id_excursion_reservacion',
        'nombre',
        'apellido',
        'id_parentesco',
        'fecha_nacimiento',
        'adulto',
        'menor',
        'infante',
        'identificacion',
        'id_excursion_reservacion_habitacion',
    ];
}
