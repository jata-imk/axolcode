@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Agregar sitio turístico')

@section('content_header')
<h1><span class="font-weight-bold">CloudTravel</span> | Agregar sitio turístico</h1>
@stop

@section('content')
<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">&nbsp;</h3>
    </div>

    <div class="card-body">
        <form id="form-agregar-sitio" action="{{route('sitios-turisticos.store')}}" method="post" enctype="multipart/form-data">
            @csrf

            <input type="hidden" id="linea1" name="linea1" value="">
            <input type="hidden" id="linea2" name="linea2" value="">
            <input type="hidden" id="linea3" name="linea3" value="">

            <div class="row form-title-section mb-2">
                <i class="fas fa-info-circle"></i>
                <h6>Información general</h6>
            </div>

            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label for="autocomplete">Nombre del lugar</label>
                        <input id="autocomplete" type="text" name="nombre" class="form-control" placeholder="Ingresar nombre del sitio" required>
                    </div>
                </div>

                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label for="descripcion">Descripción del lugar</label>
                        <textarea name="descripcion" id="descripcion" class="form-control" placeholder="Ingresar nombre del sitio" required></textarea>
                    </div>
                </div>

                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label for="latitud">Latitud</label>
                        <input id="latitud" type="text" name="latitud" class="form-control" readonly>
                    </div>
                </div>

                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label for="longitud">Longitud</label>
                        <input id="longitud" type="text" name="longitud" class="form-control" readonly>
                    </div>
                </div>
                
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label for="codigo_postal">Código Postal</label>
                        <input id="codigo_postal" type="text" name="codigo_postal" class="form-control" readonly>
                    </div>
                </div>
                
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label for="ciudad">Ciudad</label>
                        <input id="ciudad" type="text" name="ciudad" class="form-control" readonly>
                    </div>
                </div>

                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <input id="estado" type="text" name="estado" class="form-control" readonly>
                    </div>
                </div>

                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label for="codigo_pais">Código de País</label>
                        <input id="codigo_pais" type="text" name="codigo_pais" class="form-control" readonly>
                    </div>
                </div>
            </div>

            <div class="row form-title-section mt-4 mb-2">
                <i class="fas fa-images"></i>
                <h6>Galería de <span class="text-info">imágenes</span></h6>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div id="agregar-sitio-turistico-dropzone" class="dropzone">
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
        <button form="form-agregar-sitio" class="btn btn-primary mx-3" type="submit">
            <i class="fas fa-pencil-alt"></i>
            &nbsp;Agregar sitio
        </button>

        <a href="{{route('sitios-turisticos.index')}}" class="btn btn-danger">
            <i class="fas fa-times-circle"></i>
            &nbsp;Cancelar
        </a>
    </div>
</div>
@stop

@section('plugins.Dropzone', true)

@section('css')
    <link rel="stylesheet" href={{ asset("/assets/css/admin_custom.css") }}>
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

                for(let component of place.address_components) {
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
    </script>

    <script>
        $(function() {
            const formularioAgregarSitio = document.getElementById("form-agregar-sitio");

            // Dropzone
            let newDropZone = new Dropzone(`#agregar-sitio-turistico-dropzone`, {
                url: "./admin/sitios-turisticos/",
                paramName: 'file[]',
                autoProcessQueue: false,
                addRemoveLinks: true,
                dictDefaultMessage: "Arrastre o de click para agregar las imágenes",
                dictCancelUpload: "Cancelar subida",
                dictCancelUploadConfirmation: "¿Está seguro que desea cancelar la subida de la imagen?",
                dictRemoveFile: "Eliminar imagen",
                acceptedFiles: "image/*",
                previewTemplate: `
                    <div class="dz-preview dz-image-preview">
                        <div class="dz-image">
                            <img data-dz-thumbnail="">
                        </div>
                        <div class="dz-error-message">
                            <span data-dz-errormessage></span>
                        </div>
                    </div>
                `
            });

            formularioAgregarSitio.addEventListener("submit", (event) => {
                event.preventDefault();

                document.querySelector("button[type='submit']").disabled = true;
                document.querySelector("button[type='submit']").textContent = 'Guardando...';

                const formData = new FormData(formularioAgregarSitio);

                for (let file of Dropzone.instances[0].files) {
                    formData.append("file[]", file);
                }

                fetch(`./admin/sitios-turisticos?api=true`, {
                    method: "POST",
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.code == 201) {
                        document.location.href = "{{ route('sitios-turisticos.index') }}";
                    }
                })
                .catch(e => {
                    console.log(e)
                });
            });
        });
    </script>
@stop
