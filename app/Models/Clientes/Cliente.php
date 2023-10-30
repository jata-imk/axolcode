<?php

namespace App\Models\Clientes;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{    
    protected $fillable = [
        'id_empresa',
        'id_usuario_alta',
        'id_ejecutivo',
        'fecha_alta',
        'id_status',
        'nombre',
        'apellido',
        'telefono_celular',
        'telefono_celular_codigo_pais',
        'telefono_celular_iso_pais',
        'telefono_casa',
        'telefono_casa_codigo_pais',
        'telefono_casa_iso_pais',
        'email_principal',
        'email_secundario',
        'id_direccion'
    ];
}
