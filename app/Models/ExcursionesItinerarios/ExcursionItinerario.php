<?php

namespace App\Models\ExcursionesItinerarios;

use Illuminate\Database\Eloquent\Model;

use App\Models\Excursiones\Excursion;

class ExcursionItinerario extends Model
{
    protected $table = 'excursiones_itinerarios';
    
    protected $fillable = [
        'id_empresa',
        'id_excursion',
        'id_usuario',
        'id_incluye',
        'contenido',
        'dia',
        'icono'
    ];

    /**
     * Obtiene la excursion a la que pertenece el itinerario
     */
    public function excursion()
    {
        return $this->belongsTo(Excursion::class, 'id', 'id_excursion');
    }
}
