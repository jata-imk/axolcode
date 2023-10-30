@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Excursiones')

@section('content')
    <div class="row pt-2">
        @cannot('create', App\Models\Excursiones\Excursion::class)
        <div class="col-12 col-sm-6 col-md-3">

        </div>
        @endcannot

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total de excursiones</span>
                    <span id="cantidad-excursiones" class="info-box-number">
                        {{ $excursiones->count() }}
                    </span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-success elevation-1"><i class="fa fa-check-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Excursiones publicadas</span>
                    <span class="info-box-number">{{ $excursiones->where('publicar_excursion', '=', '1')->count() }}</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-times-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Excursiones sin publicar</span>
                    <span id="cantidad-excursiones-sin-publicar" class="info-box-number">{{ $excursiones->where('publicar_excursion', '=', '0')->count() }}</span>
                </div>
            </div>
        </div>

        @can('create', App\Models\Excursiones\Excursion::class)
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box text-center">
                <a type="button" href="{{ route('excursiones.create') }}" class="btn btn-primary w-100 btn-lg d-flex justify-content-center align-items-center gap-10">
                    <i class="fa fa-plus" ></i>
                    Agregar excursión
                </a>
            </div>
        </div>
        @endcan

        <div class="card col-12">
            @if (session('message'))
                <div id="mensajepersonalizado" class="alert alert-default-success mt-2 alert-dismissible fade show" role="alert">{{ session('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card-header">
                <h3 class="card-title">Listado de excursiones</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="dataTableExcursiones" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Estatus</th>
                                    <th class="text-center">Días</th>
                                    <th class="text-center">Calendario</th>
                                    <th>Menores</th>
                                    <th>Infantes</th>
                                    <th class="text-center">Promoción</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($excursiones as $excursion)
                                    <tr id="excursion-id-{{ $excursion->id }}">
                                        <td class="dtr-control sorting_1" tabindex="0">{{ $excursion->id }}</td>
                                        <td>{{ $excursion->nombre }}</td>
                                        <td>{{ $excursion->tipo->nombre }}</td>
                                        <td>
                                            @if ($excursion->publicar_excursion == '0')
                                                <span class="text-danger">Desactivado <i class="fas fa-times-circle"></i></span>
                                            @else
                                                <span class="text-success">Activo <i class="fas fa-check-circle"></i></span>
                                            @endif
                                        <td class="text-center">{{ $excursion->cantidad_dias }}</td>
                                        <td class="text-center"><i class="fas {{ $excursion->calendario == '0' ? 'text-danger fa-calendar-minus' : 'text-success fa-calendar-plus' }}"></i></td>
                                        <td>{{ $excursion->menores == '0' ? 'No se aceptan' : 'Sí se aceptan' }}</td>
                                        <td>{{ $excursion->infantes == '0' ? 'No se aceptan' : 'Sí se aceptan' }}</td>
                                        <td class="text-center">
                                            @if ($excursion->idpromocion > 0)
                                                <span class="text-success">Sí tiene <i class="fas fa-check-circle"></i></span>
                                            @else
                                                <span class="text-danger">No tiene <i class="fas fa-times-circle"></i></span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center justify-content-center gap-10">
                                                <a type="button" class="btn btn-primary" href="{{ route('excursiones.edit', $excursion->id) }}">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>

                                                <button type="button" class="btn btn-danger" data-excursion-id="{{ $excursion->id }}" onclick="modalEliminarExcursion(event)">
                                                    <i class="fas fa-trash me-3"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Estatus</th>
                                    <th class="text-center">Días</th>
                                    <th class="text-center">Calendario</th>
                                    <th>Menores</th>
                                    <th>Infantes</th>
                                    <th class="text-center">Promoción</th>
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
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
@stop

@section('plugins.Sweetalert2', true)
@section('plugins.Datatables_Buttons', true)

@section('js')
    <script>
        $(document).ready(function() {
            if ($("#mensajepersonalizado").length > 0) {
                setTimeout(function() {
                    esconderAlerta("mensajepersonalizado");
                }, 3000);
            }
        });

        function modalEliminarExcursion(event) {
            const btnTarget = event.currentTarget;
            const idExcursiones = btnTarget.getAttribute("data-excursion-id");
            const fila = document.getElementById("excursion-id-" + idExcursiones);
            const cantidadExcursiones = document.getElementById("cantidad-excursiones");
            const cantidadExcursionesSinPublicar = document.getElementById("cantidad-excursiones-sin-publicar");

            Swal.fire({
                title: 'Eliminar excursión?',
                input: 'text',
                text: "Esta seguro de continuar? Escriba la palabra ELIMINAR en la entrada de texto y luego pulse el botón para eliminar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar excursión',
                cancelButtonText: 'Cancelar',
                showLoaderOnConfirm: true,
                preConfirm: (confirmText) => {
                    if (confirmText !== "ELIMINAR") {
                        Swal.showValidationMessage(
                            `El texto no es correcto`
                        )
                    } else {
                        const formulario = new FormData();
                        formulario.append("_method", "DELETE");
                        formulario.append("_token", "{{ csrf_token() }}");

                        return fetch("{{ route('excursiones.index') }}" + "/" + idExcursiones, {
                                method: "POST",
                                body: formulario
                            })
                            .then(res => {return res.json()})
                            .catch(e => {
                                Swal.fire({
                                    title: 'Algo salió mal!',
                                    icon: 'error'
                                });
                            });
                    }
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    if (Number(result.value.code) === 200) {
                        // Actualizamos el numero de excursiones
                        cantidadExcursiones.textContent = Number(cantidadExcursiones.textContent) - 1;
                        cantidadExcursionesSinPublicar.textContent = Number(cantidadExcursionesSinPublicar.textContent) - 1;
                        fila.remove();
    
                        Swal.fire({
                            title: 'Excursión eliminada!',
                            icon: 'success'
                        });                    
                    } else {
                        Swal.fire({
                            title: 'Algo salió mal!',
                            text: result.value.body.msg,
                            icon: 'error'
                        });
                    }
                }
            });
        };

        (function() {
            const meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
            const dias_semana = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
            
            const tiempoTranscurrido = Date.now();
            const hoy = new Date(tiempoTranscurrido);
            
            const fecha = dias_semana[hoy.getDay()] + ', ' + hoy.getDate() + ' de ' + meses[hoy.getMonth()] + ' de ' + hoy.getUTCFullYear()

            document.addEventListener("DOMContentLoaded", function() {
                if ($.fn.dataTable.isDataTable('#dataTableExcursiones')) {
                    let table = $('#dataTableExcursiones').DataTable();
                    table.destroy();
                }

                let table = $('#dataTableExcursiones').DataTable({
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
                                        margin: [10, 0]
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
                                        margin: [30, 0]
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
                }).buttons().container().appendTo('#dataTableExcursiones_wrapper .col-md-6:eq(0)');
            })
        })();
    </script>
@stop
