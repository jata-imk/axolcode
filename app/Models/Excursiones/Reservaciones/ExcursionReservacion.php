<?php

namespace App\Models\Excursiones\Reservaciones;

use Illuminate\Database\Eloquent\Model;

class ExcursionReservacion extends Model
{
    protected $table = 'excursiones_reservaciones';

    protected $fillable = [
        'id_empresa',
        'id_usuario',
        'id_cliente',
        'id_ejecutivo',
        'id_excursion',
        'id_promocion',
        'id_fecha',
        'fecha_inicio',
        'fecha_fin',
        'vuelos',
        'hoteleria',
        'cantidad_adultos',
        'cantidad_menores',
        'cantidad_infantes',
        'tipo_venta',
        'id_afiliado',
        'id_forma_pago',
        'contrato',
        'id_moneda'
    ];
}
