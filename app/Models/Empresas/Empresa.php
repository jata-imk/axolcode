<?php

namespace App\Models\Empresas;

use Illuminate\Database\Eloquent\Model;

use App\Models\SitiosTuristicos\SitioTuristico;
use App\Models\Categorias\Categoria;
use App\Models\Excursiones\Excursion;
use App\Models\PaginasWeb\PaginaWeb;
use App\Models\Tipos\Tipo;

class Empresa extends Model
{
    protected $table = 'empresas';

    /**
     * Obtiene las paginas web que ha creado la empresa (Por el momento solo se permite una)
     */
    public function paginasWeb()
    {
        return $this->hasMany(PaginaWeb::class, 'id_empresa', 'id');
    }

    /**
     * Obtiene las excursiones que pertenecen a la empresa
     */
    public function excursiones()
    {
        return $this->hasMany(Excursion::class, 'id_empresa', 'id');
    }

    /**
     * Obtiene los sitios que pertenecen a la empresa
     */
    public function sitios()
    {
        return $this->hasMany(SitioTuristico::class, 'id_empresa', 'id');
    }

    /**
     * Obtiene las categorías que ha creado la empresa
     */
    public function categorias()
    {
        return $this->hasMany(Categoria::class, 'id_empresa', 'id');
    }

    /**
     * Obtiene los tipos de excursiones que ha creado la empresa
     */
    public function tipos()
    {
        return $this->hasMany(Tipo::class, 'id_empresa', 'id');
    }
}
