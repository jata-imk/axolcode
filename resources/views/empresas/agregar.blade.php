@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Agregar empresa')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Agregar empresa</h1>
@stop

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
        </div>

        <div class="card-body">
            <form id="form-agregar-empresa" action="{{ route('empresas.store') }}" method="POST" enctype="multipart/form-data" >
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input id="empresa-telefono-oficina-codigo-pais" type="hidden" name="empresa-telefono-oficina-codigo-pais" value="">
                <input id="empresa-telefono-celular-codigo-pais" type="hidden" name="empresa-telefono-celular-codigo-pais" value="">

                <div class="row border-bottom mb-2">
                    <h6>Información general</h6>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="empresa-nombre-comercial">Nombre comercial</label>
                            <input id="empresa-nombre-comercial" type="text" name="empresa-nombre-comercial" maxlength="127" class="form-control" placeholder="Ingresar nombre comercial..." required>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="empresa-razon-social">Razón social</label>
                            <input id="empresa-razon-social" type="text" name="empresa-razon-social" maxlength="127" class="form-control" placeholder="Ingresar razón social..." required>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <label for="empresa-telefono-oficina">Teléfono (Oficina)</label>
                        <div class="input-group mb-3">
                            <input id="empresa-telefono-oficina" type="tel" name="empresa-telefono-oficina" class="form-control" placeholder="(123) 456 78 90">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <label for="empresa-telefono-celular">Teléfono (Celular)</label>
                        <div class="input-group mb-3">
                            <input id="empresa-telefono-celular" type="tel" name="empresa-telefono-celular" class="form-control" placeholder="(123) 456 78 90">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <label for="empresa-rfc">RFC</label>
                        <div class="input-group mb-3">
                            <input id="empresa-rfc" type="text" name="empresa-rfc" class="form-control" placeholder="Ingresar RFC..." required>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label for="empresa-tipo-persona">Tipo de persona</label>
                            <select id="empresa-tipo-persona" class="form-control" name="empresa-tipo-persona">
                                <option value="1">Física</option>
                                <option value="2">Moral</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label for="empresa-tipo-empresa">Tipo de empresa</label>
                            <select id="empresa-tipo-empresa" class="form-control" name="empresa-tipo-empresa">
                                <option value="1">Agencia de viajes</option>
                                <option value="2">Vendedor</option>
                                <option value="3">Bloguero</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row border-bottom mb-2 mt-4">
                    <h6>Información de la <span class="text-info">pagina WEB</span></h6>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="pagina-web-url">URL de la pagina WEB</label>
                            <input id="pagina-web-url" type="text" name="pagina-web-url" maxlength="127" class="form-control" placeholder="Ingresar URL de la pagina WEB..." required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="pagina-web-logo">Logo WEB</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="pagina-web-logo" name="pagina-web-logo" accept="image/*" required>
                                    <label class="custom-file-label" for="pagina-web-logo">Escoja un fichero</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Subir</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row border-bottom mb-2 mt-4">
                    <h6>Información de la <span class="text-info">dirección comercial</span></h6>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Linea 1</label>
                            <input type="text" name="direccion-comercial-linea-uno" maxlength="127" class="form-control" placeholder="Ingresar calle y número..." required>
                            <small class="form-text text-muted">
                                Usada comúnmente para indicar la calle y número exterior e interior.
                            </small>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Linea 2</label>
                            <input type="text" name="direccion-comercial-linea-dos" maxlength="127" class="form-control" placeholder="Ingresar condominio, suite o delegación...">
                            <small class="form-text text-muted">
                                Usada comúnmente para indicar condominio, suite o delegación.
                            </small>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Linea 3</label>
                            <input type="text" name="direccion-comercial-linea-tres" maxlength="127" class="form-control" placeholder="Ingresar colonia...">
                            <small class="form-text text-muted">
                                Usada comúnmente para indicar la colonia.
                            </small>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 mt-4 mb-4"></div>

                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">

                            <div id="geocoder-comercial">
                                <label>Código Postal:</label>
                            </div>
                            <pre id="result-comercial" class="m-0 p-0"></pre>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label>Ciudad</label>
                            <input id="direccion-comercial-ciudad" type="text" name="direccion-comercial-ciudad" class="form-control" placeholder="Ciudad..." readonly>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label>Estado</label>
                            <input id="direccion-comercial-estado" type="text" name="direccion-comercial-estado" class="form-control" placeholder="Estado..." readonly>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label>Código del país</label>
                            <input id="direccion-comercial-pais" type="text" name="direccion-comercial-pais" class="form-control" placeholder="Código del país..." readonly>
                        </div>
                    </div>
                </div>

                <div class="row border-bottom mb-2 mt-4 align-items-center pt-2 pb-2">
                    <h6 class="m-0">Información de la <span class="text-info">dirección fiscal</span></h6>

                    <div class="form-group m-0 ml-3">
                        <div class="custom-control custom-switch" style="position: unset;">
                            <input type="checkbox" class="custom-control-input" name="direccion-fiscal-misma-que-comercial" id="direccion-fiscal-misma-que-comercial">
                            <label class="custom-control-label" for="direccion-fiscal-misma-que-comercial">Usar la dirección comercial</label>
                        </div>
                    </div>
                </div>

                <div id="contenedor-informacion-direccion-fiscal" class="row ocultar mostrar">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Linea 1</label>
                            <input type="text" name="direccion-fiscal-linea-uno" maxlength="127" class="form-control" placeholder="Ingresar calle y número..." required data-required="true">
                            <small class="form-text text-muted">
                                Usada comúnmente para indicar la calle y número exterior e interior.
                            </small>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Linea 2</label>
                            <input type="text" name="direccion-fiscal-linea-dos" maxlength="127" class="form-control" placeholder="Ingresar condominio, suite o delegación...">
                            <small class="form-text text-muted">
                                Usada comúnmente para indicar condominio, suite o delegación.
                            </small>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Linea 3</label>
                            <input type="text" name="direccion-fiscal-linea-tres" maxlength="127" class="form-control" placeholder="Ingresar colonia...">
                            <small class="form-text text-muted">
                                Usada comúnmente para indicar la colonia.
                            </small>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 mt-4 mb-4"></div>

                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">

                            <div id="geocoder-fiscal">
                                <label>Código Postal:</label>
                            </div>
                            <pre id="result-fiscal" class="m-0 p-0"></pre>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label>Ciudad</label>
                            <input id="direccion-fiscal-ciudad" type="text" name="direccion-fiscal-ciudad" class="form-control" placeholder="Ciudad..." readonly>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label>Estado</label>
                            <input id="direccion-fiscal-estado" type="text" name="direccion-fiscal-estado" class="form-control" placeholder="Estado..." readonly>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label>Código del país</label>
                            <input id="direccion-fiscal-pais" type="text" name="direccion-fiscal-pais" class="form-control" placeholder="Código del país..." readonly>
                        </div>
                    </div>
                </div>
        </div>

        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button form="form-agregar-empresa" class="btn btn-primary mx-3" type="submit">
                <i class="fas fa-pencil-alt"></i>
                Guardar empresa
            </button>

            <a href="{{ route('empresas.index') }}" class="btn btn-danger" type="button">
                <i class="fas fa-times-circle"></i> Cancelar
            </a>
        </div>
    </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
