@php
    $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
@endphp

@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Promociones')

@section('content')
    <div class="row pt-2">
        <div class="col-12 col-sm-6 col-md-3">
            
        </div>
        
        <div class="col-12 col-sm-6 col-md-3">
            
        </div>

        @cannot('create', App\Models\Promociones\Promocion::class)
        <div class="col-12 col-sm-6 col-md-3">

        </div>
        @endcannot

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total de promociones</span>
                    <span id="cantidad-promociones" class="info-box-number">
                        {{ $cpromociones }}
                    </span>
                </div>
            </div>
        </div>

        @can('create', App\Models\Promociones\Promocion::class)
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3 text-center">
                <a type="button" href="{{ route('promociones.create') }}" class="btn btn-primary w-100 btn-lg d-flex justify-content-center align-items-center gap-10">
                    <i class="fa fa-plus" ></i>
                    Agregar promoción
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
                <h3 class="card-title">Listado de promociones</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="dataTableCategoriaTour" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Promoción</th>
                                    <th>Descuento</th>
                                    <th>Tipo de descuento</th>
                                    <th>Monto del descuento</th>
                                    <th>Sitio web</th>
                                    <th>Fecha alta</th>
                                    <th>Ultimo cambio</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($promociones as $promocion)
                                    <tr class="@if ($promocion->publicar == 0) text-danger @endif" id="promocion-id-{{ $promocion->id }}">
                                        <td>{{ $promocion->id }}</td>
                                        <td>{{ $promocion->nombre }}</td>
                                        <td>{{ $promocion->descuento == '1' ? 'Sí' : 'No aplica' }}</td>
                                        <td>
                                            @if ($promocion->descuento == '1')
                                                {{ $promocion->tipo_descuento == '1' ? 'Porcentaje' : 'Monto fijo' }}
                                            @else
                                                No aplica
                                            @endif
                                        </td>
                                        <td>
                                            @if ($promocion->descuento == '1')
                                                {{ $promocion->tipo_descuento == 1 ? $promocion->valor_promocion . '%' : '$' . $promocion->valor_promocion . 'MXN' }}
                                            @else
                                                No aplica
                                            @endif
                                        </td>
                                        <td>{{ $promocion->publicar == '1' ? 'Oferta publicada' : 'No publicada' }}</i></td>

                                        @php
                                            [$timestampFechaAlta, $timestampHoraAlta] = explode(' ', $promocion->created_at);
                                            [$anioAlta, $mesAlta, $diaAlta] = explode('-', $timestampFechaAlta);
                                        @endphp
                                        <td>
                                            {{ $diaAlta . " de " . $meses[date("n", mktime(0, 0, 0, $mesAlta, $diaAlta, $anioAlta)) - 1] . " del " . $anioAlta }}
                                            <br>
                                            <small>Hora: {{ $timestampHoraAlta }}</small>
                                        </td>

                                        @php
                                            [$timestampFechaModificacion, $timestampHoraModificacion] = explode(' ', $promocion->updated_at);
                                            [$anioModificacion, $mesModificacion, $diaModificacion] = explode('-', $timestampFechaModificacion);
                                        @endphp
                                        <td>
                                            {{ $diaModificacion . " de " . $meses[date("n", mktime(0, 0, 0, $mesModificacion, $diaModificacion, $anioModificacion)) - 1] . " del " . $anioModificacion }}
                                            <br>
                                            <small>Hora: {{ $timestampHoraModificacion }}</small>
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center justify-content-center gap-10">
                                                <a type="button" class="btn btn-primary" href="{{ route('promociones.edit', $promocion->id) }}">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger" data-promocion-id="{{ $promocion->id }}" onclick="modalEliminarPromocion(event)">
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
                                    <th>Promoción</th>
                                    <th>Descuento</th>
                                    <th>Tipo de descuento</th>
                                    <th>Monto del descuento</th>
                                    <th>Sitio web</th>
                                    <th>Fecha alta</th>
                                    <th>Ultimo cambio</th>
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

        function modalEliminarPromocion(event) {
            const btnTarget = event.currentTarget;
            const idPromocion = btnTarget.getAttribute("data-promocion-id");
            const fila = document.getElementById("promocion-id-" + idPromocion);
            const cantidadPromociones = document.getElementById("cantidad-promociones");

            Swal.fire({
                title: 'Eliminar promocion?',
                input: 'text',
                text: "Esta seguro de continuar? Escriba la palabra ELIMINAR en la entrada de texto y luego pulse el botón para eliminar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar promoción',
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
                        formulario.append("_token", "{{csrf_token()}}");

                        return fetch("{{ route('promociones.index') }}" + "/" + idPromocion, {
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
                        // Actualizamos el numero de promociones
                        cantidadPromociones.textContent = Number(cantidadPromociones.textContent) - 1;
                        fila.remove();

                        Swal.fire({
                            title: 'Promoción eliminada!',
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
            document.addEventListener("DOMContentLoaded", function() {
                if ($.fn.dataTable.isDataTable('#dataTableCategoriaTour')) {
                    let table = $('#dataTableCategoriaTour').DataTable();
                    table.destroy();
                }

                let table = $('#dataTableCategoriaTour').DataTable({
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
                }).buttons().container().appendTo('#dataTableCategoriaTour_wrapper .col-md-6:eq(0)');
            })
        })();
    </script>
@stop
