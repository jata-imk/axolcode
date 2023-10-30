<?php

namespace App\Models\Monedas;

use Illuminate\Database\Eloquent\Model;

class Moneda extends Model
{
    protected $fillable = [
        'id_empresa',
        'id_usuario',
        'nombre',
        'iso',
        'tipo_cambio'
    ];
}
