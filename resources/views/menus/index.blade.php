@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Modulos')

@section('css')
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
@stop

@section('content')

    <div class="row pt-2">
        <div class="col-12 col-sm-6 col-md-3">
            
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            
        </div>

        <div class="col-12 col-sm-6 col-md-3 pl-0">

        </div>

        <div class="col-12 col-sm-6 col-md-3 pr-0">
            <div class="info-box mb-3 text-center">
                <a type="button" href="{{ route('modulos.create') }}" class="btn btn-primary w-100 btn-lg d-flex justify-content-center align-items-center gap-10">
                    <i class="fa fa-plus" ></i>
                    Agregar módulo
                </a>
            </div>
        </div>

        <div class="card col-12">
            <div class="card-header">
                <h3 class="card-title">Listado de módulos</h3>
            </div>

            <div class="card-body">
                <table id="dataTableModulos" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 5px">#</th>
                            <th>Nombre</th>
                            <th>Icono</th>
                            <th>URL</th>
                            <th>Sección</th>
                            <th>Tipo</th>
                            <th>Identificador</th>
                            <th>Status</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $nombrePrincipalIdentificadores = [];
                            foreach ($menus as $menu) {
                                $nombrePrincipalIdentificadores[$menu->key] = $menu->text;
                            }
                        @endphp

                        @foreach ($menus as $menu)
                            <tr id="menu-id-{{ $menu->id }}">
                                <td>{{ $menu->id }}</td>
                                <td>{{ $menu->text }}</td>
                                <td>
                                    <i class="{{$menu->icon}}"></i>
                                </td>
                                <td>{{ $menu->url }}</td>
                                <td>{{ $menu->section }}</td>
                                <td>
                                    @php
                                        if (($menu->url == "") && ($menu->key != "")) {
                                            echo "Contenedor de módulos";
                                        } else if ($menu->add_in != "") {
                                            echo "Submódulo de: " . $nombrePrincipalIdentificadores[$menu->add_in];
                                        } else {
                                            echo "Módulo del CRM";
                                        }
                                    @endphp
                                </td>

                                <td>{{ $menu->key }}</td>
                                <td data-columna-nombre="status">
                                    @if ($menu->active === 1)
                                    <span class="text-success">Activo <i class="fas fa-check-circle"></i></span>
                                    @else
                                    <span class="text-danger">Desactivado <i class="fas fa-times-circle"></i></span>
                                    @endif
                                </td>

                                <td>
                                    <div class="d-flex align-items-center justify-content-center gap-10">
                                        <a type="button" class="btn btn-primary" href="{{ route('modulos.edit', $menu->id) }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>

                                        @if ((int) $menu->active === 1)
                                            <button type="button" class="btn btn-danger" data-menu-id="{{ $menu->id }}" onclick="modalDesactivarMenu(event)">
                                                <i class="fas fa-times-circle"></i>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-success" data-menu-id="{{ $menu->id }}" onclick="modalActivarMenu(event)">
                                                <i class="fas fa-check-circle"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th style="width: 5px">#</th>
                            <th>Nombre</th>
                            <th>Icono</th>
                            <th>URL</th>
                            <th>Sección</th>
                            <th>Tipo</th>
                            <th>Identificador</th>
                            <th>Status</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

@stop

@section('plugins.Sweetalert2', true)
@section('plugins.Datatables_Buttons', true)

