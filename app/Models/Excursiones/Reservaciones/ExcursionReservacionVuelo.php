<?php

namespace App\Models\Excursiones\Reservaciones;

use Illuminate\Database\Eloquent\Model;

class ExcursionReservacionVuelo extends Model
{
    protected $table = 'excursiones_reservaciones_vuelos';

    protected $fillable = [
        'id_excursion_reservacion',
        'id_excursion_reservacion_pax',
        'llegada',
        'regreso',
        'lugar_origen',
        'lugar_destino',
        'id_aerolinea',
        'no_vuelo',
        'fecha_y_hora',
        'precio',
    ];
}
