<?php

namespace App\Models\FormasPago;

use Illuminate\Database\Eloquent\Model;

class FormaPago extends Model
{
    protected $table = 'formas_pago';
    
    protected $fillable = [
        'id_empresa',
        'id_usuario',
        'nombre',
        'descripcion'
    ];
}