@section('js')
    <script>
        function modalActivarMenu(event) {
            const btnTarget = event.currentTarget;
            const idMenu = btnTarget.getAttribute("data-menu-id");
            const fila = document.getElementById("menu-id-" + idMenu);
            const celda = fila.querySelector("td[data-columna-nombre=status]");

            Swal.fire({
                title: 'Activar menú?',
                input: 'text',
                text: "Esta seguro de continuar? Escriba la palabra ACTIVAR en la entrada de texto y luego pulse el botón para activar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Activar menú',
                cancelButtonText: 'Cancelar',
                showLoaderOnConfirm: true,
                preConfirm: (confirmText) => {
                    if (confirmText !== "ACTIVAR") {
                        Swal.showValidationMessage(
                            `El texto no es correcto`
                        )
                    }
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    const formulario = new FormData();
                    formulario.append("active", "1");
                    formulario.append("_method", "PATCH");
                    formulario.append("_token", "{{ csrf_token() }}");

                    fetch("{{ route('modulos.index') }}" + "/" + idMenu, {
                            method: "POST",
                            body: formulario
                        })
                        .then(res => res.json())
                        .then(data => {
                            Swal.fire({
                                title: 'Menú activado!',
                                icon: 'success'
                            });
                            
                            // Actualizamos el texto del status del registro en el listado
                            const table = $('#dataTableModulos').DataTable();
                            const cell = table.cell(celda);
                            cell.data(`<span class="text-success">Activo <i class="fas fa-check-circle"></i></span>`).draw();

                            // Actualizamos el boton para cambiar el status
                            const btnTargetParentElement = btnTarget.parentElement;
                            btnTargetParentElement.removeChild(btnTarget);

                            btnTargetParentElement.innerHTML += `
                            <button type="button" class="btn btn-danger" data-menu-id="${idMenu}" onclick="modalDesactivarMenu(event)">
                                <i class="fas fa-times-circle"></i>
                            </button>
                            `;

                            const cellBtns = table.cell(btnTargetParentElement.parentElement);
                            cellBtns.data(btnTargetParentElement.parentElement.innerHTML).draw();
                        });
                }
            });
        };

        function modalDesactivarMenu(event) {
            const btnTarget = event.currentTarget;
            const idMenu = btnTarget.getAttribute("data-menu-id");
            const fila = document.getElementById("menu-id-" + idMenu);
            const celda = fila.querySelector("td[data-columna-nombre=status]");

            Swal.fire({
                title: 'Desactivar menú?',
                input: 'text',
                text: "Esta seguro de continuar? Escriba la palabra DESACTIVAR en la entrada de texto y luego pulse el botón para desactivar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Desactivar menú',
                cancelButtonText: 'Cancelar',
                showLoaderOnConfirm: true,
                preConfirm: (confirmText) => {
                    if (confirmText !== "DESACTIVAR") {
                        Swal.showValidationMessage(
                            `El texto no es correcto`
                        )
                    }
                },
            }).then((result) => {
                if (result.isConfirmed) {
                    const formulario = new FormData();
                    formulario.append("active", "0");
                    formulario.append("_method", "PATCH");
                    formulario.append("_token", "{{ csrf_token() }}");

                    fetch("{{ route('modulos.index') }}" + "/" + idMenu, {
                            method: "POST",
                            body: formulario
                        })
                        .then(res => res.json())
                        .then(data => {
                            Swal.fire({
                                title: 'Menú desactivado!',
                                icon: 'success'
                            });

                            // Actualizamos el texto del status del registro en el listado
                            const table = $('#dataTableModulos').DataTable();
                            const cell = table.cell(celda);
                            cell.data(`<span class="text-danger">Desactivado <i class="fas fa-times-circle"></i></span>`).draw();

                            // Actualizamos el boton para cambiar el status
                            const btnTargetParentElement = btnTarget.parentElement;
                            btnTargetParentElement.removeChild(btnTarget);
                            btnTargetParentElement.innerHTML += `
                            <button type="button" class="btn btn-success" data-menu-id="${idMenu}" onclick="modalActivarMenu(event)">
                                <i class="fas fa-check-circle"></i>
                            </button>
                            `;

                            const cellBtns = table.cell(btnTargetParentElement.parentElement);
                            cellBtns.data(btnTargetParentElement.parentElement.innerHTML).draw();
                        });
                }
            });
        };

        (function() {
            document.addEventListener("DOMContentLoaded", function() {
                if ($.fn.dataTable.isDataTable('#dataTableModulos')) {
                    let table = $('#dataTableModulos').DataTable();
                    table.destroy();
                }

                let table = $('#dataTableModulos').DataTable({
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
                }).buttons().container().appendTo('#dataTableModulos_wrapper .col-md-6:eq(0)');
            })
        })();
    </script>
@stop
