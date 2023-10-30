<?php

namespace App\Models\Temporadas;

use Illuminate\Database\Eloquent\Model;

class Temporada extends Model
{
    protected $fillable = [
        'id_empresa',
        'id_usuario',
        'nombre',
        'color',
        'background_color',
    ];
}
