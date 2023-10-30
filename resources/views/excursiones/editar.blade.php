@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Editar excursión')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Editar excursión</h1>
@stop

@section('content')
    <div class="row mb-2">
        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label class="col-form-label">
                    <i class="fas fa-info-circle"></i>&nbsp;
                    Fecha de creación
                </label>
                <input type="datetime-local" class="form-control form-control-sm" value="{{ $excursion->created_at }}" disabled>
            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label class="col-form-label">
                    <i class="fas fa-info-circle"></i>&nbsp;
                    Ultima actualización
                </label>
                <input type="datetime-local" class="form-control form-control-sm" value="{{ $excursion->updated_at }}" disabled>
            </div>
        </div>
    </div>

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
        </div>

        <div class="card-body">
            <form id="form-editar-excursion" class="form-excursion" @can('update', $excursion) action="{{ route('excursiones.update', $excursion->id) }}" method="post" enctype="multipart/form-data" @endcan>
                @can('update', $excursion)
                    @csrf
                    @method('put')
                @endcan


                <div class="row form-title-section mb-2">
                    <i class="fas fa-umbrella-beach"></i>
                    <h6>Información general de la excursión</h6>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" value="{{ $excursion->nombre }}" class="form-control" placeholder="Ingresar Nombre" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-floating">
                            <label>Tipo de excursión</label>
                            <select name="id_tipo" required class="form-control select2">
                                @foreach ($tipos as $tipo)
                                    <option {{ $excursion->id_tipo == $tipo->id ? 'selected' : '' }} value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-floating">
                            <label>Descripción de la excursión</label>
                            <textarea class="form-control" name="descripcion" required placeholder="Agregar una descripción a la excursión" style="height: 100px">{{ $excursion->descripcion }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Video de Youtube <small>(Opcional)</small></label>
                            <input type="text" name="youtube" value="{{ $excursion->youtube }}" class="form-control" placeholder="Link de video de Youtube">
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label>¿Es calendarizado?</label>
                            <select class="form-control select2" name="calendario">
                                <option value="1" {{ $excursion->calendario == '1' ? 'selected' : '' }}>Sí</option>
                                <option value="0" {{ $excursion->calendario == '0' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>

                        <div id="dias_disponible__container" class="dias_disponible__container ocultar @if ($excursion->calendario == 0) mostrar @endif">            
                            <label class="w-100">
                                <span class="fas fa-clock"></span>
                                &nbsp;Disponibilidad
                            </label>

                            @php
                                $excursion->dias_disponible = explode(",", $excursion->dias_disponible);
                            @endphp
        
                            <div class="dias_disponible__checkbox">
                                <label for="dias_disponible_0">Domingo</label>
                                <input type="checkbox" value="0" id="dias_disponible_0" name="dias_disponible[]" @if (array_search("0", $excursion->dias_disponible) !== false) checked @endif>
                            </div>
                            <div class="dias_disponible__checkbox">
                                <label for="dias_disponible_1">Lunes</label>
                                <input type="checkbox" value="1" id="dias_disponible_1" name="dias_disponible[]" @if (array_search("1", $excursion->dias_disponible) !== false) checked @endif>
                            </div>
                            <div class="dias_disponible__checkbox">
                                <label for="dias_disponible_2">Martes</label>
                                <input type="checkbox" value="2" id="dias_disponible_2" name="dias_disponible[]" @if (array_search("2", $excursion->dias_disponible) !== false) checked @endif>
        
                            </div>
                            <div class="dias_disponible__checkbox">
                                <label for="dias_disponible_3">Miércoles</label>
                                <input type="checkbox" value="3" id="dias_disponible_3" name="dias_disponible[]" @if (array_search("3", $excursion->dias_disponible) !== false) checked @endif>
                            </div>
                            <div class="dias_disponible__checkbox">
                                <label for="dias_disponible_4">Jueves</label>
                                <input type="checkbox" value="4" id="dias_disponible_4" name="dias_disponible[]" @if (array_search("4", $excursion->dias_disponible) !== false) checked @endif>
                            </div>
                            <div class="dias_disponible__checkbox">
                                <label for="dias_disponible_5">Viernes</label>
                                <input type="checkbox" value="5" id="dias_disponible_5" name="dias_disponible[]" @if (array_search("5", $excursion->dias_disponible) !== false) checked @endif>
                            </div>
                            <div class="dias_disponible__checkbox">
                                <label for="dias_disponible_6">Sábado</label>
                                <input type="checkbox" value="6" id="dias_disponible_6" name="dias_disponible[]" @if (array_search("6", $excursion->dias_disponible) !== false) checked @endif>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="form-group" data-select2-id="53">
                            <label>Publicar excursión</label>
                            <select class="form-control select2" name="publicar_excursion">
                                <option value="1" {{ $excursion->publicar_excursion == '1' ? 'selected' : '' }}>Sí</option>
                                <option value="0" {{ $excursion->publicar_excursion == '0' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row form-title-section mt-4 mb-2">
                    <i class="fas fa-toolbox"></i>
                    <h6>Información adicional de <span class="text-info">servicios y recomendaciones</span></h6>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-floating">
                            <label>Incluye</label>
                            <select id="incluye" name="incluye[]" multiple class="form-control">
                                @foreach ($servicios as $servicio)
                                    <option {{ $excursion->noIncluyes->contains($servicio->id) ? 'disabled' : '' }} {{ $excursion->incluyes->contains($servicio->id) ? 'selected' : '' }} value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-floating">
                            <label>No incluye</label>
                            <select id="no_incluye" name="no_incluye[]" multiple class="form-control">
                                @foreach ($servicios as $servicio)
                                    <option {{ $excursion->incluyes->contains($servicio->id) ? 'disabled' : '' }} {{ $excursion->noIncluyes->contains($servicio->id) ? 'selected' : '' }} value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-floating">
                            <label>Categorías de la excursión</label>
                            <select id="categoria" name="categoria[]" multiple class="form-control">
                                @foreach ($categorias as $categoria)
                                    <option {{ $excursion->categorias->contains($categoria->id) ? 'selected' : '' }} value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-floating">
                            <label>Recomendaciones</label>
                            <select id="recomendacion" name="recomendacion[]" multiple class="form-control">
                                @foreach ($recomendaciones as $recomendacion)
                                    <option {{ $excursion->recomendaciones->contains($recomendacion->id) ? 'selected' : '' }} value="{{ $recomendacion->id }}">{{ $recomendacion->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <label>Actualizar itinerario PDF
                                @if ($excursion->itinerario_es)
                                    <a target="_blank" href="storage/{{ $excursion->itinerario_es }}">Clic para ver itinerario</a>
                                @endif
                            </label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="itinerario" name="itinerario" accept="application/pdf">
                                    <label class="custom-file-label" for="itinerario">Ningún archivo seleccionado...</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Subir</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row form-title-section mt-4 mb-2">
                    <i class="fas fa-clipboard-list"></i>
                    <h6>Itinerario por dias</h6>
                </div>

                <div id="contenedor-itinerarios" class="contenedor-itinerarios row">
                    <div class="col-12">
                        <div class="form-group">
                            <label>Días de duración</label>
                            <input type="number" name="cantidad_dias" value="{{ $excursion->cantidad_dias }}" class="form-control" min="1" max="" required>
                        </div>
                    </div>

                    @for ($i = 1; $i <= $excursion->cantidad_dias; $i++)
                        <div class="itinerario__contenedor-dia shadow-sm">
                            <h6 class="font-weight-bold mb-2">Itinerario día {{ $i }}</h6>
                            <div class="dia">
                                <textarea class="form-control" name="contenido[]" required>{{ $excursion->itinerarios[$i - 1]->contenido ?? '' }}</textarea>
                                <div class="summernote__placeholder">
                                    Hola 🙂<br>
                                    por favor, escribe aquí el itinerario ✌<br>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>

                <div class="row form-title-section mt-4 mb-2">
                    <i class="fas fa-images"></i>
                    <h6>Galería de <span class="text-info">imágenes</span></h6>

                    <small class="form-text text-muted">
                        De click en una imagen para editar sus detalles (Texto alternativo, descripción, etc)
                    </small>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div id="editar-excursion-dropzone" class="dropzone @php echo ($excursion->imagenes->count() > 0) ? "dz-started" : "" @endphp">
                            @foreach ($excursion->imagenes as $imagen)
                                <div class="dz-preview dz-image-preview" data-toggle="modal" data-target="#modalEditarImagen">
                                    <div class="dz-image">
                                        <img data-dz-thumbnail loading="lazy" alt="storage/{{ $imagen->path }}" src="storage/{{ $imagen->path }}" style="width: 100%;height: 100%;object-fit: cover;" onerror="handleImgLoad(event)" data-id="{{ $imagen->id }}" data-created-at="{{ $imagen->created_at }}" data-titulo="{{ $imagen->titulo }}" data-descripcion="{{ $imagen->descripcion }}" data-leyenda="{{ $imagen->leyenda }}" data-texto-alternativo="{{ $imagen->texto_alternativo }}">
                                    </div>

                                    <a class="dz-remove" href="" onclick="eliminarImagenExcursion(event, {{ $imagen->id }})" data-dz-remove="">Eliminar imagen</a>

                                    <div class="dz-custom">
                                        <button class="dz-custom__btn dz-custom__btn-star @php echo ($imagen->principal == 1) ? "dz-custom__btn-star-selected" : "" @endphp " onclick="marcarImagen(event, {{ $imagen->id }})" data-column="principal" data-class="dz-custom__btn-star">⭐</button>
                                        <button class="dz-custom__btn dz-custom__btn-tag @php echo ($imagen->principal_portadas == 1) ? "dz-custom__btn-tag-selected" : "" @endphp " onclick="marcarImagen(event, {{ $imagen->id }})" data-column="principal_portadas" data-class="dz-custom__btn-tag">🅿</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="row form-title-section mt-4 mb-2">
                    <i class="fas fa-map-marked-alt"></i>
                    <h6>Sitios turísticos <span class="text-info">incluidos</span></h6>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <label>Agregar sitios</label>
                            <select class="select2-ajax-sitios"></select>
                        </div>
                    </div>

                    <div id="sitios" class="col-md-12 col-sm-12 sitios">
                        @foreach ($excursion->sitios as $sitioTuristico)
                            <div class="sitio__item" data-sitio-id="{{ $sitioTuristico->id }}">
                                <div class="sitio__header">
                                    <p class="sitio__nombre" title=${repo.nombre}>{{ $sitioTuristico->nombre }}</p>
                                    <a class="sitio__link" target="_blank" href="https://www.google.com/maps?q={{ urlencode($sitioTuristico->nombre) }},{{ $sitioTuristico->linea1 . ($sitioTuristico->linea1 !== '' ? ',' : '') }}{{ $sitioTuristico->linea3 . ($sitioTuristico->linea3 !== '' ? ',' : '') }}{{ $sitioTuristico->codigo_postal . ($sitioTuristico->codigo_postal !== '' ? ',' : '') }}{{ $sitioTuristico->ciudad . ($sitioTuristico->ciudad !== '' ? ',' : '') }}{{ $sitioTuristico->estado }}">Ver en el mapa</a>
                                </div>

                                <div>
                                    <div class="select2-result-repository__statistics">
                                        <div class="select2-result-repository__forks">
                                            <i class="fas fa-city"></i> {{ $sitioTuristico->ciudad . ($sitioTuristico->ciudad !== '' ? ', ' : '') }}{{ $sitioTuristico->estado . ($sitioTuristico->estado !== '' ? ', ' : '') }}{{ $sitioTuristico->codigo_pais }}
                                        </div>

                                        <div class="select2-result-repository__stargazers">
                                            <i class="fas fa-map-pin"></i> {{ $sitioTuristico->latitud }}, {{ $sitioTuristico->longitud }}
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="close sitio__close-btn">
                                    <span>&times;</span>
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="row form-title-section mt-4 mb-2">
                    <i class="fas fa-globe-americas"></i>
                    <h6>Información del <span class="text-info">posicionamiento web</span></h6>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="form-group">
                            <label>Título del sitio</label>
                            <input type="text" value="{{ $excursion->titulo_sitio }}" class="form-control" name="titulo_sitio" placeholder="Ejemplo: Tour a Chiapas de 5 días y 4 noches..." required>

                            <small class="form-text text-muted">
                                Los buscadores más importantes usan esta etiqueta para titular las entradas en las listas de resultados o SERP, de modo que influye de forma decisiva en la elección del internauta.
                            </small>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="form-floating">
                            <label>Palabras clave del sitio</label>
                            <textarea class="form-control" placeholder="Ejemplo: tour a Chiapas, Chiapas todo incluido, excursion a Chiapas, viaje a Chiapas.." style="height: 100px" name="keywords_sitio" required>{{ $excursion->keywords_sitio }}</textarea>

                            <small class="form-text text-muted">
                                Con esta etiqueta meta los administradores tienen la posibilidad de definir palabras clave para el buscador. Las keywords son aquellos criterios a los que responde un buscador para ofrecerle al usuario páginas HTML como respuesta.
                            </small>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="form-floating">
                            <label>Descripción del sitio</label>
                            <textarea class="form-control" placeholder="Ejemplo: Vive la experiencia de nuestro tour a Chiapas..." style="height: 100px" name="descripcion_sitio" required>{{ $excursion->descripcion_sitio }}</textarea>

                            <small class="form-text text-muted">
                                Esta información se muestra como snippet (una síntesis en dos líneas del tema de una página que aparece bajo la URL) en los buscadores de uso más generalizado como Google o Bing, por lo que se recomienda cuidar su redacción.
                            </small>
                        </div>
                    </div>
                </div>

                <div class="row form-title-section mt-4 mb-2">
                    <i class="fas fa-coins"></i>
                    <h6>Información de <span class="text-info">precios</span></h6>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>¿Se aceptan menores?</label>
                            <select id="select-menores" class="form-control" name="menores">
                                <option value="1" {{ $excursion->menores == '1' ? 'selected' : '' }}>Sí</option>
                                <option value="0" {{ $excursion->menores == '0' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>¿Se aceptan infantes?</label>
                            <select id="select-infantes" class="form-control" name="infantes">
                                <option value="1" {{ $excursion->infantes == '1' ? 'selected' : '' }}>Sí</option>
                                <option value="0" {{ $excursion->infantes == '0' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="form-group">
                            <label>¿Incluye hotelería?</label>
                            <select id="select-hoteleria" class="form-control" name="hoteleria">
                                <option value="1" {{ $excursion->hoteleria == '1' ? 'selected' : '' }}>Sí</option>
                                <option value="0" {{ $excursion->hoteleria == '0' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="form-group">
                            <label>¿Incluye vuelos?</label>
                            <select class="form-control" name="vuelos" required>
                                <option value="1" {{ $excursion->vuelos == '1' ? 'selected' : '' }}>Sí</option>
                                <option value="0" {{ $excursion->vuelos == '0' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="form-group">
                            <label>Moneda</label>
                            <select class="form-control" name="id_moneda">
                                @foreach ($monedas as $moneda)
                                    <option value="{{ $moneda->id }}" {{ $excursion->id_moneda == $moneda->id ? 'selected' : '' }}>{{ $moneda->nombre }} ({{ $moneda->iso }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="form-group">
                            <label>Tipo de tarifa</label>
                            <select id="tipo_tarifa" class="form-control" name="tipo_tarifa" required>
                                <option value="1" @if ($excursion->tipo_tarifa == 1) selected @endif>Por persona</option>
                                <option value="2" @if ($excursion->tipo_tarifa == 2) selected @endif>Grupal</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="form-group">
                            <label>Tamaño del grupo</label>
                            <input id="cantidad_pasajeros_grupo" class="form-control" type="number" step="1" name="cantidad_pasajeros_grupo" @if ($excursion->tipo_tarifa == 2) value="{{ $excursion->cantidad_pasajeros_grupo }}" @endif min="2" max="255" placeholder="Solo para tarifas grupales" @if ($excursion->tipo_tarifa != 2) disabled @endif>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="form-group">
                            <label>Método para calculo de precios</label>
                            <select id="metodo_calculo_precio" class="form-control" name="metodo_calculo_precio">
                                <option value="1" @if ($excursion->metodo_calculo_precio == 1) selected @endif>Asignación directa</option>
                                <option value="2" @if ($excursion->metodo_calculo_precio == 2) selected @endif>Mediante formula de costeo</option>
                            </select>
                        </div>
                    </div>
                </div>

                @foreach ($temporadas as $temporada)
                    <div id="cost-season-card__season-{{ $temporada->id }}" class="cost-season-card__season">
                        <div class="cost-season-card__header">
                            <div class="form-group m-0 mb-2 cost-season-card__season-checkbox">
                                <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" class="custom-control-input checkbox-temporada" data-temporada-id="{{ $temporada->id }}" id="checkbox-temporada-{{ $temporada->id }}" @php echo ($excursionTemporadasCostos->contains('id_temporada', $temporada->id)) ? "checked" : "" @endphp name="excursion-temporadas[]" value="{{ $temporada->id }}">
                                    <label class="custom-control-label cost-season-card__season-txt" for="checkbox-temporada-{{ $temporada->id }}">Temporada {{ $temporada->nombre }}</label>
                                </div>
                            </div>

                            <div id="cost-season-card__season-{{ $temporada->id }}-checkboxes-clases" class="cost-season-card__clases-servicios ocultar mostrar" data-temporada-id="{{ $temporada->id }}">
                                @foreach ($clasesServicios as $claseServicio)
                                    @php
                                        // Costos asignación directa
                                        $excursionTemporadaClaseCosto = null;
                                        
                                        if ($excursionTemporadasCostos->contains('id_temporada', $temporada->id)) {
                                            $excursionTemporadaCostos = $excursionTemporadasCostos->where('id_temporada', $temporada->id);
                                        
                                            if ($excursionTemporadaCostos->contains('id_clase_servicio', $claseServicio->id)) {
                                                $excursionTemporadaClaseCosto = $excursionTemporadaCostos->firstWhere('id_clase_servicio', $claseServicio->id);
                                            }
                                        }
                                    @endphp

                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input checkbox-temporada-clase" type="checkbox" id="temporada-{{ $temporada->id }}-clase-{{ $claseServicio->id }}" @php echo ($excursionTemporadaClaseCosto !== null) ? "checked" : "" @endphp name="excursion-temporada-{{ $temporada->id }}-clases[]" value="{{ $claseServicio->id }}" data-temporada-id="{{ $temporada->id }}" data-clase-id="{{ $claseServicio->id }}">
                                        <label for="temporada-{{ $temporada->id }}-clase-{{ $claseServicio->id }}" class="custom-control-label">{{ $claseServicio->nombre }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div id="cost-season-card__season-{{ $temporada->id }}-clases" class="cost-season-card__clases ocultar @php echo ($excursionTemporadasCostos->contains('id_temporada', $temporada->id)) ? "mostrar" : "" @endphp" data-temporada-id="{{ $temporada->id }}">
                            @foreach ($clasesServicios as $claseServicio)
                                @php
                                    $excursionTemporadaClaseCosto = null;
                                    
                                    if ($excursionTemporadasCostos->contains('id_temporada', $temporada->id)) {
                                        $excursionTemporadaCostos = $excursionTemporadasCostos->where('id_temporada', $temporada->id);
                                    
                                        if ($excursionTemporadaCostos->contains('id_clase_servicio', $claseServicio->id)) {
                                            $excursionTemporadaClaseCosto = $excursionTemporadaCostos->firstWhere('id_clase_servicio', $claseServicio->id);
                                        }
                                    }
                                @endphp

                                <div id="cost-season-card__season-{{ $temporada->id }}-clase-{{ $claseServicio->id }}" class="cost-season-card__rooms ocultar @php echo ($excursionTemporadaClaseCosto !== null) ? "mostrar" : "" @endphp" data-temporada-id="{{ $temporada->id }}" data-clase-id="{{ $claseServicio->id }}">
                                    <p class="cost-season-card__room-clase-title w-100">{{ $claseServicio->nombre }}</p>

                                    <x-excursiones.tarjeta-precio tipo-habitacion="sencilla"    :excursion="$excursion" :temporada="$temporada" :clase-servicio="$claseServicio" :excursion-temporada-clase-costo="$excursionTemporadaClaseCosto" :costeos="$costeos" :excursion-costeos="$excursion->costeos"/>
                                    <x-excursiones.tarjeta-precio tipo-habitacion="doble"       :excursion="$excursion" :temporada="$temporada" :clase-servicio="$claseServicio" :excursion-temporada-clase-costo="$excursionTemporadaClaseCosto" :costeos="$costeos" :excursion-costeos="$excursion->costeos"/>
                                    <x-excursiones.tarjeta-precio tipo-habitacion="triple"      :excursion="$excursion" :temporada="$temporada" :clase-servicio="$claseServicio" :excursion-temporada-clase-costo="$excursionTemporadaClaseCosto" :costeos="$costeos" :excursion-costeos="$excursion->costeos"/>
                                    <x-excursiones.tarjeta-precio tipo-habitacion="cuadruple"   :excursion="$excursion" :temporada="$temporada" :clase-servicio="$claseServicio" :excursion-temporada-clase-costo="$excursionTemporadaClaseCosto" :costeos="$costeos" :excursion-costeos="$excursion->costeos"/>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </form>
        </div>

        @can('update', $excursion)
            <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
                <button form="form-editar-excursion" class="btn btn-primary mx-3" type="submit">
                    <i class="fas fa-pencil-alt"></i>
                    &nbsp;Editar excursión
                </button>
                <a href="{{ route('excursiones.index') }}" class="btn btn-danger">
                    <i class="fas fa-times-circle"></i>
                    &nbsp;Cancelar
                </a>
            </div>
        @endcan

        <div id="modalEditarImagen" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detalles de la imagen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="font-size: 14px">
                        <p>Cuerpo del modal.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button form="formulario-modal-editar-imagen" type="submit" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
@stop

@section('plugins.FilterMultiSelectCustom', true)
@section('plugins.Select2', true)
@section('plugins.BS_Custom_FileInput', true)
@section('plugins.CodeMirror', true)
@section('plugins.Summernote', true)
@section('plugins.Dropzone', true)
@section('plugins.MomentJS', true)
@section('plugins.DateRangePicker', true)

@section('js')
    <script>
        Dropzone.autoDiscover = false;
    </script>

    <script>
        function eliminarImagenExcursion(event, idModeloParaEliminar) {
            event.preventDefault();
            event.stopPropagation();

            const formulario = new FormData();
            formulario.append("_method", "DELETE");
            formulario.append("_token", "{{ csrf_token() }}");

            fetch(`./admin/excursiones/{{ $excursion->id }}/imagenes/${idModeloParaEliminar}`, {
                    method: "POST",
                    body: formulario
                })
                .then(res => res.json())
                .then(data => {
                    event.target.parentElement.parentElement.removeChild(event.target.parentElement);
                });
        }

        function marcarImagen(event, idModeloImagenFavorita) {
            event.preventDefault();
            event.stopPropagation();

            const columnaModificada = event.target.getAttribute("data-column");
            const claseModificada = event.target.getAttribute("data-class");

            const formulario = new FormData();
            formulario.append("_method", "PATCH");
            formulario.append("_token", "{{ csrf_token() }}");
            formulario.append(columnaModificada, "1");

            fetch(`./admin/excursiones/{{ $excursion->id }}/imagenes/${idModeloImagenFavorita}`, {
                    method: "POST",
                    body: formulario
                })
                .then(res => res.json())
                .then(data => {
                    const previewImagenes = document.querySelectorAll(`.dz-preview .dz-custom .${claseModificada}`);

                    for (let previewImagen of previewImagenes) {
                        previewImagen.classList.remove(`${claseModificada}-selected`);
                    }

                    event.target.classList.add(`${claseModificada}-selected`);
                });
        }

        $(function() {
            const incluye = $('#incluye').filterMultiSelect({
                placeholderText: " -- Seleccione de la lista",
                filterText: "Escriba para buscar",
                selectAllText: "Seleccionar todos",
                labelText: "",
                addElementFormHTML: `<x-servicios.formularios.agregar className="form-modal" layout="vertical" />`,
                addElementFormSubmitHandler: (event, instance) => {
                    event.stopImmediatePropagation();
                    event.preventDefault();

                    const target = event.target;
                    const btnSubmit = target.querySelector("button[type='submit']");
                    btnSubmit.disabled = true;

                    const formData = new FormData(target);
                    formData.append("api", "true");

                    fetch(target.action, {
                        method: "POST",
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        btnSubmit.disabled = false;

                        if (data.code < 200 || data.code > 299) {
                            throw new Object(data);
                        }

                        const servicio = data.body.servicio;

                        const newOption = document.createElement("option");
                        newOption.label = servicio.nombre;
                        newOption.value = servicio.id;
                        newOption.defaultSelected = true;

                        const newOptionInstance = instance.createOption(instance, instance.name, newOption);
                    }).catch( (e) => {
                        const btnSubmitContainer = 
                        btnSubmit.disabled = false;

                        btnSubmit.parentElement.insertAdjacentHTML("afterbegin", `<x-alerta title="" description="${e?.body?.msg || e}"/>`);
                    })
                }
            });

            const noIncluye = $('#no_incluye').filterMultiSelect({
                placeholderText: " -- Seleccione de la lista",
                filterText: "Escriba para buscar",
                selectAllText: "Seleccionar todos",
                addElementFormHTML: `<x-servicios.formularios.agregar className="form-modal" layout="vertical" />`,
                addElementFormSubmitHandler: (event, instance) => {
                    event.stopImmediatePropagation();
                    event.preventDefault();

                    const target = event.target;
                    const btnSubmit = target.querySelector("button[type='submit']");
                    btnSubmit.disabled = true;

                    const formData = new FormData(target);
                    formData.append("api", "true");

                    fetch(target.action, {
                        method: "POST",
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        btnSubmit.disabled = false;

                        if (data.code < 200 || data.code > 299) {
                            throw new Object(data);
                        }

                        const servicio = data.body.servicio;

                        const newOption = document.createElement("option");
                        newOption.label = servicio.nombre;
                        newOption.value = servicio.id;
                        newOption.defaultSelected = true;

                        const newOptionInstance = instance.createOption(instance, instance.name, newOption);
                    }).catch( (e) => {
                        const btnSubmitContainer = 
                        btnSubmit.disabled = false;

                        btnSubmit.parentElement.insertAdjacentHTML("afterbegin", `<x-alerta title="" description="${e?.body?.msg || e}"/>`);
                    })
                }
            });

            $('#incluye').on('optionselected', function(e) {
                noIncluye.disableOption(e.detail.value);
            });

            $('#incluye').on('optiondeselected', function(e) {
                noIncluye.enableOption(e.detail.value);
            });

            $('#incluye').on('optioncreated', function(e) {
                const optionClass = e.detail.option;

                if (!noIncluye.hasOption(optionClass.checkbox.value)) {
                    const newOption = document.createElement("option");
                    newOption.label = optionClass.labelFor.textContent;
                    newOption.value = optionClass.checkbox.value;
                    newOption.defaultSelected = false;
                    newOption.disabled = true;

                    noIncluye.filterMultiSelect.createOption(noIncluye.filterMultiSelect, noIncluye.filterMultiSelect.name, newOption)
                }
            });

            $('#no_incluye').on('optionselected', function(e) {
                incluye.disableOption(e.detail.value);
            });

            $('#no_incluye').on('optiondeselected', function(e) {
                incluye.enableOption(e.detail.value);
            });

            $('#noIncluye').on('optioncreated', function(e) {
                const optionClass = e.detail.option;

                if (!incluye.hasOption(optionClass.checkbox.value)) {
                    const newOption = document.createElement("option");
                    newOption.label = optionClass.labelFor.textContent;
                    newOption.value = optionClass.checkbox.value;
                    newOption.defaultSelected = false;
                    newOption.disabled = true;

                    incluye.filterMultiSelect.createOption(incluye.filterMultiSelect, incluye.filterMultiSelect.name, newOption)
                }
            });

            $('#categoria').filterMultiSelect({
                placeholderText: " -- Seleccione de la lista",
                filterText: "Escriba para buscar",
                selectAllText: "Seleccionar todos",
                labelText: ""
            });

            $('#recomendacion').filterMultiSelect({
                placeholderText: " -- Seleccione de la lista",
                filterText: "Escriba para buscar",
                selectAllText: "Seleccionar todos",
                labelText: "",
                addElementFormHTML: `<x-recomendaciones.formularios.agregar className="form-modal" layout="vertical" />`,
                addElementFormSubmitHandler: (event, instance) => {
                    event.stopImmediatePropagation();
                    event.preventDefault();

                    const target = event.target;
                    const btnSubmit = target.querySelector("button[type='submit']");
                    btnSubmit.disabled = true;

                    const formData = new FormData(target);
                    formData.append("api", "true");

                    fetch(target.action, {
                        method: "POST",
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        btnSubmit.disabled = false;

                        if (data.code < 200 || data.code > 299) {
                            throw new Object(data);
                        }

                        const recomendacion = data.body.recomendacion;

                        const newOption = document.createElement("option");
                        newOption.label = recomendacion.nombre;
                        newOption.value = recomendacion.id;
                        newOption.defaultSelected = true;

                        const newOptionInstance = instance.createOption(instance, instance.name, newOption);
                    }).catch( (e) => {
                        const btnSubmitContainer = 
                        btnSubmit.disabled = false;

                        btnSubmit.parentElement.insertAdjacentHTML("afterbegin", `<x-alerta title="" description="${e?.body?.msg || e}"/>`);
                    })
                }
            });
        });

        $(document).ready(function() {
            basicValidation();

            // Se inicia el file input custom
            bsCustomFileInput.init();

            // Dropzone
            let newDropZone = new Dropzone(`#editar-excursion-dropzone`, {
                url: "./admin/excursiones/{{ $excursion->id }}/imagenes",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                paramName: "file[]",
                autoProcessQueue: true,
                addRemoveLinks: true,
                dictDefaultMessage: "Arrastre o de click para agregar las imágenes",
                dictCancelUpload: "Cancelar subida",
                dictCancelUploadConfirmation: "¿Está seguro que desea cancelar la subida de la imagen?",
                dictRemoveFile: "Eliminar imagen",
                acceptedFiles: "image/*",
                previewTemplate: `
                    <div class="dz-preview dz-image-preview" data-toggle="modal" data-target="#modalEditarImagen">
                        <div class="dz-image" >
                            <img data-dz-thumbnail="" style="width: 100%;height: 100%;object-fit: cover;" data-id="" data-created-at="" data-titulo="" data-descripcion="" data-leyenda="" data-texto-alternativo="">
                        </div>
                        <div class="dz-progress">
                            <span class="dz-upload" data-dz-uploadprogress></span>
                        </div>
                        <div class="dz-success-mark">
                            <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>Check</title>
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF">
                                    </path>
                                </g>
                            </svg>
                        </div>
                        <div class="dz-error-mark">
                            <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>Error</title>
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">
                                        <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z">
                                        </path>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <div class="dz-error-message">
                            <span data-dz-errormessage></span>
                        </div>

                        <div class="dz-custom">
                            <button class="dz-custom__btn dz-custom__btn-star" data-column="principal" data-class="dz-custom__btn-star">⭐</button>
                            <button class="dz-custom__btn dz-custom__btn-tag" data-column="principal_portadas" data-class="dz-custom__btn-tag">🅿</button>
                        </div>
                    </div>
                `
            });

            // Se captura el evento para cuando se recibe una respuesta del servidor después de la petición para guardar la imagen
            newDropZone.on("complete", file => {
                if (file.xhr.readyState == 4 && file.xhr.status == 200) {
                    const respuesta = JSON.parse(file.xhr.responseText);

                    const modelos = respuesta.body.modelos;

                    for (let modelo of modelos) {
                        const idModelo = modelo.id;

                        const imgElement = file.previewElement.querySelector(".dz-image img[data-dz-thumbnail]");

                        imgElement.src = "./storage/" + modelo.path;
                        imgElement.setAttribute("data-id", modelo.id);
                        imgElement.setAttribute("data-created-at", modelo.created_at);
                        imgElement.setAttribute("data-titulo", modelo.titulo);
                        imgElement.setAttribute("data-descripcion", modelo.descripcion);
                        imgElement.setAttribute("data-leyenda",modelo.leyenda);
                        imgElement.setAttribute("data-texto-alternativo", modelo.texto_alternativo);

                        const btnEliminarImg = file.previewElement.querySelector(".dz-remove");
                        btnEliminarImg.onclick = (event) => {
                            eliminarImagenExcursion(event, idModelo)
                        };

                        const btnMarcarFavorita = file.previewElement.querySelector(".dz-custom__btn-star");
                        btnMarcarFavorita.onclick = (event) => {
                            marcarImagen(event, idModelo)
                        };

                        const btnMarcarFavoritaPortada = file.previewElement.querySelector(".dz-custom__btn-tag");
                        btnMarcarFavoritaPortada.onclick = (event) => {
                            marcarImagen(event, idModelo)
                        };
                    }
                }
            });

            // Funcionalidad que sucederá al abrir el modal para editar los detalles de una imagen
            $('#modalEditarImagen').on('show.bs.modal', function (event) {
                const modal = event.target;
                const modalBody = modal.querySelector(".modal-body");

                const relatedTarget = event.relatedTarget;
                const imgElement = relatedTarget.querySelector(".dz-image img[data-dz-thumbnail]");

                fetch(imgElement.src, {
                    method: 'HEAD'
                })
                .then(function(response) {
                    const imgSize = response.headers.get('content-length');
                    const imgType = response.headers.get('content-type');

                    const imgId = imgElement.getAttribute("data-id");
                    const imgTitulo = imgElement.getAttribute("data-titulo");
                    const imgDescripcion = imgElement.getAttribute("data-descripcion");
                    const imgLeyenda = imgElement.getAttribute("data-leyenda");
                    const imgTextoAlternativo = imgElement.getAttribute("data-texto-alternativo");

                    modalBody.innerHTML = `
                    <x-generales.imagenes.formularios.editar action="{{ route('excursiones.index') }}/{{ $excursion->id }}/imagenes/${imgId}" path="${imgElement.src}" className="form-modal" btnSubmit="false" imagen-id="${imgId}" titulo="${imgTitulo}" descripcion="${imgDescripcion}" leyenda="${imgLeyenda}" texto-alternativo="${imgTextoAlternativo}">
                        <x-slot:imagen-info>
                            <div class="col-md-12 border-bottom mb-3" style="font-size: 12px">
                                <p class="m-0"><span class="font-weight-bold">Subido el:</span> ${imgElement.getAttribute("data-created-at")}</p>
                                <p class="m-0"><span class="font-weight-bold">Tipo de archivo:</span> ${imgType}</p>
                                <p class="m-0"><span class="font-weight-bold">Tamaño de archivo:</span> ${formatearBytes(imgSize)}</p>
                                <p class="m-0 mb-3"><span class="font-weight-bold">Dimensiones:</span> ${imgElement.naturalWidth} por ${imgElement.naturalHeight} píxeles</p>
                            </div>
                        </x-slot>
                    </x-excursiones.imagenes.formularios.editar>
                    `;

                    modalBody.querySelector("form").addEventListener("submit", (event) => {
                        event.preventDefault();

                        modal.querySelector(".modal-footer button[type='submit']").disabled = true;
                        modal.querySelector(".modal-footer button[type='submit']").textContent = "Subiendo cambios...";

                        fetch(event.target.action, {
                            method: "POST",
                            body: new FormData(event.target)
                        })
                        .then(response => response.json())
                        .then(data => {
                            imgElement.setAttribute("data-titulo", data.body.imagen.titulo);
                            imgElement.setAttribute("data-descripcion", data.body.imagen.descripcion);
                            imgElement.setAttribute("data-leyenda", data.body.imagen.leyenda);
                            imgElement.setAttribute("data-texto-alternativo", data.body.imagen.texto_alternativo);

                            $('#modalEditarImagen').modal('hide')
                            modal.querySelector(".modal-footer button[type='submit']").disabled = false;
                            modal.querySelector(".modal-footer button[type='submit']").textContent = "Guardar cambios";
                        })
                        .catch( e => {
                            modal.querySelector(".modal-footer button[type='submit']").disabled = false;
                            modal.querySelector(".modal-footer button[type='submit']").textContent = "Guardar cambios";
                            
                            console.log(e)
                        })
                    })
                });
            })

            ////////////////////////////////
            // Seccion de variables
            ////////////////////////////////
            const formularioEditarExcursion = document.getElementById("form-editar-excursion");
            const contenedoresHabitaciones = document.querySelectorAll(".cost-season-card__rooms");

            const selectMenores = document.getElementById("select-menores");
            const selectInfantes = document.getElementById("select-infantes");
            const selectMetodoCalculoPrecio = document.getElementById("metodo_calculo_precio");

            let inputPreciosTemporadas = document.querySelectorAll(".cost-season-card__season input[type='number']");

            const inputCostosMenores = document.querySelectorAll("input[type='number'].input-menor");
            const inputCostosInfantes = document.querySelectorAll("input[type='number'].input-infante");

            const selectHoteleria = document.getElementById("select-hoteleria");

            const checkboxesTemporadas = document.querySelectorAll(".checkbox-temporada");
            const checkboxesTemporadasClases = document.querySelectorAll(".checkbox-temporada-clase");

            ///////////////////////////////////////////////
            // Seccion de itinerarios con plugin summernote
            ////////////////////////////////////////////////
            const textareasItinerarios = $('#contenedor-itinerarios textarea');

            for (const textarea of textareasItinerarios) {
                textareasItinerarios.summernote({
                    tabsize: 2,
                    height: 350,
                    codemirror: {
                        mode: 'text/html',
                        htmlMode: true,
                        lineNumbers: true,
                        theme: 'monokai'
                    },
                    callbacks: {
                        onInit: function() {
                            var $self = $(this);

                            if ($self.summernote('isEmpty') && !$self.summernote('codeview.isActivated')) {
                                $self[0].parentElement.querySelector(".summernote__placeholder").style.display = "block";
                            } else {
                                $self[0].parentElement.querySelector(".summernote__placeholder").style.display = "none";
                            }
                        },
                        onFocus: function() {
                            var $self = $(this);

                            $self[0].parentElement.querySelector(".summernote__placeholder").style.display = "none";
                        },
                        onBlur: function() {
                            var $self = $(this);
                            setTimeout(function() {
                                if ($self.summernote('isEmpty') && !$self.summernote('codeview.isActivated')) {
                                    $self[0].parentElement.querySelector(".summernote__placeholder").style.display = "block";
                                }
                            }, 150);
                        }
                    }
                });
            }

            ////////////////////////////////
            // Sección de sitios turísticos
            ////////////////////////////////
            const contenedorSitios = document.getElementById("sitios");

            const sitiosItems = document.querySelectorAll("#sitios .sitio__item .sitio__close-btn");
            for (let sitio of sitiosItems) {
                sitio.addEventListener("click", (event) => {
                    eliminarItemSitio(event);
                })
            }

            $('.select2-ajax-sitios').select2({
                ajax: {
                    url: `{{ route('sitios-turisticos.index') }}`,
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        var query = {
                            term: params.term,
                            q: params.term,
                            api: "true"
                        }

                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    },
                    processResults: function(data) {
                        // Transforms the top-level key of the response object from 'items' to 'results'
                        return {
                            results: data.body.sitios
                        };
                    },
                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                },
                placeholder: 'Búsqueda de sitios turísticos por nombre, ciudad o estado...',
                minimumInputLength: 3,
                width: "100%",
                templateResult: formatRepo,
                templateSelection: formatRepoSelection,
            });

            function formatRepo(repo) {
                if (repo.loading) {
                    return repo.text;
                }

                var $container = $(
                    "<div class='select2-result-repository clearfix'>" +
                    "<div class='select2-result-repository__meta' style='margin-left: 0'>" +
                    "<div class='select2-result-repository__title'></div>" +
                    "<div class='select2-result-repository__statistics'>" +
                    "<div class='select2-result-repository__forks'><i class='fas fa-city'></i> </div>" +
                    "<div class='select2-result-repository__stargazers'><i class='fas fa-map-pin'></i> </div>" +
                    "</div>" +
                    "</div>" +
                    "</div>"
                );

                $container.find(".select2-result-repository__title").text(repo.nombre);
                $container.find(".select2-result-repository__forks").append(repo.ciudad + ", " + repo.estado + ", " + repo.codigo_pais);
                $container.find(".select2-result-repository__stargazers").append(repo.latitud + " " + repo.longitud);

                return $container;
            }

            function formatRepoSelection(repo) {
                repo.text = "Búsqueda de sitios turísticos por nombre, ciudad o estado..."

                if (repo.id !== "") {
                    if (document.getElementById("sitios").querySelector(`.sitio__item[data-sitio-id="${repo.id}"]`) === null) {
                        let templateSitio = `
                        <div class="sitio__item" data-sitio-id="${repo.id}">
                            <div class="sitio__header">
                                <p class="sitio__nombre" title=${repo.nombre}>${repo.nombre}</p>
                                <a class="sitio__link" target="_blank" href="https://www.google.com/maps?q=${encodeURIComponent(repo.nombre)},${repo.linea1.concat(repo.linea1 !== '' ? ',' : '')}${repo.linea3.concat(repo.linea3 !== '' ? ',' : '')}${repo.codigo_postal.concat(repo.codigo_postal !== '' ? ',' : '')}${repo.ciudad.concat(repo.ciudad !== '' ? ',' : '')}${repo.estado}">Ver en el mapa</a>
                            </div>
                
                            <div>
                                <div class="select2-result-repository__statistics">
                                    <div class="select2-result-repository__forks">
                                        <i class="fas fa-city"></i> ${repo.ciudad.concat(repo.ciudad !== '' ? ', ' : '')}${repo.estado.concat(repo.estado !== '' ? ', ' : '')}${repo.codigo_pais}
                                    </div>
                
                                    <div class="select2-result-repository__stargazers">
                                        <i class="fas fa-map-pin"></i> ${repo.latitud} ${repo.longitud}
                                    </div>
                                </div>
                            </div>
                
                            <button type="button" class="close sitio__close-btn">
                                <span>&times;</span>
                            </button>
                        </div>`;
                        contenedorSitios.insertAdjacentHTML('beforeend', templateSitio);

                        contenedorSitios.lastElementChild.querySelector('.sitio__close-btn').addEventListener("click", (event) => {
                            eliminarItemSitio(event)
                        });
                    }
                };

                return repo.text;
            }

            function eliminarItemSitio(event) {
                event.preventDefault();

                const item = event.currentTarget.parentElement;
                const sitioId = item.getAttribute("data-sitio-id");

                item.parentElement.removeChild(item);
            }

            /////////////////////////////////////
            // Seccion de checkboxes de temporada
            //////////////////////////////////////
            function setVisibilityTemporada(contenedorTemporadaClases, contenedorCheckboxesTemporadaClases, visibility) {
                if (visibility === true) {
                    contenedorTemporadaClases.classList.add("mostrar");
                    contenedorCheckboxesTemporadaClases.classList.add("mostrar");
                } else {
                    contenedorTemporadaClases.classList.remove("mostrar");
                    contenedorCheckboxesTemporadaClases.classList.remove("mostrar");
                }
            }

            for (let checkboxTemporada of checkboxesTemporadas) {
                checkboxTemporada.addEventListener("change", (event) => {
                    const target = event.target;
                    const temporadaId = target.getAttribute("data-temporada-id");

                    const contenedorTemporadaClases = document.getElementById(`cost-season-card__season-${temporadaId}-clases`);
                    const contenedorCheckboxesTemporadaClases = document.getElementById(`cost-season-card__season-${temporadaId}-checkboxes-clases`);

                    setVisibilityTemporada(contenedorTemporadaClases, contenedorCheckboxesTemporadaClases, target.checked)
                });
            }

            ///////////////////////////////////////////////
            // Seccion de checkboxes de clases de temporada
            ////////////////////////////////////////////////
            function setVisibilityClase(contenedorClase, visibility) {
                if (visibility === true) {
                    contenedorClase.classList.add("mostrar");
                } else {
                    contenedorClase.classList.remove("mostrar");
                }
            }

            for (let checkboxTemporadaClase of checkboxesTemporadasClases) {
                checkboxTemporadaClase.addEventListener("change", (event) => {
                    const target = event.target;
                    const temporadaId = target.getAttribute("data-temporada-id");
                    const claseId = target.getAttribute("data-clase-id");

                    const contenedorClase = document.getElementById(`cost-season-card__season-${temporadaId}-clase-${claseId}`);
                    const contenedorCheckboxesTemporadaClases = document.getElementById(`cost-season-card__season-${temporadaId}-checkboxes-clases`);
                    const checkboxesSeleccionados = contenedorCheckboxesTemporadaClases.querySelectorAll("input[type='checkbox']:checked");

                    if (checkboxesSeleccionados.length === 0) {
                        const checkboxTemporada = document.getElementById(`checkbox-temporada-${temporadaId}`);
                        checkboxTemporada.click();
                    }

                    setVisibilityClase(contenedorClase, target.checked);
                });

                const temporadaId = checkboxTemporadaClase.getAttribute("data-temporada-id");
                const claseId = checkboxTemporadaClase.getAttribute("data-clase-id");

                const contenedorCheckboxesTemporadaClases = document.getElementById(`cost-season-card__season-${temporadaId}-checkboxes-clases`);
                const checkboxesSeleccionados = contenedorCheckboxesTemporadaClases.querySelectorAll("input[type='checkbox']:checked");

                if (checkboxesSeleccionados.length === 0) {
                    const checkboxTemporada = document.getElementById(`checkbox-temporada-${temporadaId}`);
                    checkboxTemporada.click();
                    checkboxTemporada.click();
                }
            }

            ///////////////////////////////////////////////
            // Seccion de tarjetas de precio
            ////////////////////////////////////////////////
            function setVisibilityInputCostos(value, inputs) {
                if (value == 0) {
                    for (let input of inputs) {
                        input.parentElement.parentElement.style.display = "none";
                        input.disabled = true;
                    }
                } else {
                    for (let input of inputs) {
                        input.parentElement.parentElement.style.display = "block";
                        input.disabled = false;
                    }
                }

                for (let contenedorHabitaciones of contenedoresHabitaciones) {
                    validateRoomsSeason(contenedorHabitaciones);
                }
            }

            // Parte para mostrar la disponibilidad de los tipos de habitaciones
            function validateRoomsSeason(contenedorHabitacionesTemporada) {
                const habitacionesTemporada = contenedorHabitacionesTemporada.querySelectorAll(".cost-season-card__room");

                for (let habitacionTemporada of habitacionesTemporada) {
                    const tipoHabitacion = habitacionTemporada.getAttribute("data-tipo-habitacion");
                    // Existen dos formas de asignar precios
                    // 1.- Mediante asignacion directa (Son valores fijos para cada persona)
                    // 2.- Mediante formulas, util si se quiere modificar el precio por ejemplo diviendo el gasto de transportación entre los pasajeros
                    const contenedorCamposAsignacionDirecta = habitacionTemporada.querySelector(".cost-season-card__room-contenedor-campos-asignacion-directa");
                    const contenedorCamposFormulaCosteo = habitacionTemporada.querySelector(".cost-season-card__room-contenedor-campos-formula-costeo");

                    // Dependiendo del metodo elegido para calcular el precio se muestra un contenedor u otro
                    // ya preparados para meter los valo4res directos o para seleccionar las formulas
                    if (Number(selectMetodoCalculoPrecio.value) === 1) {
                        // Codigo para asignación directa
                        contenedorCamposAsignacionDirecta.classList.add("mostrar")
                        contenedorCamposFormulaCosteo.classList.remove("mostrar")

                        // Primero se desactivan todos los campos del contenedor de campos de costeo
                        const camposFormulaCosteo = contenedorCamposFormulaCosteo.querySelectorAll("select");

                        for (const campoFormulaCosteo of camposFormulaCosteo) {
                            campoFormulaCosteo.disabled = true;
                        }

                        // Ahora se activan todos los campos del contenedor de asignacion directa
                        const camposAsignacionDirecta = contenedorCamposAsignacionDirecta.querySelectorAll("input");

                        for (const campoAsignacionDirecta of camposAsignacionDirecta) {
                            campoAsignacionDirecta.disabled = false;
                        }

                        const inputsEnabled = habitacionTemporada.querySelectorAll("input[type='number']:not(:disabled)");
                        let zeroValueCont = 0;

                        for (let inputEnable of inputsEnabled) {
                            if (Number(inputEnable.value) === 0) {
                                zeroValueCont++;
                            }
                        }

                        if (selectHoteleria.value !== "0") {
                            if (inputsEnabled.length === zeroValueCont) {
                                habitacionTemporada.classList.remove("cost-season-card__room-included");
                                habitacionTemporada.classList.add("cost-season-card__room-not-included");
                            } else {
                                habitacionTemporada.classList.add("cost-season-card__room-included");
                                habitacionTemporada.classList.remove("cost-season-card__room-not-included");
                            }
                        }
                    } else {
                        // Codigo para formula de costeo
                        contenedorCamposFormulaCosteo.classList.add("mostrar")
                        contenedorCamposAsignacionDirecta.classList.remove("mostrar")

                        // Primero se activan todos los campos del contenedor de campos de costeo
                        const campos = contenedorCamposFormulaCosteo.querySelectorAll("select, input[type='hidden']");

                        for (const campoFormulaCosteo of campos) {
                            if ((tipoHabitacion === "sencilla") || (Number(selectHoteleria.value) === 1)) {
                                campoFormulaCosteo.disabled = false;
                            } else {
                                campoFormulaCosteo.disabled = true;
                            }
                        }

                        // Ahora se desactivan todos los campos del contenedor de asignacion directa
                        const camposAsignacionDirecta = contenedorCamposAsignacionDirecta.querySelectorAll("input");

                        for (const campoAsignacionDirecta of camposAsignacionDirecta) {
                            campoAsignacionDirecta.disabled = true;
                        }
                    }
                }
            }

            function handleChangeSelectHoteleria() {
                for (let contenedorHabitaciones of contenedoresHabitaciones) {
                    for (let i = 0, l = contenedorHabitaciones.children.length; i < l; i++) {
                        if (contenedorHabitaciones.children[i].tagName.toLowerCase() === "p") {
                            continue;
                        }

                        if (i === 1) { // Primer tarjeta de precios
                            if (Number(selectMetodoCalculoPrecio.value) === 1) {
                                if (selectHoteleria.value === "0") {
                                    contenedorHabitaciones.children[i].classList.remove("cost-season-card__room-included");
                                    contenedorHabitaciones.children[i].classList.remove("cost-season-card__room-not-included");
                                } else {
                                    contenedorHabitaciones.children[i].classList.add("cost-season-card__room-included");
                                }
                            }

                            const title = contenedorHabitaciones.children[i].querySelector(".card-title");
                            title.style.display = (selectHoteleria.value === "0") ? "none" : "block";
                        } else {
                            contenedorHabitaciones.children[i].style.display = (selectHoteleria.value === "0") ? "none" : "flex";
                        }
                    }
                }

                for (let contenedorHabitaciones of contenedoresHabitaciones) {
                    validateRoomsSeason(contenedorHabitaciones);
                }
            }

            function handleChangeSelectCosteo(event) {
                const selectCosteoTarget = event.currentTarget;
                const idTemporada = selectCosteoTarget.getAttribute("data-temporada-id");
                const idClaseServicio = selectCosteoTarget.getAttribute("data-clase-servicio-id");
                const tipoHabitacion = selectCosteoTarget.getAttribute("data-tipo-habitacion");

                const contenedorCamposCosteo = document.querySelector(`.cost-season-card__room-contenedor-campos-formula-costeo[data-temporada-id='${idTemporada}'][data-clase-servicio-id='${idClaseServicio}'][data-tipo-habitacion='${tipoHabitacion}']`);
                const camposCosteo = contenedorCamposCosteo.querySelector(".cost-season-card__room-campos-formula-costeo");
                
                const idCosteo = event.currentTarget.value;
                
                if (Number(idCosteo) === 0) {
                    camposCosteo.innerHTML = "Aun no se selecciona costeo";
                } else {
                    camposCosteo.innerHTML = `<div class="lds-ripple"><div></div><div></div></div>`;
                    camposCosteo.classList.add("text-center", "mt-3");

                    fetch(`./admin/costeos/${idCosteo}?api=true`)
                        .then(res => res.json())
                        .then(data => {
                            costeo = data.body.costeo;
    
                            let tarjetaCamposHTML = "";
    
                            for (let campo of costeo.campos) {
                                if (campo.definido_por_usuario || campo.definido_por_excursion) {
                                    continue;
                                }
    
                                tarjetaCamposHTML += `
                                <div class="form-group">
                                    <label class="form-check-label">${campo.nombre}</label>
                                    <input type="hidden" name="temporada-${idTemporada}-clase-${idClaseServicio}-habitacion-tipo-${tipoHabitacion}-costeo-${costeo.id}-campos-id[]" value="${campo.id}" >
                                    <input type="number" name="temporada-${idTemporada}-clase-${idClaseServicio}-habitacion-tipo-${tipoHabitacion}-costeo-${costeo.id}-campo-${campo.id}-valor" class="form-control" placeholder="0.00" value="${campo.valor_defecto}" step="any" >
                                </div>
                                `;
                            }
    
                            // Ahora se agregan campos que siempre van, los cuales son los descuentos para menores e infantes
                            tarjetaCamposHTML += `
                            <div class="form-group">
                                <label class="form-check-label">Descuento menores</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <input type="checkbox" name="temporada-${idTemporada}-clase-${idClaseServicio}-habitacion-tipo-${tipoHabitacion}-costeo-${costeo.id}-campo-tipo-descuento-menor">
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="temporada-${idTemporada}-clase-${idClaseServicio}-habitacion-tipo-${tipoHabitacion}-costeo-${costeo.id}-campo-descuento-menor">
                                </div>
                                <small class="form-text text-muted">Marque el recuadro si el descuento es un porcentaje (%)</small>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-check-label">Descuento infantes</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <input type="checkbox" name="temporada-${idTemporada}-clase-${idClaseServicio}-habitacion-tipo-${tipoHabitacion}-costeo-${costeo.id}-campo-tipo-descuento-infante">
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="temporada-${idTemporada}-clase-${idClaseServicio}-habitacion-tipo-${tipoHabitacion}-costeo-${costeo.id}-campo-descuento-infante">
                                </div>
                                <small class="form-text text-muted">Marque el recuadro si el descuento es un porcentaje (%)</small>
                            </div>
                            `;
    
                            camposCosteo.innerHTML = tarjetaCamposHTML;
                            camposCosteo.classList.remove("text-center", "mt-3");
                        });
                }
            }

            selectMenores.addEventListener("change", (event) => {
                setVisibilityInputCostos(selectMenores.value, inputCostosMenores);
            });

            selectInfantes.addEventListener("change", (event) => {
                setVisibilityInputCostos(selectInfantes.value, inputCostosInfantes);
            });

            setVisibilityInputCostos(selectMenores.value, inputCostosMenores);
            setVisibilityInputCostos(selectInfantes.value, inputCostosInfantes);

            selectHoteleria.addEventListener("change", handleChangeSelectHoteleria);
            handleChangeSelectHoteleria();

            for (let inputPrecio of inputPreciosTemporadas) {
                inputPrecio.addEventListener("input", (event) => {
                    const target = event.target;
                    const idTemporada = target.getAttribute("data-temporada-id");

                    // La siguiente condicion solo se cumple si el input es del contenedor de asignacion directa de precios
                    if (idTemporada !== null) {
                        const contenedorHabitacionesTemporada = document.getElementById(`cost-season-card__season-${idTemporada}`);
                        validateRoomsSeason(contenedorHabitacionesTemporada);
                    }
                });
            }

            for (let contenedorHabitaciones of contenedoresHabitaciones) {
                const selectsCosteo = contenedorHabitaciones.querySelectorAll("select[data-select-costeo]");

                for (let selectCosteo of selectsCosteo) {
                    selectCosteo.addEventListener("change", (event) => {
                        handleChangeSelectCosteo(event);
                    });
                }

                validateRoomsSeason(contenedorHabitaciones);
            }

            // Evento para el select de metodo de calculo de precio
            selectMetodoCalculoPrecio.addEventListener("change", (event) => {
                for (let contenedorHabitaciones of contenedoresHabitaciones) {
                    validateRoomsSeason(contenedorHabitaciones);
                }
            });

            ///////////
            // Otros
            ///////////
            // Select calendario
            const selectCalendario =  document.querySelector("select[name='calendario']");
            const contenedorDiasDisponibles =  document.getElementById("dias_disponible__container");

            selectCalendario.addEventListener("change", (event) => {
                if (selectCalendario.value === "1") {
                    // Si la excursion es calendarizada entonces su disponibilidad se define en el modulo de fechas
                    // El contenedor de dias de disponibilidad se oculta ya que no se utilizará
                    contenedorDiasDisponibles.classList.remove("mostrar");
                } else {
                    // Si la excursion NO es calendarizada se eligen los dias de la semana que estará disponible al publico
                    // El contenedor de dias de disponibilidad se muestra
                    contenedorDiasDisponibles.classList.add("mostrar");
                }
            });

            // Select tipo tarifa
            const selectTipoTarifa = document.getElementById("tipo_tarifa");
            const inputCantidadPersonasGrupo = document.getElementById("cantidad_pasajeros_grupo");

            selectTipoTarifa.addEventListener("change", (event) => {
                // Posibles valores: 1 = Por persona, 2 = Grupal
                if (Number(selectTipoTarifa.value) === 2) {
                    inputCantidadPersonasGrupo.placeholder = "Cantidad personas por grupo";
                    inputCantidadPersonasGrupo.disabled = false;
                    inputCantidadPersonasGrupo.required = true;

                    basicValidation();
                } else {
                    inputCantidadPersonasGrupo.placeholder = "Solo para tarifas grupales";
                    inputCantidadPersonasGrupo.disabled = true;
                    inputCantidadPersonasGrupo.required = false;

                    basicValidation();
                }

                const changeEvent = new Event("change");
                inputCantidadPersonasGrupo.dispatchEvent(changeEvent);
            });

            formularioEditarExcursion.addEventListener("submit", (event) => {
                document.querySelector(".card-footer button[type='submit']").disabled = true;
                document.querySelector(".card-footer button[type='submit']").textContent = 'Guardando...';

                // Limpiamos los incluyes y no incluyes que estan vacios ya que causarian error en el backend
                for (const incluye of document.querySelectorAll("[name='incluye[]']")) {
                    if (Number(incluye.value) === 0) {
                        incluye.disabled = true;
                    }
                }

                for (const noIncluye of document.querySelectorAll("[name='no_incluye[]']")) {
                    if (Number(noIncluye.value) === 0) {
                        noIncluye.disabled = true;
                    }
                }

                // Tambien limpiamos las categorias y las recomendaciones
                // HACK: Se tiene que hacer la limpieza por cada select en el que usemos el plugin multi-select
                for (const categorias of document.querySelectorAll("[name='categoria[]']")) {
                    if (Number(categorias.value) === 0) {
                        categorias.disabled = true;
                    }
                }

                for (const recomendacion of document.querySelectorAll("[name='recomendacion[]']")) {
                    if (Number(recomendacion.value) === 0) {
                        recomendacion.disabled = true;
                    }
                }

                // Ahora agregamos todos los sitios que incluye la excursion a la peticion
                const selectSitios = document.createElement("select");
                selectSitios.style.display = "none";
                selectSitios.name = "sitios[]";
                selectSitios.multiple = true;

                const sitiosItems = document.querySelectorAll("#sitios .sitio__item");
                for (let sitio of sitiosItems) {
                    const sitioId = sitio.getAttribute("data-sitio-id");

                    const optionSitio = document.createElement("option");
                    optionSitio.value = sitioId;
                    optionSitio.selected = true;

                    selectSitios.appendChild(optionSitio);
                }

                formularioEditarExcursion.appendChild(selectSitios);
            });
        });
    </script>
@stop
