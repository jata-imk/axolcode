<?php

namespace App\Models\ExcursionesCategorias;

use Illuminate\Database\Eloquent\Model;

class ExcursionCategoria extends Model
{
    protected $table = 'excursiones_categorias';
    
    protected $fillable = [
        'id_empresa',
        'id_usuario',
        'id_excursion',
        'id_categoria'
    ];
}
