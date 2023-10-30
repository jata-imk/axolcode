<?php

namespace App\Models\Status;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{    
    protected $table = 'clientes_status';

    protected $fillable = [
        'id_empresa',
        'id_usuario',
        'descripcion',
        'color',
        'background_color'
    ];
}
