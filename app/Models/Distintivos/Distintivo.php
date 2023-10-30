<?php

namespace App\Models\Distintivos;

use Illuminate\Database\Eloquent\Model;

class Distintivo extends Model
{
    protected $table = 'paginas_web_distintivos';
    
    protected $fillable = [
        'id_empresa',
        'id_pagina_web',
        'id_usuario',
        'nombre',
        'logo',
        'link'
    ];
}
