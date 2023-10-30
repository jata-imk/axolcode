<?php

namespace App\Models\Categorias;

use Illuminate\Database\Eloquent\Model;

use App\Models\Categorias\Imagenes\CategoriaImagen;

class Categoria extends Model
{
    protected $table = 'categorias';
    protected $fillable = [
        'id_empresa',
        'id_usuario',
        'nombre',
        'descripcion',
        'icono'
    ];

    /**
     * Obtiene las imágenes de la categoría
     */
    public function imagenes()
    {
        return $this->hasMany(CategoriaImagen::class, 'id_categoria', 'id');
    }

    /**
     * Obtiene las excursiones que incluyen la categoría
     */
    public function excursiones()
    {
        return $this->belongsToMany(Excursion::class, 'excursiones_categorias', 'id_categoria', 'id_excursion');
    }
}
