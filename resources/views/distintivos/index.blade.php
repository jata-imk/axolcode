@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Distintivos')

@section('content')
    <div class="row pt-2">
        <div class="col-12 col-sm-6 col-md-3">

        </div>

        <div class="col-12 col-sm-6 col-md-3">

        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Distintivos</span>
                    <span id="cantidad-distintivos" class="info-box-number">
                    {{$cdistintivos}}
                    </span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3 text-center">
                <a type="button" href="{{route('distintivos.create')}}" class="btn btn-primary w-100 btn-lg d-flex justify-content-center align-items-center gap-10">
                    <i class="fa fa-plus" ></i>
                    Agregar distintivo
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
                <h3 class="card-title">Listado de distintivos</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="dataTableDistintivos" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Logo</th>
                                <th>Enlace</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($distintivos as $distintivo)
                                <tr id="distintivo-id-{{ $distintivo->id }}">
                                    <td>{{$distintivo->id}}</td>
                                    <td>{{$distintivo->nombre}}</td>
                                    <td class="text-center">
                                        <img class="text-center" style="width: 165px !important;" src="storage/{{ $distintivo->logo }}" />
                                    </td>
                                    <td>
                                        @if ($distintivo->link)
                                            <a href="{{$distintivo->link}}" target="_blank"><i class="fas fa-link"></i> Abrir enlace</a>
                                        @else
                                            <i class="fas fa-unlink"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center gap-10">
                                            <a type="button" class="btn btn-primary" href="{{route('distintivos.edit', $distintivo->id)}}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger" data-distintivo-id="{{$distintivo->id}}" onclick="modalEliminarDistintivo(event)">
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
                                    <th>Nombre</th>
                                    <th>Logo</th>
                                    <th>Enlace</th>
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

@section('plugins.Sweetalert2', true)
@section('plugins.Datatables_Buttons', true)

@section('css')
    <link rel="stylesheet" href={{ asset("/assets/css/admin_custom.css") }}>
@stop

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

        function modalEliminarDistintivo(event) {
            const btnTarget = event.currentTarget;
            const idDistintivo = btnTarget.getAttribute("data-distintivo-id");
            const fila = document.getElementById("distintivo-id-" + idDistintivo);
            const cantidadDistintivos = document.getElementById("cantidad-distintivos");

            Swal.fire({
                title: 'Eliminar distintivo?',
                input: 'text',
                text: "Esta seguro de continuar? Escriba la palabra ELIMINAR en la entrada de texto y luego pulse el botón para eliminar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar distintivo',
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
                        title: 'Distintivo eliminado!',
                        icon: 'success'
                    });

                    const formulario = new FormData();
                    formulario.append("_method", "DELETE");
                    formulario.append("_token", "{{csrf_token()}}");

                    fetch("{{ route('distintivos.index') }}" + "/" + idDistintivo, {
                            method: "POST",
                            body: formulario
                        })
                        .then(data => {
                            // Actualizamos el numero de tipo de tours
                            cantidadDistintivos.textContent = Number(cantidadDistintivos.textContent) - 1;
                            fila.remove();
                        });
                }
            });
        };

        (function() {
            document.addEventListener("DOMContentLoaded", function() {
                if ($.fn.dataTable.isDataTable('#dataTableDistintivos')) {
                    let table = $('#dataTableDistintivos').DataTable();
                    table.destroy();
                }

                let table = $('#dataTableDistintivos').DataTable({
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
                }).buttons().container().appendTo('#dataTableDistintivos_wrapper .col-md-6:eq(0)');
            })
        })();
    </script>
@stop



