<?php

namespace App\Models\ExcursionesSitiosTuristicos;

use Illuminate\Database\Eloquent\Model;

class ExcursionSitioTuristico extends Model
{
    protected $table = 'excursiones_sitios_turisticos';
    
    protected $fillable = [
        'id_empresa',
        'id_usuario',
        'id_excursion',
        'id_sitio_turistico',
    ];
}
