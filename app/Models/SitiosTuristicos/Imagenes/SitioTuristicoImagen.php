<?php

namespace App\Models\SitiosTuristicos\Imagenes;

use Illuminate\Database\Eloquent\Model;

use App\Models\SitiosTuristicos\SitioTuristico;

class SitioTuristicoImagen extends Model
{    
    protected $table = 'sitios_turisticos_imagenes';

    protected $fillable = [
        'id_empresa',
        'id_usuario',
        'id_sitio_turistico',
        'titulo',
        'descripcion',
        'leyenda',
        'texto_alternativo',
        'path',
        'principal_tarjetas',
        'principal_portadas',
    ];

    /**
     * Obtiene el sitio turístico al que pertenece la imagen
     */
    public function sitioTuristico()
    {
        return $this->belongsTo(SitioTuristico::class, 'id', 'id_sitio_turistico');
    }
}
