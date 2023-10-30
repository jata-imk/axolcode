@php
    $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
@endphp

@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Roles')

@section('content')

    <div class="row pt-2">
        <div class="col-12 col-sm-6 col-md-3">

        </div>

        <div class="col-12 col-sm-6 col-md-3">

        </div>

        @cannot('create', App\Models\Roles\Rol::class)
        <div class="col-12 col-sm-6 col-md-3">

        </div>
        @endcannot

        <div class="col-12 col-sm-6 col-md-3 pl-0">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total de Roles</span>
                    <span class="info-box-number">{{ count($roles) }}</span>
                </div>
            </div>
        </div>

        @can('create', App\Models\Roles\Rol::class)
        <div class="col-12 col-sm-6 col-md-3 pr-0">
            <div class="info-box mb-3 text-center">
                <a type="button" href="{{ route('roles.create') }}" class="btn btn-primary w-100 btn-lg d-flex justify-content-center align-items-center gap-10">
                    <i class="fa fa-plus" ></i>
                    Agregar rol
                </a>
            </div>
        </div>
        @endcan

        <div class="card col-12">
            <div class="card-header">
                <h3 class="card-title">Listado de roles</h3>
            </div>

            <div class="card-body">
                <table id="dataTableRoles" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 5px">#</th>
                            <th>Nombre</th>
                            <th>Creado&nbsp;el</th>
                            <th>Ultima actualización</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $rol)
                            <tr id="rol-id-{{ $rol->id }}">
                                <td>{{ $rol->id }}</td>
                                <td>{{ $rol->nombre }}</td>
                                
                                @php
                                    [$timestampFechaAlta, $timestampHoraAlta] = explode(' ', $rol->created_at);
                                    [$anioAlta, $mesAlta, $diaAlta] = explode('-', $timestampFechaAlta);
                                @endphp
                                <td>
                                    {{ $diaAlta . " de " . $meses[date("n", mktime(0, 0, 0, $mesAlta, $diaAlta, $anioAlta)) - 1] . " del " . $anioAlta }}
                                    <br>
                                    <small>Hora: {{ $timestampHoraAlta }}</small>
                                </td>

                                @php
                                    [$timestampFechaModificacion, $timestampHoraModificacion] = explode(' ', $rol->updated_at);
                                    [$anioModificacion, $mesModificacion, $diaModificacion] = explode('-', $timestampFechaModificacion);
                                @endphp
                                <td>
                                    {{ $diaModificacion . " de " . $meses[date("n", mktime(0, 0, 0, $mesModificacion, $diaModificacion, $anioModificacion)) - 1] . " del " . $anioModificacion }}
                                    <br>
                                    <small>Hora: {{ $timestampHoraModificacion }}</small>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center justify-content-center gap-10">
                                        <a type="button" class="btn btn-primary" href="{{ route('roles.edit', $rol->id) }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th style="width: 5px">#</th>
                            <th>Nombre</th>
                            <th>Creado&nbsp;el</th>
                            <th>Ultima actualización</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@stop
@section('css')
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
@stop
@section('plugins.Datatables_Buttons', true)
@section('js')
    <script>
        (function() {
            document.addEventListener("DOMContentLoaded", function() {
                if ($.fn.dataTable.isDataTable('#dataTableRoles')) {
                    let table = $('#dataTableRoles').DataTable();
                    table.destroy();
                }

                let table = $('#dataTableRoles').DataTable({
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
                }).buttons().container().appendTo('#dataTableRoles_wrapper .col-md-6:eq(0)');
            })
        })();
    </script>
@stop
