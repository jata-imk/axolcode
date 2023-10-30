<?php

namespace App\Models\PaginasWeb\RedesSociales;

use Illuminate\Database\Eloquent\Model;

class PaginaWebRedSocial extends Model
{
    protected $table = 'paginas_web_redes_sociales';

    protected $fillable = [
        'id_empresa',
        'id_pagina_web',
        'id_red_social',
        'id_usuario',
        'url',
    ];
}
