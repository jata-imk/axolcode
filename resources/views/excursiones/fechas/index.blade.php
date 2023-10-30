@php
    $dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
    $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
@endphp

@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Programación de Fechas')

@section('content')
    <div class="row pt-2">
        <div class="col-12 col-sm-6 col-md-3">

        </div>

        <div class="col-12 col-sm-6 col-md-3">

        </div>

        <div class="col-12 col-sm-6 col-md-3">

        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box text-center">
                <a type="button" href="{{ route('excursiones-fechas.create') }}" class="btn btn-primary w-100 btn-lg d-flex justify-content-center align-items-center gap-10">
                    <i class="fa fa-plus"></i>
                    Agregar fecha
                </a>
            </div>
        </div>

        <div class="card col-12">
            @if (session('message'))
                <div id="mensajepersonalizado" class="alert alert-default-success mt-2 alert-dismissible fade show" role="alert">{{ session('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card-body">
                <h5>Buscador de excursiones</h5>
                <div class="buscador-excursion-contenedor">
                    <input class="buscador-excursion-input" type="text" name="entrada-producto-buscador" id="entrada-producto-buscador">

                    <div id="buscador-excursion-resultados" class="buscador-excursion-resultados" tabindex="1">
                        @php
                            $excursionResp = $excursion;
                        @endphp
                        @foreach ($excursiones as $excursion)
                            <div class="buscador-excursion-resultado__item" data-id-excursion="{{ $excursion->id }}" data-nombre-excursion="{{ $excursion->nombre }}">
                                <div class="buscador-excursion-resultado__box-img">
                                    <img src="{{ $excursion->path == '' ? asset('assets/img/placeholder-image.webp') : "storage/$excursion->path" }}" alt="Imagen {{ $excursion->nombre }}" onerror="try{handleImgLoad(event)}catch(e){}">
                                </div>

                                <div class="buscador-excursion-resultado__detalles">
                                    <p class="buscador-excursion-resultado__detalles-titulo">{{ $excursion->nombre }}</p>
                                </div>
                            </div>
                        @endforeach
                        @php
                            $excursion = $excursionResp;
                        @endphp
                    </div>
                </div>

                <div class="card-header mt-4 p-2">
                    <h3 class="card-title w-100 mb-2" style="float: none;">Listado de fechas</h3>
                    <h6 id="title-excursion-actual" data-id-excursion="{{ $excursion !== null ? $excursion[0]->id : '' }}" class="w-100 text-muted font-italic m-0">{{ $excursion !== null ? $excursion[0]->nombre : 'Ninguna excursión seleccionada' }}</h6>
                </div>

                <div class="wrapper-filtros">
                    <div class="wrapper-filtros__item">
                        <label class="wrapper-filtros__encabezado-label form-check-label" for="filtro-fechas">Filtro de fechas:</label>
                        <div class="input-group">
                            <button type="button" class="btn btn-default float-right w-100" id="filtro-fechas" style="min-width: 175px;">
                                <i class="far fa-calendar-alt"></i> <span id="filtro-fechas-span">A partir de hoy</span> <i class="fas fa-caret-down"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex flex-column wrapper-filtros__item">
                        <label class="wrapper-filtros__encabezado-label form-check-label" for="filtro__temporada">Filtro de temporada:</label>

                        <!-- Build your select: -->
                        <select id="filtro__temporada" multiple="multiple">
                            @for ($i = 0, $l = count($temporadasInfo['id'] ?? []); $i < $l; $i++)
                                <option value="{{ $temporadasInfo['id'][$i] }}" selected>{{ $temporadasInfo['nombre'][$i] }}</option>
                            @endfor
                        </select>
                    </div>

                    <button id="btn-aplicar-filtros" type="button" class="btn btn-warning w-100">
                        <i class="fas fa-filter"></i> Aplicar filtros
                    </button>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <table id="dataTableFechas" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Fecha&nbsp;inicio</th>
                                    <th>Fecha&nbsp;fin</th>
                                    <th>Temporada</th>
                                    <th>Clases</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($fechas ?? [] as $fecha)
                                    <tr id="fecha-id-{{ $fecha->id }}">
                                        @php
                                            $fechaInicio = $fecha->fecha_inicio;
                                            [$anioInicio, $mesInicio, $diaInicio] = explode('-', $fechaInicio);
                                            
                                            $fechaFin = $fecha->fecha_fin;
                                            [$anioFin, $mesFin, $diaFin] = explode('-', $fechaFin);
                                        @endphp
                                        <td>
                                            <span style="display:none;">{{ strtotime($fecha->fecha_inicio) }}</span>
                                            {{ date('d', mktime(0, 0, 0, $mesInicio, $diaInicio, $anioInicio)) . ' de ' . $meses[date('n', mktime(0, 0, 0, $mesInicio, $diaInicio, $anioInicio)) - 1] . ' del ' . $anioInicio }}
                                        </td>
                                        <td>
                                            <span style="display:none;">{{ strtotime($fecha->fecha_fin) }}</span>
                                            {{ date('d', mktime(0, 0, 0, $mesFin, $diaFin, $anioFin)) . ' de ' . $meses[date('n', mktime(0, 0, 0, $mesFin, $diaFin, $anioFin)) - 1] . ' del ' . $anioFin }}
                                        </td>
                                        <td>
                                            <span class="badge" style="color:{{ $fecha->temporada->color }}; background-color: {{ $fecha->temporada->background_color }};">Temporada {{ $fecha->temporada->nombre }}</span>
                                        </td>

                                        <td>
                                            <ul class="datatableFechas__clases">
                                                @foreach ($fecha->clases ?? [] as $clase)
                                                    <li class="li-custom datatableFechas__clase">
                                                        <div class="datatableFechas__clase-title">
                                                            {{ $clase->nombre }} <span class="badge {{ $clase->publicar_fecha == 1 ? 'badge-success' : 'badge-danger' }}">{{ $clase->publicar_fecha == 1 ? 'Publicada' : 'No publicada' }}</span>
                                                        </div>
                                                        <div class="datatableFechas__clase">
                                                            Cupo disponible: {{ $clase->cupo }}
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-center gap-10">
                                                <a type="button" class="btn btn-primary" href="./admin/excursiones/{{ $excursion !== null ? $excursion[0]->id : '' }}/fechas/{{ $fecha->fecha_inicio }},{{ $fecha->fecha_fin }}/edit">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                            <tfoot>
                                <tr>
                                    <th>Fecha&nbsp;inicio</th>
                                    <th>Fecha&nbsp;fin</th>
                                    <th>Temporada</th>
                                    <th>Clases</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('plugins.MomentJS', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Datatables_Buttons', true)
@section('plugins.DateRangePicker', true)

@section('css')
    <!-- Bootstrap multiselect -->
    <link rel="stylesheet" href="{{ asset('/assets/plugins/multiselect/bootstrap-multiselect.css') }}" type="text/css" />
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
@stop

@section('js')
    <!-- Bootstrap multiselect -->
    <script type="text/javascript" src="{{ asset('/assets/plugins/multiselect/bootstrap-multiselect.js') }}"></script>

    <script>
        $(document).ready(function() {
            if ($("#mensajepersonalizado").length > 0) {
                setTimeout(function() {
                    esconderAlerta("mensajepersonalizado");
                }, 3000);
            }

            moment.locale("es-mx");

            const inputBuscador = document.getElementById("entrada-producto-buscador");
            const contenedorResultados = document.getElementById("buscador-excursion-resultados");
            const itemsExcursiones = document.querySelectorAll(".buscador-excursion-resultado__item");

            const filtroTemporada = document.getElementById("filtro__temporada");
            const btnAplicarFiltros = document.getElementById("btn-aplicar-filtros");

            function fetchFechas(url, idExcursion) {
                fetch(url)
                    .then(res => res.json())
                    .then(data => {
                        const temporadas = data.body.temporadas;
                        let filtroTemporadaHTML = "";

                        for (let i = 0, l = (temporadas.hasOwnProperty("id") ? temporadas.id.length : 0); i < l; i++) {
                            filtroTemporadaHTML += `<option value="${temporadas.id[i]}" selected>${temporadas.nombre[i]}</option>`;
                        }

                        filtroTemporada.innerHTML = filtroTemporadaHTML;

                        // Se resetea el filtro de temporadas
                        $('#filtro__temporada').multiselect('destroy');
                        iniciarMultiselectTemporadas();

                        const fechas = data.body.fechas;

                        if ($.fn.dataTable.isDataTable('#dataTableFechas')) {
                            table = $('#dataTableFechas').DataTable();
                            table.destroy();
                        }

                        document.getElementById("dataTableFechas").querySelector("tbody").innerHTML = '';
                        const meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];

                        (fechas ?? []).forEach((fecha) => {
                            let fila = document.createElement("tr");
                            fila.id = `fecha-id-${fecha.id}`;

                            // let celdaUno = document.createElement("td");
                            // celdaUno.textContent = fecha.id;
                            // fila.appendChild(celdaUno);

                            let [anioInicio, mesInicio, diaInicio] = fecha.fecha_inicio.split("-");
                            let [anioFin, mesFin, diaFin] = fecha.fecha_fin.split("-");

                            let celdaDos = document.createElement("td");
                            let spanUnixFechaInicio = document.createElement("span");
                            spanUnixFechaInicio.style.display = "none";
                            spanUnixFechaInicio.textContent = Date.parse(fecha.fecha_inicio) / 1000;
                            celdaDos.appendChild(spanUnixFechaInicio);
                            celdaDos.appendChild(document.createTextNode(
                                new Date(anioInicio, mesInicio - 1, diaInicio).getDate() +
                                " de " +
                                meses[new Date(anioInicio, mesInicio - 1, diaInicio).getMonth()] +
                                " del " +
                                anioInicio
                            ));
                            fila.appendChild(celdaDos);

                            let celdaTres = document.createElement("td");
                            let spanUnixFechaFin = document.createElement("span");
                            spanUnixFechaFin.style.display = "none";
                            spanUnixFechaFin.textContent = Date.parse(fecha.fecha_fin) / 1000;
                            celdaTres.appendChild(spanUnixFechaFin);
                            celdaTres.appendChild(document.createTextNode(
                                new Date(anioFin, mesFin - 1, diaFin).getDate() +
                                " de " +
                                meses[new Date(anioFin, mesFin - 1, diaFin).getMonth()] +
                                " del " +
                                anioFin
                            ));
                            fila.appendChild(celdaTres);

                            let celdaCuatro = document.createElement("td");
                            let badgeTemporada = document.createElement("span");
                            badgeTemporada.classList.add("badge");
                            badgeTemporada.style.color = fecha.temporada.color;
                            badgeTemporada.style.backgroundColor = fecha.temporada.background_color;
                            badgeTemporada.textContent = `Temporada ${fecha.temporada.nombre}`;
                            celdaCuatro.appendChild(badgeTemporada);
                            fila.appendChild(celdaCuatro);

                            let celdaCinco = document.createElement("td");
                            let ulClases = document.createElement("ul");
                            ulClases.classList.add("datatableFechas__clases");
                            (fecha.clases ?? []).forEach((clase) => {
                                let liClase = document.createElement("li");
                                liClase.classList.add("li-custom", "datatableFechas__clase");
                                let divUno = document.createElement("div");
                                divUno.classList.add("datatableFechas__clase-title");
                                divUno.textContent = clase.nombre;
                                let badgePublicada = document.createElement("span");
                                badgePublicada.classList.add(
                                    "badge",
                                    clase.publicar_fecha == 1 ? "badge-success" : "badge-danger"
                                );
                                badgePublicada.textContent =
                                    clase.publicar_fecha == 1 ? "Publicada" : "No publicada";
                                divUno.appendChild(badgePublicada);
                                liClase.appendChild(divUno);
                                let divDos = document.createElement("div");
                                divDos.classList.add("datatableFechas__clase");
                                divDos.textContent = `Cupo disponible: ${clase.cupo}`;
                                liClase.appendChild(divDos);
                                ulClases.appendChild(liClase);
                            });
                            celdaCinco.appendChild(ulClases);
                            fila.appendChild(celdaCinco);

                            let celdaSeis = document.createElement("td");
                            let contenedorBotones = document.createElement("div");
                            contenedorBotones.classList.add("d-flex", "align-items-center", "justify-content-center", "gap-10");

                            let editLink = document.createElement('a');
                            editLink.type = 'button';
                            editLink.classList.add('btn', 'btn-primary');
                            editLink.href = './admin/excursiones/' + idExcursion + '/fechas/' + fecha.fecha_inicio + ',' + fecha.fecha_fin + '/edit';
                            
                            let editIcon = document.createElement('i');
                            editIcon.classList.add('fas', 'fa-pencil-alt');
                            editLink.appendChild(editIcon);
                            contenedorBotones.appendChild(editLink);

                            celdaSeis.appendChild(contenedorBotones);
                            fila.appendChild(celdaSeis);

                            // Append new row to table
                            document.getElementById("dataTableFechas").querySelector("tbody").appendChild(fila);
                        });

                        iniciarDataTable();
                    })
                    .catch(e => console.log(e));
            }

            for (let itemExcursion of itemsExcursiones) {
                itemExcursion.addEventListener("click", (event) => {
                    contenedorResultados.classList.remove("buscador-excursion-resultados--visible");
                    inputBuscador.classList.remove("buscador-excursion-input-focus");

                    const currentTarget = event.currentTarget;
                    const idExcursion = currentTarget.getAttribute("data-id-excursion");

                    const titleExcursionActual = document.getElementById("title-excursion-actual");
                    titleExcursionActual.textContent = currentTarget.getAttribute("data-nombre-excursion");
                    titleExcursionActual.setAttribute("data-id-excursion", idExcursion);

                    // Se resetea el filtro de fechas
                    document.querySelector('#filtro-fechas-span').textContent = "A partir de hoy";
                    $('#filtro-fechas').val('');

                    filtrosFechasExcursiones = {
                        fechas: "",
                        temporadas: ""
                    };

                    fetchFechas(`./admin/excursiones/${idExcursion}/fechas`, idExcursion);
                })
            }

            function buscadorEnfocado(event) {
                event.preventDefault();

                if (![...contenedorResultados.classList].includes("buscador-excursion-resultados--visible")) {
                    contenedorResultados.classList.add("buscador-excursion-resultados--visible")
                    inputBuscador.classList.add("buscador-excursion-input-focus")
                }
            }

            function buscadorDesenfocado(event) {
                event.preventDefault();

                let idInterval = setInterval(() => {
                    clearInterval(idInterval);

                    if (event.relatedTarget === null) {
                        contenedorResultados.classList.remove("buscador-excursion-resultados--visible");
                        inputBuscador.classList.remove("buscador-excursion-input-focus");
                    }
                }, 50);
            }

            function filtrarResultados(event) {
                event.preventDefault();

                const items = document.querySelectorAll(".buscador-excursion-resultado__item");
                let regex = null;

                if (event.target.value !== "") {
                    regex = new RegExp(`(${event.target.value}?.*)`, 'gi');
                }

                for (let item of items) {
                    const nombreExcursion = item.querySelector(".buscador-excursion-resultado__detalles-titulo").textContent;

                    if (regex === null) {
                        item.style.display = "flex";
                        continue;
                    }

                    if (nombreExcursion.match(regex)) {
                        item.style.display = "flex";
                    } else {
                        item.style.display = "none";
                    }
                }
            }

            inputBuscador.addEventListener("keyup", (event) => {
                filtrarResultados(event);
            });

            inputBuscador.addEventListener("focus", (event) => {
                buscadorEnfocado(event);
            });

            inputBuscador.addEventListener("blur", (event) => {
                buscadorDesenfocado(event);
            });

            contenedorResultados.addEventListener("focusin", (event) => {
                buscadorEnfocado(event);
            });

            contenedorResultados.addEventListener("focusout", (event) => {
                buscadorDesenfocado(event);
            });

            function iniciarDataTable() {
                if ($.fn.dataTable.isDataTable('#dataTableFechas')) {
                    let table = $('#dataTableFechas').DataTable();
                    table.destroy();
                }

                let table = $('#dataTableFechas').DataTable({
                    "order": [
                        [0, 'desc']
                    ],
                    "buttons": [
                        "excel",
                        "pdf",
                        {
                            extend: 'print',
                            text: "Imprimir"
                        },
                        {
                            extend: 'colvis',
                            text: "Columnas visibles "
                        }
                    ],
                    "stateSave": true,
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                    "language": {
                        "search": "Buscar:",
                        "lengthMenu": "Mostrar _MENU_ registros por pagina",
                        "zeroRecords": "No se encontraron registros",
                        "info": "Mostrando página _PAGE_ de _PAGES_",
                        "infoEmpty": "Sin registros disponibles",
                        "infoFiltered": "(Filtrados de _MAX_ total registros)",
                        "paginate": {
                            "first": "Inicio",
                            "last": "Final",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        },
                    }
                }).buttons().container().appendTo('#dataTableFechas_wrapper .col-md-6:eq(0)');
            };

            iniciarDataTable();

            //Date range as a button
            let filtrosFechasExcursiones = {
                fechas: "",
                temporadas: ""
            };

            function filtrarPorPeriodo(inicio, fin, label) {
                document.querySelector('#filtro-fechas-span').textContent = label;

                if ((inicio === "") && (fin === "")) {
                    filtrosFechasExcursiones.fechas = "";
                } else {
                    filtrosFechasExcursiones.fechas = `${inicio},${fin}`;
                }
            };

            $('#filtro-fechas').daterangepicker({
                    ranges: {
                        'A partir de hoy': [moment(), null],
                    },
                    locale: {
                        "format": "MM/DD/YYYY",
                        "separator": " - ",
                        "applyLabel": "Aplicar",
                        "cancelLabel": "Cancelar",
                        "fromLabel": "Desde",
                        "toLabel": "Hasta",
                        "customRangeLabel": "Personalizado",
                        "weekLabel": "W",
                        "daysOfWeek": [
                            "Do",
                            "Lu",
                            "Ma",
                            "Mi",
                            "Ju",
                            "Vi",
                            "Sa"
                        ],
                        "monthNames": [
                            "Enero",
                            "Febrero",
                            "Marzo",
                            "Abril",
                            "Mayo",
                            "Junio",
                            "Julio",
                            "Agosto",
                            "Septiembre",
                            "Octubre",
                            "Noviembre",
                            "Diciembre"
                        ],
                        "firstDay": 1
                    },
                    autoUpdateInput: false,
                    minDate: moment()
                },
                function(start, end, txtTriggerBtn) {
                    if (end.format("YYYY-MM-DD") === "Fecha inválida") {
                        filtrarPorPeriodo("", "", txtTriggerBtn);
                    } else {
                        filtrarPorPeriodo(start.format("YYYY-MM-DD"), end.format("YYYY-MM-DD"), txtTriggerBtn);
                    }
                }
            );

            function filtrarPorTemporadas(option, checked, select) {
                let listaTemporadas = [];
                for (let option of filtroTemporada) {
                    if (option.selected) {
                        listaTemporadas.push(option.value);
                    }
                }

                filtrosFechasExcursiones.temporadas = listaTemporadas.join(",");
            }

            function iniciarMultiselectTemporadas() {
                $('#filtro__temporada').multiselect({
                    allSelectedText: 'Todas las temporadas ...',
                    nonSelectedText: 'Ninguna selección',
                    disableIfEmpty: true,
                    buttonWidth: '100%',
                    onChange: filtrarPorTemporadas,
                    onSelectAll: filtrarPorTemporadas,
                    onDeselectAll: filtrarPorTemporadas,
                });
            }

            iniciarMultiselectTemporadas();

            btnAplicarFiltros.addEventListener("click", (event) => {
                const idExcursion = document.getElementById("title-excursion-actual").getAttribute("data-id-excursion");
                fetchFechas(`./admin/excursiones/${idExcursion}/fechas?between=${filtrosFechasExcursiones.fechas}&temporadas=${filtrosFechasExcursiones.temporadas}`, idExcursion);
            });
        });
    </script>
@stop
