<?php

namespace App\Http\Controllers;

class APIController extends Controller
{
    public static function limpiarColumnas($objeto, $appends = []) {
        $defaults = [
            "id_empresa",
            "id_usuario",
            "created_at",
            "updated_at",
        ];
        
        foreach ($appends as $column) {
            $defaults[] = $column;
        }

        foreach ($defaults as $column) {
            unset($objeto[$column]);
        }

        return $objeto;
    }

    public static function formatearTablasAgregadas($strTablasAgregar, $response = []) {
        // Ya que en el string de las tablas a agregar pueden venir opciones por cada tabla del tipo
        // agregar=tipos,[sitios,limite=4,agregar=[imagenes,simplificada=true]]
        // lo primero que se hace es analizar los textos que vienen entre los corchetes
        // Nota: Pueden haber corchetes anidados por eso la función es recursiva
        $coincidencias = null;
        $regexEntreCorchetes = "/\[(?:[^\[\]]+|(?R))*\]/";

        if (preg_match_all($regexEntreCorchetes, $strTablasAgregar, $coincidencias)) {
            // La posicion 0 de $coincidencias tiene la lista de coincidencias
            foreach ($coincidencias[0] as $coincidencia) {
                // Ahora quitamos la coincidencia de la cadena de texto original
                $strTablasAgregar = str_replace($coincidencia, "", $strTablasAgregar);
                
                // Ahora a la coincidencia le quitamos los corchetes, solamewnte dejamos el contenido
                $coincidencia = substr($coincidencia, 1,-1);

                // Ahora obtenemos el nombre de la tabla con la que empezaremos a trabajar
                $nombreTabla = explode(",", $coincidencia)[0];
                $response[$nombreTabla] = [];
                
                // Se empieza a generar la respuesta de forma recursiva
                $response[$nombreTabla] = self::formatearTablasAgregadas(
                    $coincidencia,
                    $response[$nombreTabla]
                );
            }
        }
        
        // Si ya no se encuentra texto entre corchetes entonces ya podemos empezar a crear el objeto de respuesta
        // Primero hacemos un explode de las opciones de la tabla
        $strTablasAgregar = trim($strTablasAgregar, ",");
        $soloNombresDeTablas = !strpos($strTablasAgregar, "="); 
        
        $myExplode = explode(",", $strTablasAgregar);
        
        if ($soloNombresDeTablas === false) {
            // Si el explode tiene opciones quiere decir que tiene una longitud mayor de 1,
            // entonces para ese caso la posicion 0 es el nombre de la tabla y las
            // demas posiciones son las opciones
            foreach ($myExplode as $i => $opcion) {
                if ($i === 0) {
                    continue;
                }
                
                $myExplodeOpcion = explode("=", $opcion);
                // var_dump($myExplodeOpcion);echo "\n";
                
                if ((isset($myExplodeOpcion[1])) && ($myExplodeOpcion[1] !== "")) {
                    $response[$myExplodeOpcion[0]] = $myExplodeOpcion[1];
                }
            }
        } else {
            // Si el explode es unicamente de nombre de tablas entonces asignamos cada tabla a una llave del array
            foreach ($myExplode as $tablaAgregar) {
                $response[$tablaAgregar] = [];
            }
        }
        
        return $response;
    }

    public static function objetoImagenDesdeColumnas($objeto) {
        $imagenes = [];

        if ($objeto->imagen_tarjeta_id !== null) {
            $imagenes[] = (object) [
                "id" => $objeto->imagen_tarjeta_id,
                "titulo" => $objeto->imagen_tarjeta_titulo,
                "descripcion" => $objeto->imagen_tarjeta_descripcion,
                "leyenda" => $objeto->imagen_tarjeta_leyenda,
                "texto_alternativo" => $objeto->imagen_tarjeta_texto_alternativo,
                "path" => $objeto->imagen_tarjeta_path,
                "principal_portadas" => 0,
                "principal_tarjetas" => 1,
            ];
        }

        if ($objeto->imagen_portada_id !== null) {
            $imagenes[] = (object) [
                "id" => $objeto->imagen_portada_id,
                "titulo" => $objeto->imagen_portada_titulo,
                "descripcion" => $objeto->imagen_portada_descripcion,
                "leyenda" => $objeto->imagen_portada_leyenda,
                "texto_alternativo" => $objeto->imagen_portada_texto_alternativo,
                "path" => $objeto->imagen_portada_path,
                "principal_tarjetas" => 0,
                "principal_portadas" => 1,
            ];
        }

        $objeto->imagenes = $imagenes;

        unset($objeto->imagen_tarjeta_id);
        unset($objeto->imagen_tarjeta_titulo);
        unset($objeto->imagen_tarjeta_descripcion);
        unset($objeto->imagen_tarjeta_leyenda);
        unset($objeto->imagen_tarjeta_texto_alternativo);
        unset($objeto->imagen_tarjeta_path);

        unset($objeto->imagen_portada_id);
        unset($objeto->imagen_portada_titulo);
        unset($objeto->imagen_portada_descripcion);
        unset($objeto->imagen_portada_leyenda);
        unset($objeto->imagen_portada_texto_alternativo);
        unset($objeto->imagen_portada_path);
    }
}