@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Agregar rol')

@section('content_header')
<h1><span class="font-weight-bold">CloudTravel</span> | Agregar rol</h1>
@stop

@section('content')

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
        </div>

        <div class="card-body">
            <form id="form-agregar-rol" action="{{route('roles.store')}}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="row border-bottom mb-2">
                    <h6>Información general</h6>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input id="nombre" type="text" name="nombre" maxlength="63" class="form-control" placeholder="Ingresar nombre..." required>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 mt-4 mb-4"></div>

                    <div class="col-md-12 col-sm-12" style="overflow-x: scroll;  height: 80vh;">
                        <table id="dataTableRolMenus" class="table table-striped" style="border-radius: 7px; border-bottom: 1px solid #dee2e6; overflow: visible;">
                            <thead style="position: sticky; top: 0; left: 0; z-index: 100; background-color: white;">
                                <tr>
                                    <th colspan="1" style="background-color: transparent">&nbsp;</th>
                                    <th colspan="1" style="background-color: transparent">&nbsp;</th>
                                    <th colspan="4" class="text-center" style="border-top-left-radius: 7px; border-top-right-radius: 7px;">Permisos</th>
                                    <th colspan="1" style="background-color: transparent">&nbsp;</th>
                                </tr>
                                <tr>
                                    <th style="width: 10px; border-top-left-radius: 7px;">#</th>
                                    <th style="min-width: 200px;">Modulo</th>
                                    <th class="text-center" style="min-width: 110px;">
                                        <div class="d-flex align-items-center justify-content-center" onclick="event.stopPropagation()">
                                            <div class="form-group m-0">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="select-all-crear" >
                                                    <label for="select-all-crear" class="custom-control-label">Crear</label>
                                                </div>
                                            </div>
                                        </div>
                                    </th>
                                    <th class="text-center" style="min-width: 110px;">
                                        <div class="d-flex align-items-center justify-content-center" onclick="event.stopPropagation()">
                                            <div class="form-group m-0">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="select-all-ver" >
                                                    <label for="select-all-ver" class="custom-control-label">Ver</label>
                                                </div>
                                            </div>
                                        </div>
                                    </th>
                                    <th class="text-center" style="min-width: 110px;">
                                        <div class="d-flex align-items-center justify-content-center" onclick="event.stopPropagation()">
                                            <div class="form-group m-0">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" value="1" id="select-all-editar" >
                                                    <label for="select-all-editar" class="custom-control-label">Editar</label>
                                                </div>
                                            </div>
                                        </div>
                                    </th>
                                    <th class="text-center" style="min-width: 110px;">
                                        <div class="d-flex align-items-center justify-content-center" onclick="event.stopPropagation()">
                                            <div class="form-group m-0">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" value="1" id="select-all-eliminar" >
                                                    <label for="select-all-eliminar" class="custom-control-label">Eliminar</label>
                                                </div>
                                            </div>
                                        </div>
                                    </th>
                                    <th colspan="1" style="background-color: transparent; width: 20px; padding-right: 0px;">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($modulos as $modulo)
                                    <tr>
                                        <td style="border-left: 1px solid #dee2e6;">{{ $modulo->id }}</td>
                                        <td style="border-left: 1px solid #dee2e6;">
                                            <i class="{{$modulo->icon}}"></i>&nbsp;
                                            {{ $modulo->text }}
                                        </td>
                                        <td class="text-center" style="border-left: 1px solid #dee2e6;">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" value="1" id="{{$modulo->id}}-crear" name="{{$modulo->id}}-crear" data-checkbox-crear>
                                                    <label for="{{$modulo->id}}-crear" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center" style="border-left: 1px solid #dee2e6;">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" value="1" id="{{$modulo->id}}-ver" name="{{$modulo->id}}-ver" data-checkbox-ver>
                                                    <label for="{{$modulo->id}}-ver" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center" style="border-left: 1px solid #dee2e6;">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" value="1" id="{{$modulo->id}}-editar" name="{{$modulo->id}}-editar" data-checkbox-editar>
                                                    <label for="{{$modulo->id}}-editar" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center" style="border-left: 1px solid #dee2e6;">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" value="1" id="{{$modulo->id}}-eliminar" name="{{$modulo->id}}-eliminar" data-checkbox-eliminar>
                                                    <label for="{{$modulo->id}}-eliminar" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center" style="border-left: 1px solid #dee2e6; border-right: 1px solid #dee2e6; padding-right: 0px;">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input id="select-all-row-{{$modulo->id}}" class="custom-control-input" type="checkbox" data-id-menu="{{$modulo->id}}" data-select-all-row>
                                                    <label for="select-all-row-{{$modulo->id}}" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button form="form-agregar-rol" class="btn btn-primary mx-3" type="submit">
                <i class="fas fa-pencil-alt"></i>
                Agregar rol
            </button>

            <a href="{{ route('roles.index') }}" class="btn btn-danger" type="button">
                <i class="fas fa-times-circle"></i> Cancelar
            </a>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href={{ asset("/assets/css/admin_custom.css") }}>
