<?php

namespace App\Models\Recomendaciones;

use Illuminate\Database\Eloquent\Model;

use App\Models\Excursiones\Excursion;

class Recomendacion extends Model
{    
    protected $table = 'recomendaciones';

    protected $fillable = [
        'id_empresa',
        'id_usuario',
        'nombre',
        'descripcion',
        'icono',
    ];

    /**
     * Obtiene las excursiones que incluyen la recomendacion
     */
    public function excursiones()
    {
        return $this->belongsToMany(Excursion::class, 'excursiones_recomendaciones', 'id_recomendacion', 'id_excursion');
    }
}
