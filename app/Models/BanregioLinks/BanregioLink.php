<?php

namespace App\Models\BanregioLinks;

use Illuminate\Database\Eloquent\Model;

class BanregioLink extends Model
{
    protected $table = 'links_pago';
    protected $fillable = [
        'id_empresa',
        'id_usuario',
        'id_terminal',
        'monto',
        'meses',
        'comision_base',
        'sobre_tasa',
        'nombre_cliente',
        'respuesta',
        'autorizacion',
        'clave',
        'link'
    ];
}
