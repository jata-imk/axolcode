<?php

namespace App\Models\ExcursionesPromociones;

use Illuminate\Database\Eloquent\Model;

class ExcursionPromocion extends Model
{
    protected $table = 'excursiones_promociones';
    
    protected $fillable = [
        'id_empresa',
        'id_usuario',
        'id_excursion',
        'id_promocion',
        'paxes_promocion',
        'codigo',
        'limitado',
        'limite',
        'booking_window_inicio',
        'booking_window_fin',
        'travel_window_inicio',
        'travel_window_fin',
        'vigencia'

    ];
}
