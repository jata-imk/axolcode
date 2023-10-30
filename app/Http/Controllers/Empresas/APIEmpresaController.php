<?php

namespace App\Http\Controllers\Empresas;

use App\Http\Controllers\APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Empresas\Empresa;
use App\Models\Direcciones\Direccion;

use App\Models\PaginasWeb\PaginaWeb;
use App\Models\PaginasWeb\RedesSociales\PaginaWebRedSocial;

class APIEmpresaController extends APIController
{
    public function index(Request $request, $apiKey = null)
    {
        $options = [
            "agregar" => filter_var($request->query("agregar", ($request["agregar"] ?? "")), FILTER_SANITIZE_STRING),   
        ];

        if ($options["agregar"] !== "") {
            $options["agregar"] = self::formatearTablasAgregadas($options["agregar"]);
        }

        $empresa = $request->apiKey["business"];
        
        ///////////////////////////////////////
        // Ahora obtenemos las direcciones
        $empresaDirecciones = Direccion::whereIn("id", [$empresa->id_direccion_comercial, $empresa->id_direccion_fiscal])
            ->select()
            ->get();

        $empresa->direccion_comercial   = $empresaDirecciones->firstWhere("id", $empresa->id_direccion_comercial);
        $empresa->direccion_fiscal      = $empresaDirecciones->firstWhere("id", $empresa->id_direccion_fiscal);

        ///////////////////////////////////////
        // Ahora obtenemos las paginas web junto a sus redes sociales
        $empresa->pagina_web = PaginaWeb::with('redesSociales:id,nombre,icon,icon_color')->where("id_empresa", "=", $empresa->id)
            ->select(
                [
                   "id", 
                   "pagina_web", 
                   "logo_web", 
                   "telefono", 
                   "footer_copyright", 
                   "politicas", 
                   "aviso_privacidad", 
                ]
            )
            ->first();

        ///////////////////////////////////////
        // Estos son campos adicionales que el usuario puede agregar si desea
        if ((gettype($options["agregar"]) === "array") && (isset($options["agregar"]["sitios"]))) {
            $empresa->sitios = $empresa->sitios()
                ->leftJoin("sitios_turisticos_imagenes AS temporal_tarjeta", function ($join) {
                    $join->on("sitios_turisticos.id", "=", "temporal_tarjeta.id_sitio_turistico")->on("temporal_tarjeta.principal_tarjetas", "=", DB::raw(1));
                })
                ->leftJoin("sitios_turisticos_imagenes AS temporal_portada", function ($join) {
                    $join->on("sitios_turisticos.id", "=", "temporal_portada.id_sitio_turistico")->on("temporal_portada.principal_portadas", "=", DB::raw(1));
                })
                ->select(
                    [
                        "sitios_turisticos.id",
                        "sitios_turisticos.nombre",
                        "sitios_turisticos.descripcion",
                        "sitios_turisticos.latitud",
                        "sitios_turisticos.longitud",

                        "temporal_tarjeta.id AS imagen_tarjeta_id",
                        "temporal_tarjeta.titulo AS imagen_tarjeta_titulo",
                        "temporal_tarjeta.descripcion AS imagen_tarjeta_descripcion",
                        "temporal_tarjeta.leyenda AS imagen_tarjeta_leyenda",
                        "temporal_tarjeta.texto_alternativo AS imagen_tarjeta_texto_alternativo",
                        "temporal_tarjeta.path AS imagen_tarjeta_path",

                        "temporal_portada.id AS imagen_portada_id",
                        "temporal_portada.titulo AS imagen_portada_titulo",
                        "temporal_portada.descripcion AS imagen_portada_descripcion",
                        "temporal_portada.leyenda AS imagen_portada_leyenda",
                        "temporal_portada.texto_alternativo AS imagen_portada_texto_alternativo",
                        "temporal_portada.path AS imagen_portada_path",
                    ]
                )
                ->limit($options["agregar"]["sitios"]["limite"] ?? null)
                ->get();

                foreach ($empresa->sitios as $sitio) {
                    self::objetoImagenDesdeColumnas($sitio);
                }
        }
            
        if ((gettype($options["agregar"]) === "array") && (isset($options["agregar"]["categorias"]))) {
            $empresa->categorias = $empresa->categorias()
                ->leftJoin("categorias_imagenes AS temporal_tarjeta", function ($join) {
                    $join->on("categorias.id", "=", "temporal_tarjeta.id_categoria")->on("temporal_tarjeta.principal_tarjetas", "=", DB::raw(1));
                })
                ->leftJoin("categorias_imagenes AS temporal_portada", function ($join) {
                    $join->on("categorias.id", "=", "temporal_portada.id_categoria")->on("temporal_portada.principal_portadas", "=", DB::raw(1));
                })
                ->select(
                    [
                        "categorias.id",
                        "categorias.nombre",
                        "categorias.descripcion",
                        "temporal_tarjeta.id AS imagen_tarjeta_id",
                        "temporal_tarjeta.titulo AS imagen_tarjeta_titulo",
                        "temporal_tarjeta.descripcion AS imagen_tarjeta_descripcion",
                        "temporal_tarjeta.leyenda AS imagen_tarjeta_leyenda",
                        "temporal_tarjeta.texto_alternativo AS imagen_tarjeta_texto_alternativo",
                        "temporal_tarjeta.path AS imagen_tarjeta_path",

                        "temporal_portada.id AS imagen_portada_id",
                        "temporal_portada.titulo AS imagen_portada_titulo",
                        "temporal_portada.descripcion AS imagen_portada_descripcion",
                        "temporal_portada.leyenda AS imagen_portada_leyenda",
                        "temporal_portada.texto_alternativo AS imagen_portada_texto_alternativo",
                        "temporal_portada.path AS imagen_portada_path",
                    ]
                )
                ->limit($options["agregar"]["categorias"]["limite"] ?? null)
                ->get();

                foreach ($empresa->categorias as $categoria) {
                    self::objetoImagenDesdeColumnas($categoria);
                }
        }

        if ((gettype($options["agregar"]) === "array") && (isset($options["agregar"]["tipos"]))) {
            $empresa->tipos = $empresa->tipos()
                ->select(
                    [
                        "id",
                        "nombre",
                        "descripcion"
                    ]
                )
                ->limit($options["agregar"]["tipos"]["limite"] ?? null)
                ->get();
        }

        if ((gettype($options["agregar"]) === "array") && (isset($options["agregar"]["excursiones"]))) {
            $empresa->excursiones = $empresa->excursiones()
                ->where("publicar_excursion", "=", 1)
                ->select(
                    [
                        "id",
                        "nombre",
                        "id_tipo"
                    ]
                )
                ->limit($options["agregar"]["excursiones"]["limite"] ?? null)
                ->get();

            foreach ($empresa->excursiones as $excursion) {
                $excursion->tipo = (object) [
                    "id" => $excursion->id_tipo
                ];

                unset($excursion->id_tipo);
            }
        }

        $empresa = self::limpiarColumnas($empresa, ["public_key", "private_key", "id_direccion_comercial", "id_direccion_fiscal"]);
        $empresa->direccion_comercial = self::limpiarColumnas($empresa->direccion_comercial);
        $empresa->direccion_fiscal = self::limpiarColumnas($empresa->direccion_fiscal);

        if ((isset($request["json"]) && $request["json"] === false) || (isset($request["controller"]) && $request["controller"] === true)) {
            return $empresa;
        }

        return response()->json([
            'code' => '200',
            'body' => [
                "empresa" => $empresa
            ]
        ], 200);
    }

