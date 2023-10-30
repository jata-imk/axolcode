@php
    $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
@endphp

@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Listado de reservaciones')

@section('content')
    <div class="row pt-2">
        <div class="col-12 col-sm-6 col-md-3">

        </div>

        <div class="col-12 col-sm-6 col-md-3">

        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-file-invoice"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total de reservaciones</span>
                    <span id="cantidad-reservaciones" class="info-box-number">
                        {{ $reservaciones->count() }}
                    </span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3 text-center">
                <a type="button" href="{{ route('reservacion-excursiones.create') }}"
                    class="btn btn-primary w-100 btn-lg d-flex justify-content-center align-items-center gap-10">
                    <i class="fa fa-plus" ></i>
                    Agregar reservación
                </a>
            </div>
        </div>

        <div class="card col-12">
            @if (session('message'))
                <div id="mensajepersonalizado" class="alert alert-default-success mt-2 alert-dismissible fade show"
                    role="alert">{{ session('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card-header">
                <h3 class="card-title">Listado de reservaciones</h3>
            </div>

            <div class="card-body pl-2 pr-2">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="dataTableReservaciones" class="table table-striped table-bordered lista-reservaciones">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Inf.&nbsp;cliente</th>
                                    <th>Excursión</th>
                                    <th>Fecha(s)&nbsp;excursión</th>
                                    <th style="width: 175px">Cant. pasajeros</th>
                                    <th>Servicios</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reservaciones as $reservacion)
                                    <tr id="reserva-id-{{ $reservacion->id }}">
                                        <td>{{ $reservacion->id }}</td>
                                        <td>
                                            <div class="lista-reservaciones__celda lista-reservaciones__celda--info-cliente">
                                                <span>{{ $reservacion->cliente_nombre }} {{ $reservacion->cliente_apellido }}</span>
                                                <small class="w-100">
                                                    <div class="iti" style="width: 35px; vertical-align: middle; margin-top: -5px;">
                                                        <div class="iti__flag-container" style="left: 0; right: unset;">
                                                            <div class="iti__selected-flag">
                                                                <div class="iti__flag iti__{{ strtolower($reservacion->cliente_telefono_celular_iso_pais) }}"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{ $reservacion->cliente_telefono_celular }}
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="lista-reservaciones__celda lista-reservaciones__celda--excursion">
                                                <div class="buscador-excursion-resultado__box-img">
                                                    @if ($reservacion->excursion_path_imagen === null)
                                                    <img    src="{{ asset('assets/img/placeholder-image.webp') }}"
                                                            alt="Placeholder imagen"
                                                            onerror="handleImgLoad(event)">
                                                    @else
                                                    <img    src="storage/{{ $reservacion->excursion_path_imagen }}"
                                                            alt="Imagen {{ $reservacion->excursion_nombre }}"
                                                            onerror="handleImgLoad(event)">
                                                    @endif
                                                </div>
                                                <div>
                                                    {{ $reservacion->excursion_nombre }}
                                                    <br>
                                                    <small>{{ $reservacion->tipo_nombre }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="lista-reservaciones__celda lista-reservaciones__celda--fechas">
                                                @if ($reservacion->id_fecha !== 0)
                                                    @php
                                                        [$anioInicio, $mesInicio, $diaInicio] = explode('-', $reservacion->fecha_inicio);
                                                    @endphp
                                                    <span><small>Inicio:</small> {{ $diaInicio . " de " . $meses[date("n", mktime(0, 0, 0, $mesInicio, $diaInicio, $anioInicio)) - 1] . " del " . $anioInicio }}</span>
                                                    
                                                    @php
                                                        [$anioFin, $mesFin, $diaFin] = explode('-', $reservacion->fecha_fin);
                                                    @endphp
                                                    <span><small>Fin:</small> {{ $diaFin . " de " . $meses[date("n", mktime(0, 0, 0, $mesFin, $diaInicio, $anioFin)) - 1] . " del " . $anioFin }}</span>
                                                @else
                                                    @php
                                                        [$anioInicio, $mesInicio, $diaInicio] = explode('-', $reservacion->fecha_inicio_personalizada);
                                                    @endphp
                                                    <span><small>Inicio:</small> {{ $diaInicio . " de " . $meses[date("n", mktime(0, 0, 0, $mesInicio, $diaInicio, $anioInicio)) - 1] . " del " . $anioInicio }}</span>
                                                    
                                                    @php
                                                        [$anioFin, $mesFin, $diaFin] = explode('-', $reservacion->fecha_fin_personalizada);
                                                    @endphp
                                                    <span><small>Fin:</small> {{ $diaFin . " de " . $meses[date("n", mktime(0, 0, 0, $mesFin, $diaInicio, $anioFin)) - 1] . " del " . $anioFin }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="lista-reservaciones__celda lista-reservaciones__celda--excursion flex-wrap">
                                                @if ($reservacion->cantidad_adultos > 0)
                                                    <div class="w-100">
                                                        <i class="fas fa-male text-center" style="width: 20px"></i> {{ $reservacion->cantidad_adultos }} Adulto(s)
                                                    </div>
                                                @endif

                                                @if ($reservacion->cantidad_menores > 0)
                                                    <div class="w-100">
                                                        <i class="fas fa-child text-center" style="width: 20px"></i> {{ $reservacion->cantidad_menores }} Menor(es)
                                                    </div>
                                                @endif

                                                @if ($reservacion->cantidad_infantes > 0)
                                                    <div class="w-100">
                                                        <i class="fas fa-baby text-center" style="width: 20px"></i></i> {{ $reservacion->cantidad_infantes }} Infante(s)
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="lista-reservaciones__celda lista-reservaciones__celda--info-adicional flex-wrap">
                                                @if ($reservacion->id_promocion !== 0)
                                                    <i class="fas fa-percentage text-success" title="Aplica promoción"></i>
                                                @else
                                                    <i class="fas fa-percentage text-danger" title="No aplica promoción"></i>
                                                @endif

                                                @if ($reservacion->hoteleria !== 0)
                                                    <i class="fas fa-hotel text-success" title="Incluye hotelería"></i>
                                                @else
                                                    <i class="fas fa-hotel text-danger" title="No incluye hotelería"></i>
                                                @endif

                                                @if ($reservacion->vuelos !== 0)
                                                    <i class="fas fa-plane text-success" title="Incluye vuelos"></i>
                                                @else
                                                    <i class="fas fa-plane text-danger" title="No incluye vuelos"></i>
                                                @endif

                                            </div>
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center justify-content-center gap-10">
                                                <a type="button" class="btn btn-primary" href="{{ route('reservacion-excursiones.edit', $reservacion->id) }}">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>

                                                <button type="button" class="btn btn-danger" data-excursion-id="{{ $reservacion->id }}" onclick="modalEliminarReservacion(event)">
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
                                    <th>Inf.&nbsp;cliente</th>
                                    <th>Excursión</th>
                                    <th>Fecha(s)&nbsp;excursión</th>
                                    <th>Cant. pasajeros</th>
                                    <th>Servicios</th>
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
    <link rel="stylesheet" href={{ asset("/assets/plugins/intlTelInput/css/intlTelInput.min.css") }}>
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

        function modalEliminarReservacion(event) {
            const btnTarget = event.currentTarget;
            const idReservacion = btnTarget.getAttribute("data-reservacion-id");
            const fila = document.getElementById("reserva-id-" + idReservacion);
            const qtyReservaciones = document.getElementById("cantidad-reservaciones");

            Swal.fire({
                title: 'Cancelar reservación?',
                input: 'text',
                text: "Esta seguro de continuar? Escriba la palabra CANCELAR en la entrada de texto y luego pulse el botón para cancelar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Cancelar reservación',
                cancelButtonText: 'Cancelar',
                showLoaderOnConfirm: true,
                preConfirm: (confirmText) => {
                    if (confirmText !== "CANCELAR") {
                        Swal.showValidationMessage(
                            `El texto no es correcto`
                        )
                    }
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Reservación cancelada!',
                        icon: 'success'
                    });

                    const formulario = new FormData();
                    formulario.append("_method", "DELETE");
                    formulario.append("_token", "{{ csrf_token() }}");

                    fetch("{{ route('reservacion-excursiones.index') }}" + "/" + idReservacion, {
                            method: "POST",
                            body: formulario
                        })
                        .then(data => {
                            // Actualizamos el numero de tipo de tours
                            qtyReservaciones.textContent = Number(qtyReservaciones.textContent) - 1;
                            fila.remove();
                        });
                }
            });
        };

        (function() {
            document.addEventListener("DOMContentLoaded", function() {
                if ($.fn.dataTable.isDataTable('#dataTableReservaciones')) {
                    let table = $('#dataTableReservaciones').DataTable();
                    table.destroy();
                }

                let table = $('#dataTableReservaciones').DataTable({
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
                }).buttons().container().appendTo('#dataTableReservaciones_wrapper .col-md-6:eq(0)');
            })
        })();
    </script>
@stop
