@php
    $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
@endphp

@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Sitios Turísticos')

@section('content')
    <div class="row pt-2">
        <div class="col-12 col-sm-6 col-md-3">

        </div>

        <div class="col-12 col-sm-6 col-md-3">

        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total de sitios</span>
                    <span id="cantidad-sitios" class="info-box-number">
                    {{$sitios->count()}}
                    </span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box text-center">
                <a type="button" href="{{route('sitios-turisticos.create')}}" class="btn btn-primary w-100 btn-lg d-flex justify-content-center align-items-center gap-10">
                    <i class="fa fa-plus" ></i>
                    Agregar sitio
                </a>
            </div>
        </div>

        <div class="card col-12">
            @if(session('message'))
                <div id="mensajepersonalizado" class="alert alert-default-success mt-2 alert-dismissible fade show" role="alert">{{session('message')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="card-header">
                <h3 class="card-title">Listado de sitios turísticos</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="dataTableSitiosTuristicos" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Icono</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Coordenadas</th>
                                <th>Dirección</th>
                                <th>Último&nbsp;cambio</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($sitios as $sitio)
                                <tr id="sitio-turistico-id-{{ $sitio->id }}">
                                    <td>{{$sitio->id}}</td>
                                    <td class="text-center">
                                    @if ($sitio->id_icono_tipo == 2)
                                    <img src="{{ $sitio->icono }}" alt="Icono {{ $sitio->nombre }}" title="Icono {{ $sitio->nombre }}" style="width: 40px">
                                    @endif
                                    </td>
                                    <td>{{$sitio->nombre}}</td>
                                    <td title="{{ $sitio->descripcion }}">{{ strlen($sitio->descripcion) < 50 ? $sitio->descripcion : mb_substr($sitio->descripcion, 0, 50) . '...'}}</td>
                                    <td>
                                        {{$sitio->latitud}}, {{$sitio->longitud}}
                                        <br>
                                        <a target="_blank" href="https://www.google.com/maps?q={{ urlencode($sitio->nombre) }},{{$sitio->linea1 . ($sitio->linea1 !== '' ? ',' : '')}}{{$sitio->linea3 . ($sitio->linea3 !== '' ? ',' : '')}}{{$sitio->codigo_postal . ($sitio->codigo_postal !== '' ? ',' : '')}}{{$sitio->ciudad . ($sitio->ciudad !== '' ? ',' : '')}}{{$sitio->estado}}">Abrir mapa <i class="fas fa-external-link-alt"></i></a>
                                    </td>
                                    <td>
                                        {{($sitio->codigo_postal !== '' ? 'C.P. ' : '') . $sitio->codigo_postal . ($sitio->codigo_postal !== '' ? ', ' : '')}}{{$sitio->ciudad . ($sitio->ciudad !== '' ? ', ' : '')}}{{$sitio->estado . ($sitio->estado !== '' ? ', ' : '')}}{{$sitio->codigo_pais}} 
                                        <br>
                                        <small>{{$sitio->linea1 . ($sitio->linea1 !== '' ? ', ' : '')}}{{$sitio->linea3}}</small>
                                    </td>
                                    
                                    @php
                                        [$timestampFechaModificacion, $timestampHoraModificacion] = explode(' ', $sitio->updated_at);
                                        [$anioModificacion, $mesModificacion, $diaModificacion] = explode('-', $timestampFechaModificacion);
                                    @endphp
                                    <td>
                                        {{ $diaModificacion . " de " . $meses[date("n", mktime(0, 0, 0, $mesModificacion, $diaModificacion, $anioModificacion)) - 1] . " del " . $anioModificacion }}
                                        <br>
                                        <small>Hora: {{ $timestampHoraModificacion }}</small>
                                    </td>
                                    
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center gap-10">
                                            <a type="button" class="btn btn-primary" href="{{route('sitios-turisticos.edit', $sitio->id)}}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger" data-sitio-turistico-id="{{$sitio->id}}" onclick="modalEliminarCliente(event)">
                                                <i class="fas fa-trash me-3"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Icono</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Coordenadas</th>
                                    <th>Dirección</th>
                                    <th>Último&nbsp;cambio</th>
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

@section('css')
    <link rel="stylesheet" href={{ asset("/assets/css/admin_custom.css") }}>
@stop

@section('plugins.Sweetalert2', true)
@section('plugins.Datatables_Buttons', true)

@section('js')
    <script src="{{asset('/assets/js/funciones.js')}}"></script>
    <script>
        $(document).ready(function(){
            if($("#mensajepersonalizado").length > 0){
                setTimeout(function () {
                    esconderAlerta("mensajepersonalizado");
                }, 3000);
            }
        });

        function modalEliminarCliente(event) {
            const btnTarget = event.currentTarget;
            const idSitio = btnTarget.getAttribute("data-sitio-turistico-id");
            const fila = document.getElementById("sitio-turistico-id-" + idSitio);
            const cantidadSitios = document.getElementById("cantidad-sitios");

            Swal.fire({
                title: 'Eliminar sitio turístico?',
                input: 'text',
                text: "Esta seguro de continuar? Escriba la palabra ELIMINAR en la entrada de texto y luego pulse el botón para eliminar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar sitio',
                cancelButtonText: 'Cancelar',
                showLoaderOnConfirm: true,
                preConfirm: (confirmText) => {
                    if (confirmText !== "ELIMINAR") {
                        Swal.showValidationMessage(
                            `El texto no es correcto`
                        )
                    }
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Sitio turístico eliminado!',
                        icon: 'success'
                    });

                    const formulario = new FormData();
                    formulario.append("_method", "DELETE");
                    formulario.append("_token", "{{csrf_token()}}");

                    fetch("{{ route('sitios-turisticos.index') }}" + "/" + idSitio, {
                            method: "POST",
                            body: formulario
                        })
                        .then(data => {
                            // Actualizamos el numero de tipo de tours
                            cantidadSitios.textContent = Number(cantidadSitios.textContent) - 1;
                            fila.remove();
                        });
                }
            });
        };

        (function() {
            document.addEventListener("DOMContentLoaded", function() {
                if ($.fn.dataTable.isDataTable('#dataTableSitiosTuristicos')) {
                    let table = $('#dataTableSitiosTuristicos').DataTable();
                    table.destroy();
                }

                const meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
                const dias_semana = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
                
                const tiempoTranscurrido = Date.now();
                const hoy = new Date(tiempoTranscurrido);
                const fecha = dias_semana[hoy.getDay()] + ', ' + hoy.getDate() + ' de ' + meses[hoy.getMonth()] + ' de ' + hoy.getUTCFullYear()
                let table = $('#dataTableSitiosTuristicos').DataTable({
                    "order": [
                        [0, 'desc']
                    ],
                    "buttons": [
                        "excel",
                        {
                            extend: 'pdfHtml5',
                            orientation: 'landscape',
                            pageSize: 'LETTER',
                            footer: true,
                            customize: function(doc) {
                                doc['footer'] = (function(page, pages) {
                                    return {
                                        columns: [{
                                                // This is the right column
                                                alignment: 'left',
                                                fontSize: 8,
                                                text: 'Elaborado con CloudTravel',
                                                margin: [0, 10]
                                            },
                                            {
                                                // This is the right column
                                                alignment: 'right',
                                                text: ['Página ', {
                                                    text: page.toString()
                                                }, ' de ', {
                                                    text: pages.toString()
                                                }],
                                            }
                                        ],
                                        margin: [15, 10]
                                    }
                                });

                                doc['header'] = (function(page, pages) {
                                    return {
                                        columns: [{
                                                // 'This is your left footer column',
                                                alignment: 'left',
                                                text: '{{ $miEmpresa->nombre_comercial }}',
                                                margin: [0, 10]
                                            },
                                            {
                                                // This is the right column
                                                alignment: 'right',
                                                text: fecha,
                                                margin: [0, 10]
                                            }
                                        ],
                                        margin: [15, 0]
                                    }
                                });
                            }
                        },
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
                }).buttons().container().appendTo('#dataTableSitiosTuristicos_wrapper .col-md-6:eq(0)');
            })
        })();
    </script>
@stop

