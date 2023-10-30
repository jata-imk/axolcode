@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Editar afiliado')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Editar afiliado</h1>
@stop

@section('content')
<div class="row mb-2">
    <div class="col-md-6 col-sm-6">
        <div class="form-group">
            <label class="col-form-label">
                <i class="fas fa-info-circle"></i>&nbsp;
                Fecha de creación
            </label>
            <input type="datetime-local" class="form-control form-control-sm" value="{{ $afiliado->created_at }}" disabled>
        </div>
    </div>

    <div class="col-md-6 col-sm-6">
        <div class="form-group">
            <label class="col-form-label">
                <i class="fas fa-info-circle"></i>&nbsp;
                Ultima actualización
            </label>
            <input type="datetime-local" class="form-control form-control-sm" value="{{ $afiliado->updated_at }}" disabled>
        </div>
    </div>
</div>

<div class="card col-12">
    <form action="{{route('afiliados.update', $afiliado->id)}}" method="post" id="form-agregar-afiliado">
        @csrf
        @method('put')
        <input type="hidden" name="telefono_oficina_codigo_pais" id="telefono_oficina_codigo_pais" value="" />
        <input type="hidden" name="telefono_oficina_iso_pais" id="telefono_oficina_iso_pais" value="" />

        <input type="hidden" name="telefono_celular_codigo_pais" id="telefono_celular_codigo_pais" value="" />
        <input type="hidden" name="telefono_celular_iso_pais" id="telefono_celular_iso_pais" value="" />
    <div class="card-header">
        <h3 class="card-title">Datos de Afiliados</h3>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="form-group">
                    <label>Nombre comercial</label>
                    <input type="text" name="nombre_comercial" value="{{$afiliado->nombre_comercial}}" required class="form-control" placeholder="Ingresar Nombre comercial">
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="form-group">
                    <label>Dirección comercial</label>
                    <input type="text" required name="direccion_comercial" value="{{$afiliado->direccion_comercial}}" required class="form-control" placeholder="Ingresar Dirección comercial">
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="form-group">
                    <div id="geocoder-comercial">
                        <label>Código Postal:</label>
                    </div>
                    <pre id="result-comercial" class="m-0 p-0"></pre>
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="form-group">
                    <label>País</label>
                    <input type="text" name="pais_comercial" value="{{$afiliado->pais_comercial}}" class="form-control" placeholder="Ingresar Código postal">
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="form-group">
                    <label>Estado</label>
                    <input type="text" name="estado_comercial" value="{{$afiliado->estado_comercial}}" class="form-control" placeholder="Ingresar Código postal">
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="form-group">
                    <label>Ciudad</label>
                    <input type="text" name="ciudad_comercial" value="{{$afiliado->ciudad_comercial}}" class="form-control" placeholder="Ingresar Código postal">
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="form-group">
                    <label>Nombre Fiscal</label>
                    <input type="text" required name="razon_social" value="{{$afiliado->razon_social}}" class="form-control" placeholder="Ingresar Nombre Fiscal">
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="form-group">
                    <label>Dirección Fiscal</label>
                    <input type="text" name="direccion_fiscal" value="{{$afiliado->direccion_fiscal}}" class="form-control" placeholder="Ingresar Dirección Fiscal">
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="form-group">
                    <div id="geocoder-fiscal">
                        <label>Código postal fiscal:</label>
                    </div>
                    <pre id="result-fiscal" class="m-0 p-0"></pre>
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="form-group">
                    <label>País</label>
                    <input type="text" name="pais_fiscal" value="{{$afiliado->pais_fiscal}}" class="form-control" placeholder="Ingresar Código postal">
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="form-group">
                    <label>Estado</label>
                    <input type="text" name="estado_fiscal" value="{{$afiliado->estado_fiscal}}" class="form-control" placeholder="Ingresar Código postal">
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="form-group">
                    <label>Ciudad</label>
                    <input type="text" name="ciudad_fiscal" value="{{$afiliado->ciudad_fiscal}}" class="form-control" placeholder="Ingresar Código postal">
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="form-group">
                    <label>RFC</label>
                    <input type="text" required name="rfc" value="{{$afiliado->rfc}}" class="form-control" placeholder="Ingrese el RFC del afiliado">
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="form-group">
                    <label>Sitio web</label>
                    <input type="text" required name="url" value="{{$afiliado->url}}" class="form-control" placeholder="Ej: https://sitioweb.com">
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="form-group">
                    <label>Link afiliado</label>
                    <input type="text" name="link_afiliado" value="{{$web[0]->pagina_web}}?affiliate={{$afiliado->link_afiliado}}" class="form-control" readonly>
                </div>
            </div>
            <div class="col-md-3 col-sm-12">
                <div class="form-group">
                    <label>Nivel de afiliación</label>
                    <select name="id_nivel" required class="form-control select2">
                        <option>-- Selecciona una opción|</option>
                        @foreach ($niveles as $nivel)
                            <option value="{{$nivel->id}}" @if ($nivel->id == $afiliado->id_nivel) selected @endif>{{$nivel->nombre}} ({{$nivel->comision}}%)</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="card-header">
        <h3 class="card-title">Contacto del afiliado</h3>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="form-group">
                    <label>Nombre contacto</label>
                    <input type="text" name="nombre_contacto" value="{{$afiliado->nombre_contacto}}" class="form-control" placeholder="Ingresar Nombre contacto">
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="form-group">
                    <label>Apellido contacto</label>
                    <input type="text" name="apellido_contacto" value="{{$afiliado->apellido_contacto}}" class="form-control" placeholder="Ingresar Apellido contacto">
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <label>Teléfono oficina</label>
                <div class="input-group mb-3">
                    <div class="input-group mb-3">
                        <input name="telefono_oficina" value="+{{$afiliado->telefono_oficina_codigo_pais}}{{$afiliado->telefono_oficina}}" id="telefono_oficina" required type="text" class="form-control" placeholder="Ingresar teléfono celular">
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <label>Teléfono celular</label>
                <div class="input-group mb-3">
                    <div class="input-group mb-3">
                        <input name="telefono_celular" value="+{{$afiliado->telefono_celular_codigo_pais}}{{$afiliado->telefono_celular}}" id="telefono_celular" required type="text" class="form-control" placeholder="Ingresar teléfono celular">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-header"></div>

    <div class="d-grid gap-2 d-md-flex justify-content-md-end p-3">
        <button class="btn btn-primary btn-lg mx-3" type="submit">
            <i class="fas fa-pencil-alt"></i>
            Editar afiliado
        </button>
        <a href="{{route('afiliados.index')}}"><button class="btn btn-danger btn-lg" type="button"><i class="fas fa-times-circle"></i> Cancelar</button></a>
    </div>