    public function snippets(Request $request, $apiKey = null)
    {
        $empresa = Empresa::find($request->apiKey["business"]->id);

        $empresa->direccion_comercial = Direccion::find($empresa->id_direccion_comercial);
        $empresa->direccion_fiscal = Direccion::find($empresa->id_direccion_fiscal);
        $empresa->pagina_web = PaginaWeb::where("id_empresa", "=", $empresa->id)
            ->select()
            ->first();

        $empresa->pagina_web->redes_sociales = PaginaWebRedSocial::where('id_empresa', '=', $empresa->id)
            ->where('id_pagina_web', '=', $empresa->pagina_web->id)
            ->select()
            ->get();

        $empresa = self::limpiarColumnas($empresa, ["public_key", "private_key", "id_direccion_comercial", "id_direccion_fiscal"]);
        $empresa->direccion_comercial = self::limpiarColumnas($empresa->direccion_comercial);
        $empresa->direccion_fiscal = self::limpiarColumnas($empresa->direccion_fiscal);
        $empresa->pagina_web = self::limpiarColumnas($empresa->pagina_web);

        

        if ((isset($request["json"]) && $request["json"] === false) || (isset($request["controller"]) && $request["controller"] === true)) {
            return $empresa;
        }

        return response()->json([
            'code' => '200',
            'body' => [
                "empresa" => $empresa
            ]
        ], 200);
    }
}
