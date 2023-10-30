<?php

namespace App\Models\RedesSociales;

use Illuminate\Database\Eloquent\Model;

class RedSocial extends Model
{    
    protected $table = 'redes_sociales';

    protected $fillable = [
        'nombre',
        'icon',
        'icon_color',
    ];
}
