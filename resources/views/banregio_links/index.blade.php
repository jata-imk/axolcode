@php
    $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
@endphp

@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Links de pago Banregio')

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
                    <span class="info-box-text">Cantidad de links</span>
                    <span id="cantidad-terminales" class="info-box-number">
                    {{count($links)}}
                    </span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3 text-center">
                <a type="button" href="{{route('banregiolinks.create')}}" class="btn btn-primary w-100 btn-lg d-flex justify-content-center align-items-center gap-10">
                    <i class="fa fa-plus" ></i>
                    Agregar link
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
                <h3 class="card-title">Listado de links de cobro</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="dataTableNiveles" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Fecha alta</th>
                                <th>Estatus</th>
                                <th>Monto</th>
                                <th>Cliente</th>
                                <th>Forma de pago</th>
                                <th>Link de pago</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($links as $link)
                                <tr id="fila-id-{{ $link->id }}">
                                    <td>{{$link->id}}</td>
                                    @php
                                        [$timestampFechaAlta, $timestampHoraAlta] = explode(' ', $link->created_at);
                                        [$anioAlta, $mesAlta, $diaAlta] = explode('-', $timestampFechaAlta);
                                    @endphp
                                    <td>
                                        {{ $diaAlta . " de " . $meses[date("n", mktime(0, 0, 0, $mesAlta, $diaAlta, $anioAlta)) - 1] . " del " . $anioAlta }}
                                        <br>
                                        <small>Hora: {{ $timestampHoraAlta }}</small>
                                    </td>
                                    <td>
                                        @if ($link->respuesta == '0')
                                            <span class="text-info">Sin uso<i class="fas fa-clock"></i></span>
                                        @elseif ($link->respuesta == '1')
                                            <span class="text-danger">Rechazado <i class="fas fa-times-circle"></i></span>
                                        @else
                                            <span class="text-success">Aceptado <i class="fas fa-check-circle"></i></span>
                                        @endif
                                    </td>
                                    <td>{{"$ ".number_format($link->monto, 2, '.', ',')}}</td>
                                    <td>{{mb_convert_case($link->nombre_cliente, MB_CASE_TITLE, "UTF-8")}}</td>
                                    <td>
                                        @if ($link->meses > 1)
                                            {{$link->meses." MSI"}}
                                        @else
                                            1 sola exhibición
                                        @endif
                                    </td>
                                    <td>{{$web[0]->pagina_web}}/online-pay?register={{$link->link}}</td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center gap-10">
                                            @if ($link->respuesta == '0')
                                                <a type="button" class="btn btn-primary" href="{{route('banregiolinks.edit', $link->id)}}">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                            @endif

                                            @if ($link->respuesta == '0' or $link->respuesta == '1')
                                                <button type="button" class="btn btn-danger" data-terminal-id="{{$link->id}}" onclick="modalEliminar(event)">
                                                    <i class="fas fa-trash me-3"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Fecha alta</th>
                                    <th>Estatus</th>
                                    <th>Monto</th>
                                    <th>Cliente</th>
                                    <th>Forma de pago</th>
                                    <th>Link de pago</th>
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

