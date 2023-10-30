<?php

namespace App\Models\ExcursionesIncluye;

use Illuminate\Database\Eloquent\Model;

class ExcursionIncluye extends Model
{
    protected $table = 'excursiones_incluye';
    
    protected $fillable = [
        'id_empresa',
        'id_excursion',
        'id_usuario',
        'id_incluye'
    ];
}
