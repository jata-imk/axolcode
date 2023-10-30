<?php

namespace App\Models\Salas;

use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    protected $fillable = [
        'id_empresa',
        'id_usuario',
        'nombre',
        'id_direccion',
    ];
}
