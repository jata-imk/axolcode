@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Empresas')

@section('css')
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
@stop

@section('content')

    <div class="row pt-2">
        <div class="col-12 col-sm-6 col-md-3 pl-0">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total de Empresas</span>
                    <span class="info-box-number">{{ count($empresas) }}</span>
                </div>

            </div>

        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fa fa-check-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Empresas activas</span>
                    <span id="numero-empresas-activas" class="info-box-number">{{ count($empresasActivas) }}</span>
                </div>

            </div>

        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-times-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Empresas inactivas</span>
                    <span id="numero-empresas-inactivas" class="info-box-number">{{ count($empresas) - count($empresasActivas) }}</span>
                </div>

            </div>

        </div>

        <div class="col-12 col-sm-6 col-md-3 pr-0">
            <div class="info-box mb-3 text-center">
                <a type="button" href="{{ route('empresas.create') }}" class="btn btn-primary w-100 btn-lg d-flex justify-content-center align-items-center gap-10">
                    <i class="fa fa-plus" ></i>
                    Agregar empresa
                </a>
            </div>
        </div>

        <div class="card col-12">
            <div class="card-header">
                <h3 class="card-title">Listado de empresas</h3>
            </div>

            <div class="card-body">
                <table id="dataTableEmpresas" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 5px">#</th>
                            <th>Nombre&nbsp;comercial</th>
                            <th>Razón&nbsp;social</th>
                            <th>Tel.&nbsp;oficina</th>
                            <th>Tel.&nbsp;celular</th>
                            <th>RFC</th>
                            <th>Fecha&nbsp;de&nbsp;alta</th>
                            <th>Status</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($empresas as $empresa)
                            <tr id="empresa-id-{{ $empresa->id }}">
                                <td>{{ $empresa->id }}</td>
                                <td>{{ $empresa->nombre_comercial }}</td>
                                <td>{{ $empresa->razon_social }}</td>
                                <td>{{ $empresa->telefono_oficina }}</td>
                                <td>{{ $empresa->telefono_celular }}</td>
                                <td>{{ $empresa->rfc }}</td>
                                <td>{{ $empresa->fecha_alta }}</td>

                                @php
                                    $arrEmpresaStatus = [
                                        'id' => ['0', '1', '2', '3'],
                                        'nombre' => ['Inactiva', 'Inactiva por falta de pago', 'Activa', 'Suspendida'],
                                    ];
                                @endphp

                                <td data-columna-nombre="status">{{ $arrEmpresaStatus['nombre'][(int) $empresa->id_empresa_status] }}</td>

                                <td>
                                    <div class="d-flex align-items-center justify-content-center gap-10">
                                        <a type="button" class="btn btn-primary" href="{{ route('empresas.edit', $empresa->id) }}">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>

                                        @if ((int) $empresa->id_empresa_status !== 2)
                                            <button type="button" class="btn btn-warning" data-empresa-id="{{ $empresa->id }}" onclick="modalActivarEmpresa(event)">
                                                <i class="fas fa-user-check"></i>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-danger" data-empresa-id="{{ $empresa->id }}" onclick="modalDesactivarEmpresa(event)">
                                                <i class="fas fa-ban me-3"></i>
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
                            <th>Nombre comercial</th>
                            <th>Razón social</th>
                            <th>Tel. oficina</th>
                            <th>Tel. celular</th>
                            <th>RFC</th>
                            <th>Fecha de alta</th>
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
        function modalActivarEmpresa(event) {
            const btnTarget = event.currentTarget;
            const idEmpresa = btnTarget.getAttribute("data-empresa-id");
            const fila = document.getElementById("empresa-id-" + idEmpresa);
            const celda = fila.querySelector("td[data-columna-nombre=status]");

            const numeroEmpresasActivas = document.getElementById("numero-empresas-activas");
            const numeroEmpresasInactivas = document.getElementById("numero-empresas-inactivas");

            Swal.fire({
                title: 'Activar empresa?',
                input: 'text',
                text: "Esta seguro de continuar? Escriba la palabra ACTIVAR en la entrada de texto y luego pulse el botón para activar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Activar empresa',
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
                    Swal.fire({
                        title: 'Empresa activada!',
                        icon: 'success'
                    });

                    const formulario = new FormData();
                    formulario.append("id_empresa_status", "2");
                    formulario.append("_method", "PATCH");
                    formulario.append("_token", "{{ csrf_token() }}");

                    fetch("{{ route('empresas.index') }}" + "/" + idEmpresa, {
                            method: "POST",
                            body: formulario
                        })
                        .then(res => res.json())
                        .then(data => {
                            // Actualizamos el numero de empresas activas
                            numeroEmpresasActivas.textContent = Number(numeroEmpresasActivas.textContent) + 1;

                            // Actualizamos el numero de empresas activas
                            numeroEmpresasInactivas.textContent = Number(numeroEmpresasInactivas.textContent) - 1;

                            // Actualizamos el texto del status del registro en el listado
                            const table = $('#dataTableEmpresas').DataTable();
                            const cell = table.cell(celda);
                            cell.data("Activa").draw();

                            // Actualizamos el boton para cambiar el status
                            const btnTargetParentElement = btnTarget.parentElement;
                            btnTargetParentElement.removeChild(btnTarget);

                            btnTargetParentElement.innerHTML += `
                            <button type="button" class="btn btn-danger" data-empresa-id="${idEmpresa}" onclick="modalDesactivarEmpresa(event)">
                                <i class="fas fa-ban me-3"></i>
                            </button>
                            `;

                            const cellBtns = table.cell(btnTargetParentElement.parentElement);
                            cellBtns.data(btnTargetParentElement.parentElement.innerHTML).draw();
                        });
                }
            });
        };

        function modalDesactivarEmpresa(event) {
            const btnTarget = event.currentTarget;
            const idEmpresa = btnTarget.getAttribute("data-empresa-id");
            const fila = document.getElementById("empresa-id-" + idEmpresa);
            const celda = fila.querySelector("td[data-columna-nombre=status]");

            const numeroEmpresasActivas = document.getElementById("numero-empresas-activas");
            const numeroEmpresasInactivas = document.getElementById("numero-empresas-inactivas");

            Swal.fire({
                title: 'Desactivar empresa?',
                input: 'text',
                text: "Esta seguro de continuar? Escriba la palabra DESACTIVAR en la entrada de texto y luego pulse el botón para desactivar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Desactivar empresa',
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
                    Swal.fire({
                        title: 'Empresa inactiva!',
                        icon: 'success'
                    });

                    const formulario = new FormData();
                    formulario.append("id_empresa_status", "0");
                    formulario.append("_method", "PATCH");
                    formulario.append("_token", "{{ csrf_token() }}");

                    fetch("{{ route('empresas.index') }}" + "/" + idEmpresa, {
                            method: "POST",
                            body: formulario
                        })
                        .then(res => res.json())
                        .then(data => {
                            // Actualizamos el numero de empresas activas
                            numeroEmpresasActivas.textContent = Number(numeroEmpresasActivas.textContent) - 1;

                            // Actualizamos el numero de empresas activas
                            numeroEmpresasInactivas.textContent = Number(numeroEmpresasInactivas.textContent) + 1;

                            // Actualizamos el texto del status del registro en el listado
                            const table = $('#dataTableEmpresas').DataTable();
                            const cell = table.cell(celda);
                            cell.data("Inactiva").draw();

                            // Actualizamos el boton para cambiar el status
                            const btnTargetParentElement = btnTarget.parentElement;
                            btnTargetParentElement.removeChild(btnTarget);
                            btnTargetParentElement.innerHTML += `
                            <button type="button" class="btn btn-warning" data-empresa-id="${idEmpresa}" onclick="modalActivarEmpresa(event)">
                                <i class="fas fa-user-check"></i>
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
                if ($.fn.dataTable.isDataTable('#dataTableEmpresas')) {
                    let table = $('#dataTableEmpresas').DataTable();
                    table.destroy();
                }

                let table = $('#dataTableEmpresas').DataTable({
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
                }).buttons().container().appendTo('#dataTableEmpresas_wrapper .col-md-6:eq(0)');
            })
        })();
    </script>
@stop