@stop

@section('plugins.IntTelInput', true)
@section('plugins.MapboxGL', true)
@section('plugins.MapboxGL_Geocoder', true)
@section('plugins.BS_Custom_FileInput', true)

@section('js')
    <script>
        (function() {
            document.addEventListener("DOMContentLoaded", function() {
                /* Código que se ejecutará una vez se haya cargado todo el HTML */
                const formulario = document.getElementById("form-agregar-empresa")

                const inputEmpresaTelOficina = document.querySelector("#empresa-telefono-oficina");
                const inputEmpresaTelCelular = document.querySelector("#empresa-telefono-celular");

                const switchDireccionFiscalMismaQueComercial = document.getElementById("direccion-fiscal-misma-que-comercial");

                bsCustomFileInput.init();

                ///////////////////////////////////
                // International Telephone Input //
                ///////////////////////////////////
                let itiEmpresaTelefonoOficina = intlTelInput(inputEmpresaTelOficina, {
                    initialCountry: "auto",
                    separateDialCode: true,
                    geoIpLookup: function(callback) {
                        fetch('https://ipinfo.io/?token=7c0ae29766d659', {
                                headers: {
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => callback(data.country));
                    }
                });

                let itiEmpresaTelefonoCelular = intlTelInput(inputEmpresaTelCelular, {
                    initialCountry: "auto",
                    separateDialCode: true,
                    geoIpLookup: function(callback) {
                        fetch('https://ipinfo.io/?token=7c0ae29766d659', {
                                headers: {
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => response.json())
                            .then(data => callback(data.country));
                    }
                });

                ////////////
                // MAPBOX //
                ////////////
                mapboxgl.accessToken = 'pk.eyJ1IjoiamF0YS1pbWsiLCJhIjoiY2t4cWZrcWxiNWp3ejJxcnl3ZGsxNGpsOCJ9.8XKJesiS_V1qQwmXcTuOoA';

                const geocoderComercial = new MapboxGeocoder({
                    accessToken: mapboxgl.accessToken,
                    types: 'postcode',
                    placeholder: ' ',
                    minLength: 4
                });

                geocoderComercial.addTo('#geocoder-comercial');
                geocoderComercial.container.querySelector("input").name = 'direccion-comercial-cp';
                geocoderComercial.container.querySelector("input").parentElement.className = "mapboxgl-ctrl-geocoder mapboxgl-ctrl w-100 min-width-unset max-width-none shadow-none form-control p-0";
                geocoderComercial.container.querySelector("input").autocomplete = 'nope';
                geocoderComercial.container.querySelector("input").required = true;

                // Get the geocoder results container.
                const resultComercialEstado = document.getElementById('direccion-comercial-estado');
                const resultComercialCiudad = document.getElementById('direccion-comercial-ciudad');
                const resultComercialPais = document.getElementById('direccion-comercial-pais');

                // Add geocoder result to container.
                geocoderComercial.on('result', (e) => {
                    const contexto = e.result.context;

                    for (let item of contexto) {
                        if (item.id.includes("place")) {
                            resultComercialCiudad.value = item.text;
                        } else if (item.id.includes("region")) {
                            resultComercialEstado.value = item.text;
                        } else if (item.id.includes("country")) {
                            resultComercialPais.value = item.short_code.toUpperCase();
                        }
                    }

                    geocoderComercial.container.querySelector("input").value = e.result.text;
                });

                // Clear results container when search is cleared.
                geocoderComercial.on('clear', () => {
                    document.getElementById("result-comercial").innerText = '';
                });

                const geocoderFiscal = new MapboxGeocoder({
                    accessToken: mapboxgl.accessToken,
                    types: 'postcode',
                    placeholder: ' ',
                    minLength: 4
                });

                geocoderFiscal.addTo('#geocoder-fiscal');
                geocoderFiscal.container.querySelector("input").name = 'direccion-fiscal-cp';
                geocoderFiscal.container.querySelector("input").parentElement.className = "mapboxgl-ctrl-geocoder mapboxgl-ctrl w-100 min-width-unset max-width-none shadow-none form-control p-0";
                geocoderFiscal.container.querySelector("input").autocomplete = 'nope';
                geocoderFiscal.container.querySelector("input").required = true;
                geocoderFiscal.container.querySelector("input").setAttribute("data-required", "true");

                // Get the geocoder results container.
                const resultFiscalEstado = document.getElementById('direccion-fiscal-estado');
                const resultFiscalCiudad = document.getElementById('direccion-fiscal-ciudad');
                const resultFiscalPais = document.getElementById('direccion-fiscal-pais');

                // Add geocoder result to container.
                geocoderFiscal.on('result', (e) => {
                    const contexto = e.result.context;

                    for (let item of contexto) {
                        if (item.id.includes("place")) {
                            resultFiscalCiudad.value = item.text;
                        } else if (item.id.includes("region")) {
                            resultFiscalEstado.value = item.text;
                        } else if (item.id.includes("country")) {
                            resultFiscalPais.value = item.short_code.toUpperCase();
                        }
                    }

                    geocoderFiscal.container.querySelector("input").value = e.result.text;
                });

                // Clear results container when search is cleared.
                geocoderFiscal.on('clear', () => {
                    document.getElementById("result-fiscal").innerText = '';
                });

                ///////////////////////////////////////////////////////////
                // Switch dirección fiscal misma que dirección comercial //
                ///////////////////////////////////////////////////////////
                const setRequiredInputsDireccionFiscal = (inputs, boolRequired) => {
                    for (let inputInformacionDireccionFiscal of inputs) {
                        inputInformacionDireccionFiscal.required = boolRequired;
                    }
                };

                switchDireccionFiscalMismaQueComercial.addEventListener("change", (event) => {
                    const contenedorInformacionDireccionFiscal = document.getElementById("contenedor-informacion-direccion-fiscal");
                    const inputsInformacionDireccionFiscal = contenedorInformacionDireccionFiscal.querySelectorAll("input[data-required=true]");

                    if (!switchDireccionFiscalMismaQueComercial.checked) {
                        contenedorInformacionDireccionFiscal.classList.add("mostrar");
                        setRequiredInputsDireccionFiscal(inputsInformacionDireccionFiscal, true);
                    } else {
                        contenedorInformacionDireccionFiscal.classList.remove("mostrar");
                        setRequiredInputsDireccionFiscal(inputsInformacionDireccionFiscal, false);
                    }
                });

                ///////////////////////////
                // SUBIDA DEL FORMULARIO //
                ///////////////////////////
                formulario.addEventListener("submit", (event) => {
                    document.getElementById("empresa-telefono-oficina-codigo-pais").value = itiEmpresaTelefonoOficina.getSelectedCountryData().dialCode;
                    document.getElementById("empresa-telefono-celular-codigo-pais").value = itiEmpresaTelefonoCelular.getSelectedCountryData().dialCode;
                });
            });
        })();
    </script>
@stop
