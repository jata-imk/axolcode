<?php

namespace App\Models\Excursiones\Costeos\Campos;

use Illuminate\Database\Eloquent\Model;

class ExcursionCosteoCampo extends Model
{
    protected $table = 'excursiones_costeos_campos';

    protected $fillable = [
        'id_empresa',
        'id_usuario',
        'id_excursion_costeo',
        'id_costeo_campo',
        'valor',
    ];
}
