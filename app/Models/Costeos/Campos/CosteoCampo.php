<?php

namespace App\Models\Costeos\Campos;

use Illuminate\Database\Eloquent\Model;
use App\Models\Costeos\Costeo;

class CosteoCampo extends Model
{
    protected $table = 'costeos_campos';

    protected $fillable = [
        'id_empresa',
        'id_usuario',
        'id_costeo',
        'nombre',
        'identificador',
        'valor_defecto',
        'definido_por_usuario',
        'definido_por_excursion',
        'excursion_columna',
    ];

    /**
     * Obtiene el modelo de costeo asociado con el campo
     */
    public function costeo()
    {
        return $this->belongsTo(Costeo::class, 'id', 'id_costeo');
    }
}
