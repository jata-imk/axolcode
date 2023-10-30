@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Agregar excursión')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Agregar excursión</h1>
@stop

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
        </div>

        <form id="frm-get-promotion" method="GET">
            @csrf
        </form>

        <div class="card-body">
            <form id="form-agregar-excursion" class="form-excursion" action="{{ route('excursiones.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="row form-title-section mb-2">
                    <i class="fas fa-umbrella-beach"></i>
                    <h6>Información general de la excursión</h6>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" class="form-control" placeholder="Ingresar nombre" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-floating">
                            <label>Tipo de excursión</label>
                            <select name="id_tipo" class="form-control select2" required >
                                <option value="" selected disabled hidden> -- Seleccione una opción</option>
                                @foreach ($tipos as $tipo)
                                    <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-floating">
                            <label>Descripción de la excursión</label>
                            <textarea class="form-control" name="descripcion" placeholder="Agregar una descripción de la excursión" style="height: 100px" required></textarea>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Video de Youtube <small>(Opcional)</small></label>
                            <input type="text" name="youtube" class="form-control" placeholder="Link del video de YouTube">
                        </div>
                    </div>
                    
                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label>¿Es calendarizado?</label>
                            <select class="form-control select2" name="calendario" required>
                                <option value="" selected disabled hidden> -- Seleccione una opción</option>
                                <option value="0">No</option>
                                <option value="1">Sí</option>
                            </select>
                        </div>


                        <div id="dias_disponible__container" class="dias_disponible__container ocultar">            
                            <label class="w-100">
                                <span class="fas fa-clock"></span>
                                &nbsp;Disponibilidad
                            </label>
        
                            <div class="dias_disponible__checkbox">
                                <label for="dias_disponible_0">Domingo</label>
                                <input type="checkbox" value="0" id="dias_disponible_0" name="dias_disponible[]" checked>
                            </div>
                            <div class="dias_disponible__checkbox">
                                <label for="dias_disponible_1">Lunes</label>
                                <input type="checkbox" value="1" id="dias_disponible_1" name="dias_disponible[]" checked>
                            </div>
                            <div class="dias_disponible__checkbox">
                                <label for="dias_disponible_2">Martes</label>
                                <input type="checkbox" value="2" id="dias_disponible_2" name="dias_disponible[]" checked>
        
                            </div>
                            <div class="dias_disponible__checkbox">
                                <label for="dias_disponible_3">Miércoles</label>
                                <input type="checkbox" value="3" id="dias_disponible_3" name="dias_disponible[]" checked>
                            </div>
                            <div class="dias_disponible__checkbox">
                                <label for="dias_disponible_4">Jueves</label>
                                <input type="checkbox" value="4" id="dias_disponible_4" name="dias_disponible[]" checked>
                            </div>
                            <div class="dias_disponible__checkbox">
                                <label for="dias_disponible_5">Viernes</label>
                                <input type="checkbox" value="5" id="dias_disponible_5" name="dias_disponible[]" checked>
                            </div>
                            <div class="dias_disponible__checkbox">
                                <label for="dias_disponible_6">Sábado</label>
                                <input type="checkbox" value="6" id="dias_disponible_6" name="dias_disponible[]" checked>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="form-group" data-select2-id="53">
                            <label>Publicar excursión</label>
                            <select class="form-control select2" name="publicar_excursion" required>
                                <option value="" selected disabled hidden> -- Seleccione una opción</option>
                                <option value="0">Aun no publicar la excursión</option>
                                <option value="1">Publicar al guardar</option>
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
                            <select id="incluye" name="incluye[]" multiple class="form-control select2bs4 select2-hidden-accessible">
                                @foreach ($servicios as $servicio)
                                    <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-floating">
                            <label>No incluye</label>
                            <select id="no_incluye" name="no_incluye[]" multiple class="form-control select2bs4 select2-hidden-accessible">
                                @foreach ($servicios as $servicio)
                                    <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-floating">
                            <label>Categorías de la excursión</label>
                            <select id="categoria" name="categoria[]" multiple class="form-control select2bs4 select2-hidden-accessible">
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-floating">
                            <label>Recomendaciones</label>
                            <select id="recomendacion" name="recomendacion[]" multiple class="form-control select2bs4 select2-hidden-accessible">
                                @foreach ($recomendaciones as $recomendacion)
                                    <option value="{{ $recomendacion->id }}">{{ $recomendacion->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <label for="itinerario">Agregar itinerario PDF <span class="text-danger">(Archivo en PDF)</span></label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="itinerario" name="itinerario" accept="application/pdf" required>
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
                    <h6>Itinerario por días</h6>
                </div>

                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label>Días de duración</label>
                            <input type="number" name="cantidad_dias" class="form-control" min="1" placeholder="Introducir cantidad..." required>
                        </div>
                    </div>
                </div>

                <div class="row form-title-section mt-4 mb-2">
                    <i class="fas fa-images"></i>
                    <h6>Galería de <span class="text-info">imágenes</span></h6>

                    <!-- TODO: Al hacer click en una imagen que salga un modal de BOOTSTRAP para editar sus detalles mediante AJAX (alt, title, description, etc.) -->
                    <!-- TODO: Añadir el campo principal_portada a las imágenes -->
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div id="agregar-excursion-dropzone" class="dropzone">
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
                            <input type="text" class="form-control" name="titulo_sitio" placeholder="Ejemplo: Tour a Chiapas de 5 días y 4 noches..." required>

                            <small class="form-text text-muted">
                                Los buscadores más importantes usan esta etiqueta para titular las entradas en las listas de resultados o SERP, de modo que influye de forma decisiva en la elección del internauta.
                            </small>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="form-floating">
                            <label>Palabras clave del sitio</label>
                            <textarea class="form-control" placeholder="Ejemplo: tour a Chiapas, Chiapas todo incluido, excursión a Chiapas, viaje a Chiapas.." style="height: 100px" name="keywords_sitio" required></textarea>
                            
                            <small class="form-text text-muted">
                                Con esta etiqueta meta los administradores tienen la posibilidad de definir palabras clave para el buscador. Las keywords son aquellos criterios a los que responde un buscador para ofrecerle al usuario páginas HTML como respuesta.
                            </small>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="form-floating">
                            <label>Descripción del sitio</label>
                            <textarea class="form-control" placeholder="Ejemplo: Vive la experiencia de nuestro tour a Chiapas..." style="height: 100px" name="descripcion_sitio" required></textarea>
                            
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
                            <select class="form-control" name="menores" required>
                                <option value="" selected disabled hidden> -- Seleccione una opción</option>
                                <option value="0">No</option>
                                <option value="1">Sí</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>¿Se aceptan infantes?</label>
                            <select class="form-control" name="infantes" required>
                                <option value="" selected disabled hidden> -- Seleccione una opción</option>
                                <option value="0">No</option>
                                <option value="1">Sí</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="form-group">
                            <label>¿Incluye hotelería?</label>
                            <select class="form-control" name="hoteleria" required>
                                <option value="" selected disabled hidden> -- Seleccione una opción</option>
                                <option value="0">No</option>
                                <option value="1">Sí</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-sm-6">
                        <div class="form-group">
                            <label>¿Incluye vuelos?</label>
                            <select class="form-control" name="vuelos" required>
                                <option value="" selected disabled hidden> -- Seleccione una opción</option>
                                <option value="0">No</option>
                                <option value="1">Sí</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="form-group">
                            <label>Moneda</label>
                            <select class="form-control" name="id_moneda" required>
                                <option value="" selected disabled hidden> -- Seleccione una opción</option>

                                @foreach ($monedas as $moneda)
                                    <option value="{{$moneda->id}}">{{$moneda->nombre}} ({{$moneda->iso}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="form-group">
                            <label>Tipo de tarifa</label>
                            <select id="tipo_tarifa" class="form-control" name="tipo_tarifa" required>
                                <option value="" selected disabled hidden> -- Seleccione una opción</option>
                                <option value="1">Por persona</option>
                                <option value="2">Grupal</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="form-group">
                            <label>Tamaño del grupo</label>
                            <input id="cantidad_pasajeros_grupo" class="form-control" type="number" step="1" name="cantidad_pasajeros_grupo" value="" min="2" max="255" placeholder="Solo para tarifas grupales" disabled>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="form-group">
                            <label>Método para calculo de precios</label>
                            <select class="form-control" name="metodo_calculo_precio" required>
                                <option value="" selected disabled hidden> -- Seleccione una opción</option>
                                <option value="1">Asignación directa</option>
                                <option value="2">Mediante formula de costeo</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button form="form-agregar-excursion" class="btn btn-primary mx-3" type="submit">
                <i class="fas fa-pencil-alt"></i>
                Agregar excursión
            </button>

            <a href="{{ route('excursiones.index') }}" class="btn btn-danger">
                <i class="fas fa-times-circle"></i>
                Cancelar
            </a>
        </div>
    </div>
@stop

@section('plugins.FilterMultiSelectCustom', true)
@section('plugins.Select2', true)
@section('plugins.BS_Custom_FileInput', true)
@section('plugins.Dropzone', true)

@section('css')
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
@stop

@section('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <script>
        Dropzone.autoDiscover = false;
    </script>

    <script>
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

            const formularioAgregarExcursion = document.getElementById("form-agregar-excursion");

            // Se inicia el file input custom
            bsCustomFileInput.init();

            // Dropzone
            let newDropZone = new Dropzone(`#agregar-excursion-dropzone`, {
                url: "./admin/excursiones/",
                autoProcessQueue: false,
                addRemoveLinks: true,
                dictDefaultMessage: "Arrastre o de click para agregar las imágenes",
                dictCancelUpload: "Cancelar subida",
                dictCancelUploadConfirmation: "¿Está seguro que desea cancelar la subida de la imagen?",
                dictRemoveFile: "Eliminar imagen",
                acceptedFiles: "image/*",
                previewTemplate: `
                    <div class="dz-preview dz-image-preview" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <div class="dz-image">
                            <img data-dz-thumbnail="">
                        </div>
                        <div class="dz-error-message">
                            <span data-dz-errormessage></span>
                        </div>
                    </div>
                `
            });

            ////////////////////////////////
            // Sección de sitios turísticos
            ////////////////////////////////
            const contenedorSitios = document.getElementById("sitios");

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
                                        <i class="fas fa-map-pin"></i> ${repo.latitud}, ${repo.longitud}
                                    </div>
                                </div>
                            </div>
                
                            <button type="button" class="close sitio__close-btn">
                                <span>&times;</span>
                            </button>
                        </div>`;
                        contenedorSitios.insertAdjacentHTML('beforeend', templateSitio);
    
                        contenedorSitios.lastElementChild.querySelector('.sitio__close-btn').addEventListener("click", (event) => {eliminarItemSitio(event)});                
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
            
            formularioAgregarExcursion.addEventListener("submit", (event) => {
                event.preventDefault();
                
                document.querySelector(".card-footer button[type='submit']").disabled = true;
                document.querySelector(".card-footer button[type='submit']").textContent = 'Guardando...';

                let formData = new FormData(formularioAgregarExcursion);

                const sitiosItems = document.querySelectorAll("#sitios .sitio__item");
                for (let sitio of sitiosItems) {
                    const sitioId = sitio.getAttribute("data-sitio-id");

                    formData.append("sitios[]", sitioId);
                }

                fetch(formularioAgregarExcursion.action, {
                    method: "POST",
                    body: formData
                })
                .then(res => res.json())
                .then((dataExcursion) => {
                    if (dataExcursion.code == "201") { // Si la excursión fue creada correctamente
                        // Se procesa la subida de las imágenes
                        const formDataImgs = new FormData();
    
                        formDataImgs.append("session_flash", dataExcursion.body.session_flash)
                        formDataImgs.append("_token", '{{ csrf_token() }}')
                        for (let file of Dropzone.instances[0].files) {
                            formDataImgs.append("file[]", file);
                        }
    
                        fetch(`./admin/excursiones/${dataExcursion.body.id_excursion}/imagenes`, {
                            method: "POST",
                            body: formDataImgs
                        })
                        .then(res => res.json())
                        .then(dataImg => {
                            document.location.href = '{{ route('excursiones.index') }}';
                        });
                    } else { // Si la excursión tuvo algún error al guardarse se redirige al listado de excursiones
                        // document.location.href = '{{ route('excursiones.index') }}';
                        document.querySelector(".card-footer button[type='submit']").disabled = false;
                        document.querySelector(".card-footer button[type='submit']").textContent = 'Reintentar';
                    }
                })
                .catch(e => {
                    //Redirigir a la pagina del listado de excursiones
                    console.log(e);
                    
                    document.querySelector(".card-footer button[type='submit']").disabled = false;
                    document.querySelector(".card-footer button[type='submit']").textContent = 'Reintentar';
                    // document.location.href = '{{ route('excursiones.index') }}';
                });
            });
        });
    </script>
@stop
