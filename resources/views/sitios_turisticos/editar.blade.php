@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Editar sitio turístico')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Editar sitio turístico</h1>
@stop

@section('content')
    <div class="row mb-2">
        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label class="col-form-label">
                    <i class="fas fa-info-circle"></i>&nbsp;
                    Fecha de creación
                </label>
                <input type="datetime-local" class="form-control form-control-sm" value="{{ $sitio->created_at }}" disabled>
            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label class="col-form-label">
                    <i class="fas fa-info-circle"></i>&nbsp;
                    Ultima actualización
                </label>
                <input type="datetime-local" class="form-control form-control-sm" value="{{ $sitio->updated_at }}" disabled>
            </div>
        </div>
    </div>

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
        </div>

        <div class="card-body">
            <form id="form-editar-sitio" action="{{ route('sitios-turisticos.update', $sitio->id) }}" method="post">
                @csrf
                @method('put')

                <input type="hidden" id="linea1" name="linea1" value="{{ $sitio->linea1 }}">
                <input type="hidden" id="linea2" name="linea2" value="{{ $sitio->linea2 }}">
                <input type="hidden" id="linea3" name="linea3" value="{{ $sitio->linea3 }}">

                <div class="row form-title-section mb-2">
                    <i class="fas fa-info-circle"></i>
                    <h6>Información general</h6>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="autocomplete">Nombre del lugar</label>
                            <input id="autocomplete" type="text" name="nombre" class="form-control" placeholder="Ingresar nombre del sitio" value="{{ $sitio->nombre }}" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="descripcion">Descripción del lugar</label>
                            <textarea name="descripcion" id="descripcion" class="form-control" placeholder="Ingresar nombre del sitio" required>{{ $sitio->descripcion }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="latitud">Latitud</label>
                            <input id="latitud" type="text" name="latitud" class="form-control" value="{{ $sitio->latitud }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="longitud">Longitud</label>
                            <input id="longitud" type="text" name="longitud" class="form-control" value="{{ $sitio->longitud }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="codigo_postal">Código Postal</label>
                            <input id="codigo_postal" type="text" name="codigo_postal" class="form-control" value="{{ $sitio->codigo_postal }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="ciudad">Ciudad</label>
                            <input id="ciudad" type="text" name="ciudad" class="form-control" value="{{ $sitio->ciudad }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <input id="estado" type="text" name="estado" class="form-control" value="{{ $sitio->estado }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="codigo_pais">Código de País</label>
                            <input id="codigo_pais" type="text" name="codigo_pais" class="form-control" value="{{ $sitio->codigo_pais }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="row form-title-section mt-4 mb-2">
                    <i class="fas fa-images"></i>
                    <h6>Galería de <span class="text-info">imágenes</span></h6>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div id="editar-sitio-turistico-dropzone" class="dropzone @php echo ($sitio->imagenes->count() > 0) ? "dz-started" : "" @endphp">
                            @foreach ($sitio->imagenes as $imagen)
                                <div class="dz-preview dz-image-preview" data-toggle="modal" data-target="#modalEditarImagen">
                                    <div class="dz-image">
                                        <img data-dz-thumbnail loading="lazy" alt="storage/{{ $imagen->path }}" src="storage/{{ $imagen->path }}" style="width: 100%;height: 100%;object-fit: cover;" onerror="handleImgLoad(event)" data-id="{{ $imagen->id }}" data-created-at="{{ $imagen->created_at }}" data-titulo="{{ $imagen->titulo }}" data-descripcion="{{ $imagen->descripcion }}" data-leyenda="{{ $imagen->leyenda }}" data-texto-alternativo="{{ $imagen->texto_alternativo }}">
                                    </div>

                                    <a class="dz-remove" href="" onclick="eliminarImagenExcursion(event, {{ $imagen->id }})" data-dz-remove="">Eliminar imagen</a>

                                    <div class="dz-custom">
                                        <button class="dz-custom__btn dz-custom__btn-star @php echo ($imagen->principal_tarjetas == 1) ? "dz-custom__btn-star-selected" : "" @endphp " onclick="marcarImagen(event, {{ $imagen->id }})" data-column="principal_tarjetas" data-class="dz-custom__btn-star">⭐</button>
                                        <button class="dz-custom__btn dz-custom__btn-tag @php echo ($imagen->principal_portadas == 1) ? "dz-custom__btn-tag-selected" : "" @endphp " onclick="marcarImagen(event, {{ $imagen->id }})" data-column="principal_portadas" data-class="dz-custom__btn-tag">🅿</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button form="form-editar-sitio" class="btn btn-primary mx-3" type="submit">
                <i class="fas fa-pencil-alt"></i>
                &nbsp;Actualizar sitio
            </button>

            <a href="{{ route('sitios-turisticos.index') }}" class="btn btn-danger">
                <i class="fas fa-times-circle"></i>
                &nbsp;Cancelar
            </a>
        </div>

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

@section('plugins.Dropzone', true)

@section('css')
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
@stop

@section('js')
    <!-- Google Maps -->
    <script>
        function initAutocomplete() {
            var input = document.getElementById("autocomplete");

            var options = {
                fields: ["geometry", "name", "address_components"],
            };

            var autocomplete = new google.maps.places.Autocomplete(input, options);

            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            autocomplete.addListener("place_changed", () => {
                var place = autocomplete.getPlace();

                if (place.length == 0) {
                    return;
                }

                var addressComponents = {};

                for (let component of place.address_components) {
                    if (component.types[0] === "country") {
                        addressComponents[component.types[0]] = component.short_name;
                    } else {
                        addressComponents[component.types[0]] = component.long_name;
                    }
                }

                document.getElementById("autocomplete").value = place.name;
                document.getElementById("latitud").value = place.geometry.location.lat()
                document.getElementById("longitud").value = place.geometry.location.lng();

                document.getElementById("linea1").value = `${addressComponents.route || ''} ${addressComponents.street_number || ''} ${addressComponents.hasOwnProperty('subpremise') ? 'x' : ''} ${addressComponents.subpremise || ''}`;
                document.getElementById("linea3").value = addressComponents.sublocality_level_1 || '';

                document.getElementById("codigo_postal").value = addressComponents.postal_code || '';
                document.getElementById("ciudad").value = addressComponents.locality || '';
                document.getElementById("estado").value = addressComponents.administrative_area_level_1 || '';
                document.getElementById("codigo_pais").value = addressComponents.country || '';
            });
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDX-1fASrnWkMk0ti7rSV5BcDSFIpYR5v4&libraries=places&callback=initAutocomplete"></script>

    <script>
        Dropzone.autoDiscover = false;

        function eliminarImagenExcursion(event, idModeloParaEliminar) {
            event.preventDefault();
            event.stopPropagation();

            const formulario = new FormData();
            formulario.append("_method", "DELETE");
            formulario.append("_token", "{{ csrf_token() }}");

            fetch(`./admin/sitios-turisticos/{{ $sitio->id }}/imagenes/${idModeloParaEliminar}`, {
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

            fetch(`./admin/sitios-turisticos/{{ $sitio->id }}/imagenes/${idModeloImagenFavorita}`, {
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
    </script>

    <script>
        $(document).ready(function() {
            const formularioEditarSitio = document.getElementById("form-editar-sitio");

            // Dropzone
            let newDropZone = new Dropzone(`#editar-sitio-turistico-dropzone`, {
                url: "./admin/sitios-turisticos/{{ $sitio->id }}/imagenes",
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
                        <div class="dz-image">
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
                            <button class="dz-custom__btn dz-custom__btn-star" data-column="principal_tarjetas" data-class="dz-custom__btn-star">⭐</button>
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
                    <x-generales.imagenes.formularios.editar action="{{ route('sitios-turisticos.index') }}/{{ $sitio->id }}/imagenes/${imgId}" path="${imgElement.src}" className="form-modal" btnSubmit="false" imagen-id="${imgId}" titulo="${imgTitulo}" descripcion="${imgDescripcion}" leyenda="${imgLeyenda}" texto-alternativo="${imgTextoAlternativo}">
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
                            imgElement.setAttribute("data-titulo", data.body.modelo.titulo);
                            imgElement.setAttribute("data-descripcion", data.body.modelo.descripcion);
                            imgElement.setAttribute("data-leyenda", data.body.modelo.leyenda);
                            imgElement.setAttribute("data-texto-alternativo", data.body.modelo.texto_alternativo);

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

            formularioEditarSitio.addEventListener("submit", (event) => {
                document.querySelector(".card-footer button[type='submit']").disabled = true;
                document.querySelector(".card-footer button[type='submit']").textContent = 'Guardando...';
            });
        });
    </script>
@stop
