@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Clientes')

@section('content')
    <div class="row pt-2">
        <div class="col-12 col-sm-6 col-md-3">

        </div>

        <div class="col-12 col-sm-6 col-md-3">

        </div>

        @cannot('create', App\Models\Clientes\Cliente::class)
        <div class="col-12 col-sm-6 col-md-3">

        </div>
        @endcannot

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total de Clientes</span>
                    <span id="cantidad-clientes" class="info-box-number">
                    {{$cclientes}}
                    </span>
                </div>
            </div>
        </div>

        @can('create', App\Models\Clientes\Cliente::class)
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box text-center">
                <a type="button" href="{{route('clientes.create')}}" class="btn btn-primary w-100 btn-lg d-flex justify-content-center align-items-center gap-10">
                    <i class="fa fa-plus" ></i>
                    Agregar cliente
                </a>
            </div>
        </div>
        @endcan

        <div class="card col-12">
            @if(session('message'))
                <div id="mensajepersonalizado" class="alert alert-default-success mt-2 alert-dismissible fade show" role="alert">{{session('message')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card-header">
                <h3 class="card-title">Listado de clientes</h3>
            </div>
            
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="dataTableClientes" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre&nbsp;completo</th>
                                <th>Teléfono&nbsp;Celular</th>
                                <th>Teléfono&nbsp;Casa</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($clientes as $cliente)
                                <tr class="{{$cliente->id_status == '' ? 'text-danger':''}}" id="cliente-id-{{ $cliente->id }}">
                                    <td>{{$cliente->id}}</td>
                                    <td>
                                        <a>{{$cliente->nombre}} {{$cliente->apellido}}</a>
                                        <br>
                                        <small>Registrado el: {{date("d-m-Y",strtotime("$cliente->created_at"))}}</small>
                                        
                                    </td>
                                    <td>
                                        <div class="iti" style="width: 35px; vertical-align: middle;">
                                            <div class="iti__flag-container" style="left: 0; right: unset;">
                                                <div class="iti__selected-flag">
                                                    <div class="iti__flag iti__{{ strtolower($cliente->telefono_celular_iso_pais) }}"></div>
                                                </div>
                                            </div>

                                        </div>
                                        {{$cliente->telefono_celular}}
                                    </td>
                                    <td>
                                        @if ($cliente->telefono_casa == "")
                                        <span class="text-muted font-italic">No especificado</span>
                                        @else
                                        <div class="iti" style="width: 35px; vertical-align: middle;">
                                            <div class="iti__flag-container" style="left: 0; right: unset;">
                                                <div class="iti__selected-flag">
                                                    <div class="iti__flag iti__{{ strtolower($cliente->telefono_casa_iso_pais) }}"></div>
                                                </div>
                                            </div>

                                        </div>
                                        {{$cliente->telefono_casa}}
                                        @endif
                                    </td>
                                    <td>
                                        <a>{{$cliente->email_principal}}</a>
                                        <br>
                                        <small>Secundario: 
                                            @if ($cliente->email_secundario == "")
                                            <span class="text-muted font-italic">No especificado</span>
                                            @else
                                            {{$cliente->email_secundario}}
                                            @endif
                                        </small>
                                    </td>
                                    <td>
                                        @php
                                            $columnStatusClientes = array_column($statusClientes->toArray(), "id");
                                            $searchId = array_search($cliente->id_status, $columnStatusClientes);
                                        @endphp

                                        <span class="badge" style="color:{{$statusClientes[$searchId]->color}}; background-color: {{$statusClientes[$searchId]->background_color}};">{{$statusClientes[$searchId]->descripcion}}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center gap-10">
                                            <a type="button" class="btn btn-primary" href="{{route('clientes.edit', $cliente->id)}}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger" data-cliente-id="{{$cliente->id}}" onclick="modalEliminarCliente(event)">
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
                                    <th>Nombre&nbsp;completo</th>
                                    <th>Teléfono&nbsp;Celular</th>
                                    <th>Teléfono&nbsp;Casa</th>
                                    <th>Email</th>
                                    <th>Status</th>
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
    <link rel="stylesheet" href={{ asset("/assets/plugins/intlTelInput/css/intlTelInput.min.css") }}>
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
            const idCliente = btnTarget.getAttribute("data-cliente-id");
            const fila = document.getElementById("cliente-id-" + idCliente);
            const cantidadClientes = document.getElementById("cantidad-clientes");

            Swal.fire({
                title: 'Eliminar cliente?',
                input: 'text',
                text: "Esta seguro de continuar? Escriba la palabra ELIMINAR en la entrada de texto y luego pulse el botón para eliminar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar cliente',
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

                        return fetch("{{ route('clientes.index') }}" + "/" + idCliente, {
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
                        // Actualizamos el numero de clientes
                        cantidadClientes.textContent = Number(cantidadClientes.textContent) - 1;
                        fila.remove();

                        Swal.fire({
                            title: 'Cliente eliminado!',
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
                if ($.fn.dataTable.isDataTable('#dataTableClientes')) {
                    let table = $('#dataTableClientes').DataTable();
                    table.destroy();
                }

                let table = $('#dataTableClientes').DataTable({
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
                }).buttons().container().appendTo('#dataTableClientes_wrapper .col-md-6:eq(0)');
            })
        })();
    </script>
@stop
