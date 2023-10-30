<?php

namespace App\Models\Categorias\Imagenes;

use Illuminate\Database\Eloquent\Model;

use App\Models\Categorias\Categoria;

class CategoriaImagen extends Model
{    
    protected $table = 'categorias_imagenes';

    protected $fillable = [
        'id_empresa',
        'id_usuario',
        'id_categoria',
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
        return $this->belongsTo(Categoria::class, 'id', 'id_categoria');
    }
}