</form>
</div>
@stop

@section('css')
    <link rel="stylesheet" href={{ asset("/assets/css/admin_custom.css") }}>
@stop
@section('plugins.IntTelInput', true)
@section('plugins.MapboxGL', true)
@section('plugins.MapboxGL_Geocoder', true)

@section('js')
<script>
    (function() {
        const inputClienteTelCasa = document.querySelector("#telefono_oficina");
        const inputClienteTelCel = document.querySelector("#telefono_celular");

        ///////////////////////////////////
        // International Telephone Input //
        ///////////////////////////////////
        let itiClienteTelCasa = intlTelInput(inputClienteTelCasa, {
            initialCountry: "MX",
            separateDialCode: true
        });

        let itiClienteTelCel = intlTelInput(inputClienteTelCel, {
            initialCountry: "MX",
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

            const geocoderFiscal = new MapboxGeocoder({
                accessToken: mapboxgl.accessToken,
                types: 'postcode',
                placeholder: ' ',
                minLength: 4
            });

            geocoderComercial.addTo('#geocoder-comercial');
            geocoderComercial.container.querySelector("input").name = 'codigo_postal_comercial';
            geocoderComercial.container.querySelector("input").value = '{{ $afiliado->codigo_postal_comercial ?? '' }}';
            geocoderComercial.container.querySelector("input").parentElement.className = "mapboxgl-ctrl-geocoder mapboxgl-ctrl w-100 min-width-unset max-width-none shadow-none form-control p-0";
            geocoderComercial.container.querySelector("input").autocomplete = 'nope';
            geocoderComercial.container.querySelector("input").required = true;

            // Get the geocoder results container.
            const resultComercialEstado = document.querySelector('input[name=estado_comercial]');
            const resultComercialCiudad = document.querySelector('input[name=ciudad_comercial]');
            const resultComercialPais = document.querySelector('input[name=pais_comercial]');

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

            /*FISCAL*/
            geocoderFiscal.addTo('#geocoder-fiscal');
            geocoderFiscal.container.querySelector("input").name = 'codigo_postal_fiscal';
            geocoderFiscal.container.querySelector("input").value = '{{ $afiliado->codigo_postal_fiscal ?? '' }}';
            geocoderFiscal.container.querySelector("input").parentElement.className = "mapboxgl-ctrl-geocoder mapboxgl-ctrl w-100 min-width-unset max-width-none shadow-none form-control p-0";
            geocoderFiscal.container.querySelector("input").autocomplete = 'nope';
            geocoderFiscal.container.querySelector("input").required = true;

            // Get the geocoder results container.
            const resultFiscalEstado = document.querySelector('input[name=estado_fiscal]');
            const resultFiscalCiudad = document.querySelector('input[name=ciudad_fiscal]');
            const resultFiscalPais = document.querySelector('input[name=pais_fiscal]');

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

            ///////////////////////////
            // SUBIDA DEL FORMULARIO //
            ///////////////////////////
            const formulario = document.getElementById("form-agregar-afiliado")
            formulario.addEventListener("submit", (event) => {
                document.getElementById("telefono_oficina_codigo_pais").value = itiClienteTelCasa.getSelectedCountryData().dialCode;
                document.getElementById("telefono_oficina_iso_pais").value = itiClienteTelCasa.getSelectedCountryData().iso2.toUpperCase();

                document.getElementById("telefono_celular_codigo_pais").value = itiClienteTelCel.getSelectedCountryData().dialCode;
                document.getElementById("telefono_celular_iso_pais").value = itiClienteTelCel.getSelectedCountryData().iso2.toUpperCase();
            });

    })();
</script>
@stop
