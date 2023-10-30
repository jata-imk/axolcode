<?php

namespace App\Models\Direcciones;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    protected $fillable = ['id_empresa', 'id_usuario', 'linea1', 'linea3', 'codigo_postal', 'codigo_pais', 'estado', 'ciudad'];

    protected $table = 'direcciones';
}
