<?php

namespace App\Models\Servicios;

use Illuminate\Database\Eloquent\Model;

use App\Models\Excursiones\Excursion;

class Servicio extends Model
{
    protected $fillable = [
        'id_empresa',
        'id_usuario',
        'nombre',
        'descripcion',
        'icono',
        'id_icono_tipo'
    ];

    /**
     * Obtiene las excursiones que incluyen el servicio
     */
    public function excursionesIncluyen()
    {
        return $this->belongsToMany(Excursion::class, 'excursiones_incluye', 'id_incluye', 'id_excursion');
    }

    /**
     * Obtiene las excursiones que no incluyen el servicio
     */
    public function excursionesNoIncluyen()
    {
        return $this->belongsToMany(Excursion::class, 'excursiones_no_incluye', 'id_no_incluye', 'id_excursion');
    }
}
