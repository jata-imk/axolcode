<?php

namespace App\Models\Terminales;

use Illuminate\Database\Eloquent\Model;

class Terminal extends Model
{
    protected $table = 'terminales';
    
    protected $fillable = [
        'nombre',
        'estatus',
        'comision_base',
        'tres_meses',
        'seis_meses',
        'nueve_meses',
        'doce_meses',
        'precio_base',
    ];
}
