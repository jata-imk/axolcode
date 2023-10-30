<?php

namespace App\Models\Tipos;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $table = 'tipos';
    
    protected $fillable = [
        'id_empresa',
        'id_usuario',
        'nombre',
        'descripcion',
        'icono'
    ];
}