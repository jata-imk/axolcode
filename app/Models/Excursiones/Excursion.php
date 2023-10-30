<?php

namespace App\Models\Excursiones;

use Illuminate\Database\Eloquent\Model;

use App\Models\Servicios\Servicio;
use App\Models\Recomendaciones\Recomendacion;
use App\Models\Categorias\Categoria;
use App\Models\SitiosTuristicos\SitioTuristico;
use App\Models\ExcursionesItinerarios\ExcursionItinerario;
use App\Models\Excursiones\Imagenes\ExcursionesImagenes;

use App\Models\Costeos\Costeo;
use App\Models\Excursiones\Costeos\ExcursionCosteo;

class Excursion extends Model
{
    protected $table = 'excursiones';
    
    protected $fillable = [
        'id_empresa',
        'id_usuario',
        'nombre',
        'descripcion',
        'youtube',
        'menores',
        'infantes',
        'hoteleria',
        'vuelos',
        'calendario',
        'dias_disponible',
        'cantidad_dias',
        'publicar_excursion',
        'id_tipo',
        'titulo_sitio',
        'descripcion_sitio',
        'keywords_sitio',
        'itinerario_es',
        'itinerario_en',
        'id_moneda',
        'tipo_tarifa',
        'cantidad_pasajeros_grupo',
        'metodo_calculo_precio',
        'precio_desde',
    ];

    /**
     * Obtiene los servicios que incluye la excursion
     */
    public function incluyes()
    {
        return $this->belongsToMany(Servicio::class, 'excursiones_incluye', 'id_excursion', 'id_incluye');
    }

    /**
     * Obtiene los servicios que no incluye la excursion
     */
    public function noIncluyes()
    {
        return $this->belongsToMany(Servicio::class, 'excursiones_no_incluye', 'id_excursion', 'id_no_incluye');
    }

    /**
     * Obtiene las categorías a las que pertenece la excursion
     */
    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'excursiones_categorias', 'id_excursion', 'id_categoria');
    }

    /**
     * Obtiene las recomendaciones que incluye la excursion
     */
    public function recomendaciones()
    {
        return $this->belongsToMany(Recomendacion::class, 'excursiones_recomendaciones', 'id_excursion', 'id_recomendacion');
    }

    /**
     * Obtiene los sitios turísticos que incluye la excursion
     */
    public function sitios()
    {
        return $this->belongsToMany(SitioTuristico::class, 'excursiones_sitios_turisticos', 'id_excursion', 'id_sitio_turistico');
    }

    /**
     * Obtiene las imágenes de la excursion
     */
    public function imagenes()
    {
        return $this->hasMany(ExcursionesImagenes::class, 'id_excursion', 'id');
    }

    /**
     * Obtiene los itinerarios de cada dia de la excursion
     */
    public function itinerarios()
    {
        return $this->hasMany(ExcursionItinerario::class, 'id_excursion', 'id');
    }

    /**
     * Obtiene los costeos asociados a la excursion
     */
    public function costeos()
    {
        return $this
                    ->belongsToMany(Costeo::class, 'excursiones_costeos', 'id_excursion', 'id_costeo')
                    ->withPivot(
                        'id',
                        'id_empresa',
                        'id_usuario',
                        'id_temporada',
                        'id_clase_servicio',
                        'id_habitacion_tipo',
                        'descuento_menores',
                        'descuento_menores_tipo',
                        'descuento_infantes',
                        'descuento_infantes_tipo',
                    )
                    ->using(ExcursionCosteo::class);
    }
}