@stop

@section('plugins.IntTelInput', true)
@section('plugins.Select2', true)

@section('js')
    <script>
        (function() {
            document.addEventListener("DOMContentLoaded", function() {
                if ($.fn.dataTable.isDataTable('#dataTableRolMenus')) {
                    let table = $('#dataTableRolMenus').DataTable();
                    table.destroy();
                }

                let table = $('#dataTableRolMenus').DataTable({
                    "order": [
                        [1, 'asc']
                    ],
                    "paging": false,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": true,
                    "info": false,
                    "autoWidth": false,
                    "responsive": false,
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
                });

                /* Código que se ejecutará una vez se haya cargado todo el HTML */
                const formulario = document.getElementById("form-agregar-rol");

                const selectAllCrear = document.getElementById("select-all-crear");
                const selectAllVer = document.getElementById("select-all-ver");
                const selectAllEditar = document.getElementById("select-all-editar");
                const selectAllEliminar = document.getElementById("select-all-eliminar");

                const checkboxCrear = document.querySelectorAll("input[data-checkbox-crear]");
                const checkboxVer = document.querySelectorAll("input[data-checkbox-ver]");
                const checkboxEditar = document.querySelectorAll("input[data-checkbox-editar]");
                const checkboxEliminar = document.querySelectorAll("input[data-checkbox-eliminar]");

                const checkboxSelectAllRow = document.querySelectorAll("input[data-select-all-row]");

                selectAllCrear.addEventListener("change", (event) => {
                    for (let checkbox of checkboxCrear) {
                        checkbox.checked = event.target.checked;
                    }
                });

                selectAllVer.addEventListener("change", (event) => {
                    for (let checkbox of checkboxVer) {
                        checkbox.checked = event.target.checked;
                    }
                });

                selectAllEditar.addEventListener("change", (event) => {
                    for (let checkbox of checkboxEditar) {
                        checkbox.checked = event.target.checked;
                    }
                });

                selectAllEliminar.addEventListener("change", (event) => {
                    for (let checkbox of checkboxEliminar) {
                        checkbox.checked = event.target.checked;
                    }
                });

                function toggleFilaCheckbox (event) {
                    const idMenu = event.target.getAttribute("data-id-menu");
    
                    document.getElementById(idMenu + "-crear").checked = event.target.checked;
                    document.getElementById(idMenu + "-ver").checked = event.target.checked;
                    document.getElementById(idMenu + "-editar").checked = event.target.checked;
                    document.getElementById(idMenu + "-eliminar").checked = event.target.checked;
                }
                
                for (let checkbox of checkboxSelectAllRow) {
                    checkbox.addEventListener("change", (event) => {
                        toggleFilaCheckbox(event);
                    });
                }
            });
        })();
    </script>
@stop
