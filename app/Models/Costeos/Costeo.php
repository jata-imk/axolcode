<?php

namespace App\Models\Costeos;

use Illuminate\Database\Eloquent\Model;

use App\Models\Costeos\Campos\CosteoCampo;
use App\Models\Costeos\Condiciones\CosteoCondicion;
use App\Models\Excursiones\Excursion;
use App\Models\Excursiones\Costeos\ExcursionCosteo;

class Costeo extends Model
{
    protected $table = 'costeos';
    protected $fillable = [
        'id_empresa',
        'id_usuario',
        'id_tipo_excursion',
        'id_temporada',
        'id_clase_servicio',
        'nombre',
        'descripcion',
        'formula_precio',
    ];

    /**
     * Obtiene los campos asociados con el costeo
     */
    public function campos()
    {
        return $this->hasMany(CosteoCampo::class, 'id_costeo', 'id');
    }

    /**
     * Obtiene las condiciones asociadas con el costeo
     */
    public function condiciones()
    {
        return $this->hasMany(CosteoCondicion::class, 'id_costeo', 'id');
    }

    public function excursiones()
    {
        return $this
            ->belongsToMany(Excursion::class, 'excursiones_costeos', 'id_costeo', 'id_excursion')
            ->withPivot(
                'id',
                'id_empresa',
                'id_usuario',
                'id_temporada',
                'id_clase_servicio',
                'id_habitacion_tipo',
                'descuento_menores',
                'descuento_menores_tipo',
                'descuento_infantes',
                'descuento_infantes_tipo',
            )
            ->using(ExcursionCosteo::class);
    }
}
