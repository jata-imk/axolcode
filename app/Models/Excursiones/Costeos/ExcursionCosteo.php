<?php

namespace App\Models\Excursiones\Costeos;

use Illuminate\Database\Eloquent\Relations\Pivot;

use App\Models\Excursiones\Costeos\Campos\ExcursionCosteoCampo;

class ExcursionCosteo extends Pivot
{
    protected $primaryKey = "id";
    public $incrementing = true;
    
    protected $table = 'excursiones_costeos';

    protected $fillable = [
        'id_empresa',
        'id_usuario',
        'id_excursion',
        'id_temporada',
        'id_clase_servicio',
        'id_habitacion_tipo',
        'id_costeo',
        'descuento_menores',
        'descuento_menores_tipo',
        'descuento_infantes',
        'descuento_infantes_tipo',
    ];

    /**
     * Obtiene los campos asociados con el costeo de la excursion
     */
    public function campos()
    {
        return $this->hasMany(ExcursionCosteoCampo::class, 'id_excursion_costeo', 'id');
    }
}
