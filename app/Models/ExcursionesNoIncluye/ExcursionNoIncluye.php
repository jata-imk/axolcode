<?php

namespace App\Models\ExcursionesNoIncluye;

use Illuminate\Database\Eloquent\Model;

class ExcursionNoIncluye extends Model
{
    protected $table = 'excursiones_no_incluye';
    
    protected $fillable = [
        'id_empresa',
        'id_excursion',
        'id_usuario',
        'id_no_incluye'
    ];
}
