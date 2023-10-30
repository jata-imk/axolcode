<?php

namespace App\Models\Afiliados;

use Illuminate\Database\Eloquent\Model;

class Afiliado extends Model
{
    protected $fillable = [
        'id_empresa',
        'id_usuario',
        'id_nivel',
        'estatus',
        'nombre_comercial',
        'direccion_comercial',
        'codigo_postal_comercial',
        'pais_comercial',
        'estado_comercial',
        'ciudad_comercial',
        'razon_social',
        'direccion_fiscal',
        'codigo_postal_fiscal',
        'pais_fiscal',
        'estado_fiscal',
        'ciudad_fiscal',
        'rfc',
        'url',
        'link_afiliado',
        'nombre_contacto',
        'apellido_contacto',
        'telefono_oficina',
        'telefono_oficina_codigo_pais',
        'telefono_oficina_iso_pais',
        'telefono_celular',
        'telefono_celular_codigo_pais',
        'telefono_celular_iso_pais',
        'fecha_alta',
        'compras_realizadas'
    ];
}
