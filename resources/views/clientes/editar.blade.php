@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Editar cliente')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Editar cliente</h1>
@stop

@section('content')
    <div class="row mb-2">
        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label class="col-form-label">
                    <i class="fas fa-info-circle"></i>&nbsp;
                    Fecha de creación
                </label>
                <input type="datetime-local" class="form-control form-control-sm" value="{{ $cliente->created_at }}" disabled>
            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label class="col-form-label">
                    <i class="fas fa-info-circle"></i>&nbsp;
                    Ultima actualización
                </label>
                <input type="datetime-local" class="form-control form-control-sm" value="{{ $cliente->updated_at }}" disabled>
            </div>
        </div>
    </div>

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
        </div>

        <div class="card-body">
            <form id="form-editar-cliente" @can('update', $cliente) action="{{ route('clientes.update', $cliente->id) }}" method="post" @endcan>
                @can('update', $cliente)
                    @csrf
                    @method('put')
                @endcan

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
                            <input name="nombre" required type="text" class="form-control" placeholder="Ingresar nombre" value="{{ $cliente->nombre }}">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Apellido</label>
                            <input name="apellido" required type="text" class="form-control" placeholder="Ingresar apellido" value="{{ $cliente->apellido }}">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <label>Teléfono | Celular</label>
                        <div class="input-group mb-3">
                            <input name="telefono_celular" id="telefono_celular" required type="text" class="form-control" placeholder="Ingresar teléfono celular" value="+{{ $cliente->telefono_celular_codigo_pais }}{{ $cliente->telefono_celular }}">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <label>Teléfono | Casa</label>
                        <div class="input-group mb-3">
                            <input name="telefono_casa" id="telefono_casa" type="text" class="form-control" placeholder="Ingresar teléfono de casa" value="+{{ $cliente->telefono_casa_codigo_pais }}{{ $cliente->telefono_casa }}">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <label>Correo electrónico</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input name="email_principal" required type="email" class="form-control" placeholder="Ingresar correo" value="{{ $cliente->email_principal }}">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <label>Correo electrónico secundario</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input name="email_secundario" type="email" class="form-control" placeholder="Ingresar correo secundario" value="{{ $cliente->email_secundario }}">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="id_status">Status del cliente</label>

                            <select id="id_status" class="form-control" name="id_status">
                                @foreach ($statusClientes as $status)
                                    <option value="{{ $status->id }}" @php echo ($cliente->id_status == $status->id) ? "selected" : "" @endphp style="color:{{$status->background_color}}" >
                                        {{ $status->descripcion }}
                                    </option>
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
                            <input type="text" name="linea1" value="{{ $direccion[0]->linea1 ?? '' }}" class="form-control" placeholder="Ingresar linea 1">
                            <small class="form-text text-muted">
                                Usada comúnmente para indicar la calle y número exterior e interior.
                            </small>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Linea 3</label>
                            <input type="text" name="linea3" value="{{ $direccion[0]->linea3 ?? '' }}" class="form-control" placeholder="Ingresar linea 3">
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
                            <input type="text" name="ciudad" value="{{ $direccion[0]->ciudad ?? '' }}" class="form-control" placeholder="Ingresar Ciudad">
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label>Estado</label>
                            <input type="text" name="estado" value="{{ $direccion[0]->estado ?? '' }}" class="form-control" placeholder="Ingresar Estado">
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label>País</label>
                            <input type="text" name="pais" value="{{ $direccion[0]->codigo_pais ?? '' }}" class="form-control" placeholder="Ingresar código de país">
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @can('update', $cliente)
        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button form="form-editar-cliente" class="btn btn-primary mx-3" type="submit">
                <i class="fas fa-pencil-alt"></i>
                Editar cliente
            </button>

            <a href="{{ route('clientes.index') }}"  class="btn btn-danger">
                <i class="fas fa-times-circle"></i>
                Cancelar
            </a>
        </div>
        @endcan
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
                separateDialCode: true
            });

            let itiClienteTelCel = intlTelInput(inputClienteTelCel, {
                initialCountry: "auto",
                separateDialCode: true
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
            geocoderComercial.container.querySelector("input").value = '{{ $direccion[0]->codigo_postal ?? '' }}';
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
            const formulario = document.getElementById("form-editar-cliente")
            formulario.addEventListener("submit", (event) => {
                document.getElementById("telefono_casa_codigo_pais").value = itiClienteTelCasa.getSelectedCountryData().dialCode;
                document.getElementById("telefono_casa_iso_pais").value = itiClienteTelCasa.getSelectedCountryData().iso2.toUpperCase();

                document.getElementById("telefono_celular_codigo_pais").value = itiClienteTelCasa.getSelectedCountryData().dialCode;
                document.getElementById("telefono_celular_iso_pais").value = itiClienteTelCasa.getSelectedCountryData().iso2.toUpperCase();
            });
        })();
    </script>

@stop
