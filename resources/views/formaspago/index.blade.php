@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Formas de pago')

@section('content_header')
    <!--<h1 class="my-5">Dashboard listado de Afiliados</h1>-->
@stop

@section('content')

    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Formas de pago</span>
                    <span id="cantidad-formaspago" class="info-box-number">
                    {{$cformasdepago}}
                    </span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3 text-center">
                <a type="button" href="{{route('formaspago.create')}}" class="btn btn-primary w-100 btn-lg d-flex justify-content-center align-items-center gap-10">
                    <i class="fa fa-plus" ></i>
                    Agregar forma de pago
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
                <h3 class="card-title">Listado de formas de pago</h3>
            </div>

            <div class="card-body">
                <div id="dataTableFormasPago_wrapper" class="dataTables_wrapper dt-bootstrap4"></div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="dataTableFormasPago" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 5px">#</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th colspan="1">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($formasdepago as $formapago)
                                <tr class="odd"  id="formapago-id-{{ $formapago->id }}">
                                    <td class="dtr-control sorting_1" tabindex="0">{{$formapago->id}}</td>
                                    <td>{{$formapago->nombre}}</td>
                                    <td>{{$formapago->descripcion}}</td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center gap-10">
                                            <a type="button" class="btn btn-primary" href="{{route('formaspago.edit', $formapago->id)}}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger" data-formapago-id="{{$formapago->id}}" onclick="modalEliminarCliente(event)">
                                                <i class="fas fa-trash me-3"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th style="width: 5px">#</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th colspan="1">Acciones</th>
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
            const idFormaPago = btnTarget.getAttribute("data-formapago-id");
            const fila = document.getElementById("formapago-id-" + idFormaPago);
            const cantidadFormaPago = document.getElementById("cantidad-formaspago");

            Swal.fire({
                title: 'Eliminar forma de pago?',
                input: 'text',
                text: "Esta seguro de continuar? Escriba la palabra ELIMINAR en la entrada de texto y luego pulse el botón para eliminar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar forma de pago',
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
                        title: 'Forma de pago eliminada!',
                        icon: 'success'
                    });

                    const formulario = new FormData();
                    formulario.append("_method", "DELETE");
                    formulario.append("_token", "{{csrf_token()}}");

                    fetch("{{ route('formaspago.index') }}" + "/" + idFormaPago, {
                            method: "POST",
                            body: formulario
                        })
                        .then(data => {
                            // Actualizamos el numero de tipo de tours
                            cantidadFormaPago.textContent = Number(cantidadFormaPago.textContent) - 1;
                            fila.remove();
                        });
                }
            });
        };

        (function() {
            document.addEventListener("DOMContentLoaded", function() {
                if ($.fn.dataTable.isDataTable('#dataTableFormasPago')) {
                    let table = $('#dataTableFormasPago').DataTable();
                    table.destroy();
                }

                let table = $('#dataTableFormasPago').DataTable({
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
                }).buttons().container().appendTo('#dataTableFormasPago_wrapper');
            })
        })();
    </script>
@stop

