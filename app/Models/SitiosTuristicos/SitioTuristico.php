<?php

namespace App\Models\SitiosTuristicos;

use Illuminate\Database\Eloquent\Model;

use App\Models\Excursiones\Excursion;
use App\Models\SitiosTuristicos\Imagenes\SitioTuristicoImagen;

class SitioTuristico extends Model
{    
    protected $table = 'sitios_turisticos';

    protected $fillable = [
        'id_empresa',
        'id_usuario',
        'nombre',
        'descripcion',
        'latitud',
        'longitud',
        'linea1',
        'linea2',
        'linea3',
        'codigo_postal',
        'ciudad',
        'estado',
        'codigo_pais',
    ];

    /**
     * Obtiene las imagenes relacionadas con el sitio
     */
    public function imagenes()
    {
        return $this->hasMany(SitioTuristicoImagen::class, 'id_sitio_turistico', 'id');
    }

    /**
     * Obtiene las excursiones que tienen a el sitio turístico entre sus puntos a recorrer
     */
    public function excursiones()
    {
        return $this->belongsToMany(Excursion::class, 'excursiones_sitios_turisticos', 'id_sitio_turistico', 'id_excursion');
    }
}
