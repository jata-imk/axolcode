@php
    $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
@endphp

@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Usuarios')

@section('css')
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
@stop

@section('content')

    <div class="row pt-2">
        <div class="col-12 col-sm-6 col-md-3">

        </div>

        <div class="col-12 col-sm-6 col-md-3">

        </div>

        @cannot('create', App\Models\Usuario::class)
        <div class="col-12 col-sm-6 col-md-3">

        </div>
        @endcannot

        <div class="col-12 col-sm-6 col-md-3 pl-0">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total de Usuarios</span>
                    <span class="info-box-number">{{ count($usuarios) }}</span>
                </div>
            </div>
        </div>

        @can('create', App\Models\Usuario::class)
        <div class="col-12 col-sm-6 col-md-3 pr-0">
            <div class="info-box mb-3 text-center">
                <a type="button" href="{{ route('usuarios.create') }}" class="btn btn-primary w-100 btn-lg d-flex justify-content-center align-items-center gap-10">
                    <i class="fa fa-plus" ></i>
                    Agregar usuario
                </a>
            </div>
        </div>
        @endcan

        <div class="card col-12">
            <div class="card-header">
                <h3 class="card-title">Listado de usuarios</h3>
            </div>

            <div class="card-body">
                <table id="dataTableUsuarios" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 5px">#</th>
                            <th>Nombre&nbsp;completo</th>

                            @if (Auth::user()->id_rol === 0)
                            <th>Empresa</th>
                            @endif

                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Creado&nbsp;el</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $usuario)
                            <tr id="usuario-id-{{ $usuario->id }}">
                                <td>{{ $usuario->id }}</td>
                                <td>{{ $usuario->name }}</td>

                                @if (Auth::user()->id_rol === 0)
                                <td>{{ $usuario->empresa_nombre_comercial }}</td>
                                @endif

                                <td class="{{ ($usuario->telefono_celular == "") ? "text-muted font-italic" : "" }}">{{ ($usuario->telefono_celular != "") ? $usuario->telefono_celular : "No especificado" }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td @if ($usuario->id_rol === 0) class="text-info font-weight-bold" @endif>@if ($usuario->id_rol === 0) SuperAdmin @else {{ $usuario->rol_nombre }} @endif</td>
                                
                                @php
                                    [$timestampFechaAlta, $timestampHoraAlta] = explode(' ', $usuario->created_at);
                                    [$anioAlta, $mesAlta, $diaAlta] = explode('-', $timestampFechaAlta);
                                @endphp
                                <td>
                                    {{ $diaAlta . " de " . $meses[date("n", mktime(0, 0, 0, $mesAlta, $diaAlta, $anioAlta)) - 1] . " del " . $anioAlta }}
                                    <br>
                                    <small>Hora: {{ $timestampHoraAlta }}</small>
                                </td>
                                
                                <td>
                                    <div class="d-flex align-items-center justify-content-center gap-10">
                                        <a type="button" class="btn btn-primary" href="{{ route('usuarios.edit', $usuario->id) }}">
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
                            <th>Nombre&nbsp;completo</th>
                            @if (Auth::user()->id_rol === 0)
                            <th>Empresa</th>
                            @endif
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Creado&nbsp;el</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

@stop

@section('plugins.Datatables_Buttons', true)

@section('js')
    <script>
        (function() {
            document.addEventListener("DOMContentLoaded", function() {
                if ($.fn.dataTable.isDataTable('#dataTableUsuarios')) {
                    let table = $('#dataTableUsuarios').DataTable();
                    table.destroy();
                }

                let table = $('#dataTableUsuarios').DataTable({
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
                }).buttons().container().appendTo('#dataTableUsuarios_wrapper .col-md-6:eq(0)');
            })
        })();
    </script>
@stop
