<?php

namespace App\Models\Perfiles;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'usuarios';
    
    protected $fillable = [
        'name',
        'usuario_nombre',
        'usuario_apellido',
        'telefono_celular',
        'telefono_celular_codigo_pais',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'id_rol',
        'id_usuario_refirio'
    ];
}
