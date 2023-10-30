<?php

namespace App\Models\Promociones;

use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
    protected $table = 'promociones';
    
    protected $fillable = [
        'id_empresa',
        'id_usuario',
        'descuento',
        'tipo_descuento',
        'valor_promocion',
        'flyer',
        'nombre',
        'descripcion',
        'publicar'
    ];
}
