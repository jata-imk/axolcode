@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Agregar cliente')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Agregar cliente</h1>
@stop

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
        </div>

        <div class="card-body">
            <form action="{{ route('clientes.store') }}" method="post" id="form-agregar-cliente">
                @csrf

                <input type="hidden" name="telefono_casa_codigo_pais" id="telefono_casa_codigo_pais" value="" />
                <input type="hidden" name="telefono_casa_iso_pais" id="telefono_casa_iso_pais" value="" />

                <input type="hidden" name="telefono_celular_codigo_pais" id="telefono_celular_codigo_pais" value="" />
                <input type="hidden" name="telefono_celular_iso_pais" id="telefono_celular_iso_pais" value="" />

                <div class="row border-bottom mb-2">
                    <h6>Información del cliente</h6>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input name="nombre" required type="text" class="form-control" placeholder="Ingresar nombre">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Apellido</label>
                            <input name="apellido" required type="text" class="form-control" placeholder="Ingresar apellido">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <label>Teléfono | Celular</label>
                        <div class="input-group mb-3">
                            <input name="telefono_celular" id="telefono_celular" required type="text" class="form-control" placeholder="Ingresar teléfono celular">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <label>Teléfono | Casa (Opcional)</label>
                        <div class="input-group mb-3">
                            <input name="telefono_casa" id="telefono_casa" type="text" class="form-control" placeholder="Ingresar teléfono de casa">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <label>Correo electrónico</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input name="email_principal" required type="email" class="form-control" placeholder="Ingresar correo">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <label>Correo electrónico secundario (Opcional)</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input name="email_secundario" type="email" class="form-control" placeholder="Ingresar correo secundario">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="id_status">Status inicial:</label>
                            
                            <select id="id_status" class="form-control" name="id_status" required>
                                <option value="" selected disabled hidden> -- Seleccione una opción</option>
                                
                                @foreach ($statusClientes as $status)
                                    <option value="{{$status->id}}" style="color: {{$status->color}}; background-color: {{$status->background_color}}">{{$status->descripcion}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row border-bottom mb-2 mt-4">
                    <h6>Información de la <span class="text-info">dirección del cliente</span></h6>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Linea 1</label>
                            <input type="text" name="linea1" class="form-control" placeholder="Ingresar linea 1">
                            <small class="form-text text-muted">
                                Usada comúnmente para indicar la calle y número exterior e interior.
                            </small>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Linea 3</label>
                            <input type="text" name="linea3" class="form-control" placeholder="Ingresar linea 3">
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
                            <input type="text" name="ciudad" class="form-control" placeholder="Ingresar Ciudad">
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label>Estado</label>
                            <input type="text" name="estado" class="form-control" placeholder="Ingresar Estado">
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label>País</label>
                            <input type="text" name="pais" class="form-control" placeholder="Ingresar código de país">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button form="form-agregar-cliente" class="btn btn-primary mx-3" type="submit">
                <i class="fas fa-pencil-alt"></i>
                Agregar cliente
            </button>

            <a href="{{ route('clientes.index') }}" class="btn btn-danger">
                <i class="fas fa-times-circle"></i>
                Cancelar
            </a>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
@stop

@section('plugins.IntTelInput', true)
@section('plugins.MapboxGL', true)
@section('plugins.MapboxGL_Geocoder', true)

@section('js')
    <script>
        (function() {
            const inputClienteTelCasa = document.querySelector("#telefono_casa");
            const inputClienteTelCel = document.querySelector("#telefono_celular");

            ///////////////////////////////////
            // International Telephone Input //
            ///////////////////////////////////
            let itiClienteTelCasa = intlTelInput(inputClienteTelCasa, {
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

            let itiClienteTelCel = intlTelInput(inputClienteTelCel, {
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
            geocoderComercial.container.querySelector("input").name = 'codigo_postal';
            geocoderComercial.container.querySelector("input").parentElement.className = "mapboxgl-ctrl-geocoder mapboxgl-ctrl w-100 min-width-unset max-width-none shadow-none form-control p-0";
            geocoderComercial.container.querySelector("input").autocomplete = 'nope';
            geocoderComercial.container.querySelector("input").required = true;

            // Get the geocoder results container.
            const resultComercialEstado = document.querySelector('input[name=estado]');
            const resultComercialCiudad = document.querySelector('input[name=ciudad]');
            const resultComercialPais = document.querySelector('input[name=pais]');

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

            ///////////////////////////
            // SUBIDA DEL FORMULARIO //
            ///////////////////////////
            const formulario = document.getElementById("form-agregar-cliente")
            formulario.addEventListener("submit", (event) => {
                document.getElementById("telefono_casa_codigo_pais").value = itiClienteTelCasa.getSelectedCountryData().dialCode;
                document.getElementById("telefono_casa_iso_pais").value = itiClienteTelCasa.getSelectedCountryData().iso2.toUpperCase();

                document.getElementById("telefono_celular_codigo_pais").value = itiClienteTelCasa.getSelectedCountryData().dialCode;
                document.getElementById("telefono_celular_iso_pais").value = itiClienteTelCasa.getSelectedCountryData().iso2.toUpperCase();
            });

        })();
    </script>
@stop
