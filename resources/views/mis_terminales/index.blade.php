@php
    $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
@endphp

@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Terminales')

@section('content')

    <div class="row pt-2">
        <div class="col-12 col-sm-6 col-md-3"></div>
        <div class="col-12 col-sm-6 col-md-3"></div>
        <div class="col-12 col-sm-6 col-md-3"></div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Cantidad de terminales</span>
                    <span id="cantidad-terminales" class="info-box-number">
                    {{count($terminales)}}
                    </span>
                </div>
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
                <h3 class="card-title">Listado de terminales</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="dataTableNiveles" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Estatus</th>
                                <th>Sitio web</th>
                                <th>Modo</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($terminales as $terminal)
                                <tr id="terminal-id-{{ $terminal->id }}">
                                    <td>{{$terminal->idTerminal}}</td>
                                    <td>{{$terminal->nombre}}</td>
                                    <td>
                                        @if ($terminal->id > 0)
                                            <span class="text-success">Activa <i class="fas fa-check-circle"></i></span>
                                        @else
                                            <span class="text-danger">Inactiva <i class="fas fa-times-circle"></i></span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center gap-10">
                                            @if ($terminal->estatus > 0)
                                                <span class="text-success">Activa <i class="fas fa-check-circle"></i></span>
                                            @else
                                                <span class="text-danger">Inactiva <i class="fas fa-times-circle"></i></span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center gap-10">
                                            @if ($terminal->enviroment == 'prod')
                                                <span class="text-success">En producción <i class="fas fa-check-circle"></i></span>
                                            @else
                                                <span class="text-danger">En modo pruebas <i class="fas fa-times-circle"></i></span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center gap-10">
                                            @if ($terminal->id > 0)
                                                <a type="button" class="btn btn-primary" href="{{route('mis-terminales.edit', $terminal->id)}}">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            @else
                                                <a type="button" class="btn btn-primary" href="{{route('mis-terminales.create', 'id='.$terminal->idTerminal.'&nombre='.$terminal->nombre)}}">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Estatus</th>
                                    <th>Sitio web</th>
                                    <th>Modo</th>
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

        function modalEliminar(event) {
            const btnTarget = event.currentTarget;
            const idTerminal = btnTarget.getAttribute("data-terminal-id");
            const fila = document.getElementById("terminal-id-" + idTerminal);
            const cantidadTerminales = document.getElementById("cantidad-terminales");


            Swal.fire({
                title: 'Eliminar terminal?',
                input: 'text',
                text: "Esta seguro de continuar? Escriba la palabra ELIMINAR en la entrada de texto y luego pulse el botón para eliminar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar terminal',
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
                        title: 'Terminal eliminada!',
                        icon: 'success'
                    });

                    const formulario = new FormData();
                    formulario.append("_method", "DELETE");
                    formulario.append("_token", "{{csrf_token()}}");
                    formulario.append("idterminal", idTerminal);

                    fetch("{{ route('terminales.index') }}" + "/" + idTerminal, {
                            method: "POST",
                            body: formulario
                        })
                        .then(data => {
                            $("#cantidad-terminales").html(Number(cantidadTerminales.textContent) - 1);

                            $("#terminal-id-"+idTerminal+" .text-success").removeClass("text-success").addClass("text-danger").html('Inactivo <i class="fas fa-times-circle"></i>');
                            $("#terminal-id-"+idTerminal+" .btn-danger").remove();
                        });
                }
            });
        };

        (function() {
            document.addEventListener("DOMContentLoaded", function() {
                if ($.fn.dataTable.isDataTable('#dataTableNiveles')) {
                    let table = $('#dataTableNiveles').DataTable();
                    table.destroy();
                }

                let table = $('#dataTableNiveles').DataTable({
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
                }).buttons().container().appendTo('#dataTableNiveles_wrapper .col-md-6:eq(0)');
            })
        })();
    </script>
@stop

