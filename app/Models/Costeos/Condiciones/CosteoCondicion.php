<?php

namespace App\Models\Costeos\Condiciones;

use Illuminate\Database\Eloquent\Model;
use App\Models\Costeos\Costeo;

class CosteoCondicion extends Model
{
    protected $table = 'costeos_condiciones';

    protected $fillable = [
        'id_empresa',
        'id_usuario',
        'id_costeo',
        'condicion',
        'formula_precio',
    ];

    /**
     * Obtiene el modelo de costeo asociado con el campo
     */
    public function costeo()
    {
        return $this->belongsTo(Costeo::class, 'id', 'id_costeo');
    }
}
