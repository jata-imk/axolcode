<?php

namespace App\Models\MisTerminales;

use Illuminate\Database\Eloquent\Model;

class MiTerminal extends Model
{
    protected $table = 'terminales_empresas';
    
    protected $fillable = [
        'id_empresa',
        'id_terminal',
        'id_afiliacion',
        'id_medio',
        'enviroment',
        'url_respuesta',
        'llave_privada',
        'llave_publica',
        'estatus'
    ];
}
