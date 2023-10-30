{{-- TODO: Poder agregar varias fechas en CloudTravel | Agregar fecha --}}
@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Agregar fecha')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Agregar fecha</h1>
@stop

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
        </div>

        <div class="card-body">
            <form id="form-agregar-fecha" action="{{ route('excursiones-fechas.store') }}" method="post">
                @csrf

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="id_excursion">Seleccionar excursión</label>
                            <select id="id_excursion" class="form-control" name="id_excursion" required>
                                <option value="" selected disabled hidden> Seleccione una opción </option>
                                @foreach ($excursiones as $excursion)
                                    <option value="{{ $excursion->id }}">
                                        {{ $excursion->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div id="form-fechas__contenido" class="form-fechas__contenido">
                </div>
            </form>
        </div>

        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button form="form-agregar-fecha" class="btn btn-primary mx-3" type="submit">
                <i class="fas fa-pencil-alt"></i>
                &nbsp;Agregar fecha
            </button>

            <a href="{{ route('excursiones-fechas.index') }}" class="btn btn-danger">
                <i class="fas fa-times-circle"></i>
                &nbsp;Cancelar
            </a>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
@stop

@section('js')
    <script>
        $(function() {
            basicValidation();

            const selectExcursion = document.getElementById("id_excursion");
            const contenido = document.getElementById("form-fechas__contenido");

            let excursion = null;

            function handleChangeCheckboxTemporada(event) {
                const checked = event.currentTarget.checked;
                const temporadaId = event.currentTarget.getAttribute("data-temporada-id");
                const contenedorFechas = contenido.querySelector(`.form-fechas__fechas[data-temporada-id='${temporadaId}']`);
                const requiredInputs = contenedorFechas.querySelectorAll("input[type='date'],input[type='number']");

                for (let requiredInput of requiredInputs) {
                    requiredInput.required = checked;
                }

                if (checked === true) {
                    contenedorFechas.classList.add("mostrar");
                } else {
                    contenedorFechas.classList.remove("mostrar");
                }
            }

            function generarStringFecha(temporada, btnEliminar = false) {
                let txtBtnEliminar = "";
                
                if (btnEliminar === true) {
                    txtBtnEliminar = `
                    <button type="button" class="btn btn-outline-danger btn-sm align-self-end btn-eliminar-fecha">
                        <i title="Eliminar" class="fas fa-times-circle "></i>
                    </button>
                    `;
                }

                const randomString = generateRandomString(15);

                let fechaNuevaHTML = "";

                fechaNuevaHTML += `
                <div class="form-fechas__fecha">
                    <input type="hidden" name="temporada-${temporada.id}-id[]" value=${randomString} />
                    ${txtBtnEliminar}
                    <div class="form-fechas__fecha--left">
                        <div class="form-group">
                            <label for="temporada-${temporada.id}-${randomString}-fecha-inicio">Fecha de inicio</label>
                            <input type="date" id="temporada-${temporada.id}-${randomString}-fecha-inicio" name="temporada-${temporada.id}-${randomString}-fecha-inicio" class="form-control" min="{{ date('Y-m-d') }}" required />
                        </div>
                        <div class="form-group">
                            <label for="temporada-${temporada.id}-${randomString}-fecha-fin">Fecha final</label>
                            <input type="date" id="temporada-${temporada.id}-${randomString}-fecha-fin" name="temporada-${temporada.id}-${randomString}-fecha-fin" class="form-control" min="{{ date('Y-m-d') }}" required />
                        </div>
                        <div class="form-group">
                            <label for="temporada-${temporada.id}-${randomString}-cupo">Cupo máximo</label>
                            <input type="number" id="temporada-${temporada.id}-${randomString}-cupo" name="temporada-${temporada.id}-${randomString}-cupo" class="form-control" min="0" max="1000" value="100" required />
                        </div>
                    </div>

                    <div class="form-fechas__fecha-clases">
                        <div class="form-group form-check">
                            <label class="form-check-label" for="temporada-${temporada.id}-${randomString}-publicar-fecha">Publicar fecha</label>
                            <input type="checkbox" checked class="form-check-input" id="temporada-${temporada.id}-${randomString}-publicar-fecha" name="temporada-${temporada.id}-${randomString}-publicar-fecha" value="1">
                        </div>
                `;

                for (let clase of temporada.clases) {
                fechaNuevaHTML += `
                        <div class="form-group form-check">
                            <label class="form-check-label" for="temporada-${temporada.id}-${randomString}-clase-${clase.id}">${clase.nombre}</label>
                            <input type="checkbox" checked class="form-check-input" id="temporada-${temporada.id}-${randomString}-clase-${clase.id}" name="temporada-${temporada.id}-${randomString}-clases[]" value="${clase.id}">
                        </div>
                `;
                }

                fechaNuevaHTML += `
                    </div>
                </div>
                `;

                return fechaNuevaHTML;
            }

            function eliminarFecha(event) {
                const contenedorFecha = event.currentTarget.parentElement;
                contenedorFecha.parentElement.removeChild(contenedorFecha);
            }

            function agregarFecha(contenedor, temporadaId) {
                const temporada = excursion.temporadas.filter(temporada => temporada.id == temporadaId)[0];
                let fechaNuevaHTML = "";

                fechaNuevaHTML += generarStringFecha(temporada, btnEliminar = true);
                

                contenedor.insertAdjacentHTML("beforeend", fechaNuevaHTML);
                contenedor.lastElementChild.querySelector("button.btn-eliminar-fecha").addEventListener("click", eliminarFecha);
            }

            selectExcursion.addEventListener("change", (event) => {
                contenido.innerHTML = `<div class="lds-ripple"><div></div><div></div></div>`;
                const idExcursion = selectExcursion.value;

                fetch(`admin/excursiones/${idExcursion}?columns=temporadas&newApi=true`)
                    .then(res => res.json())
                    .then(data => {
                        excursion = data;
                        let contenidoHTML = "";

                        for (let temporada of data.temporadas) {
                            contenidoHTML += `
                            <div class="form-fechas__temporada">
                                <div class="form-group m-0 mb-2">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input type="checkbox" class="custom-control-input checkbox-temporada" data-temporada-id="${temporada.id}" id="checkbox-temporada-${temporada.id}" checked name="temporadas[]" value="${temporada.id}">
                                        <label class="custom-control-label" for="checkbox-temporada-${temporada.id}">Temporada ${temporada.nombre}</label>
                                    </div>
                                </div>

                                <div class="form-fechas__fechas ocultar mostrar" data-temporada-id="${temporada.id}">
                                    <button type="button" class="btn btn-outline-secondary btn-sm mb-2 btn-agregar-fecha" data-temporada-id="${temporada.id}">
                                        <i class="fas fa-calendar-day mr-2"></i>
                                        Agregar fecha
                                    </button>
                                    
                                    ${generarStringFecha(temporada, btnEliminar = false)}
                                </div>
                            </div>
                            `;
                        }

                        contenido.innerHTML = contenidoHTML;

                        const checkboxesTemporadas = contenido.querySelectorAll("input[name='temporadas[]']");
                        for (let checkbox of checkboxesTemporadas) {
                            checkbox.addEventListener("change", (event) => {
                                handleChangeCheckboxTemporada(event);
                            })
                        }

                        const botonesAgregarFecha = contenido.querySelectorAll("button.btn-agregar-fecha");
                        for (let btn of botonesAgregarFecha) {
                            btn.addEventListener("click", (event) => {
                                const contenedor = event.currentTarget.parentElement;
                                const temporadaId = event.currentTarget.getAttribute("data-temporada-id");

                                agregarFecha(contenedor, temporadaId);
                            })
                        }
                    });
            });
        });
    </script>
@stop
