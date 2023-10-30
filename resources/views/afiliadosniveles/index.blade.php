@php
    $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
@endphp

@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Niveles de afiliados')

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
                    <span class="info-box-text">Total de niveles</span>
                    <span id="cantidad-niveles" class="info-box-number">
                    {{$cniveles}}
                    </span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3 text-center">
                <a type="button" href="{{route('nivelafiliacion.create')}}" class="btn btn-primary w-100 btn-lg d-flex justify-content-center align-items-center gap-10">
                    <i class="fa fa-plus" ></i>
                    Agregar nivel
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
                <h3 class="card-title">Listado de niveles</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="dataTableNiveles" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Comisión</th>
                                <th>Fecha alta</th>
                                <th>Ultimo cambio</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($niveles as $nivel)
                                <tr id="niveles-id-{{ $nivel->id }}">
                                    <td>{{$nivel->id}}</td>
                                    <td>{{$nivel->nombre}}</td>
                                    <td>{{$nivel->comision}} %</td>

                                    @php
                                        [$timestampFechaAlta, $timestampHoraAlta] = explode(' ', $nivel->created_at);
                                        [$anioAlta, $mesAlta, $diaAlta] = explode('-', $timestampFechaAlta);
                                    @endphp
                                    <td>
                                        {{ $diaAlta . " de " . $meses[date("n", mktime(0, 0, 0, $mesAlta, $diaAlta, $anioAlta)) - 1] . " del " . $anioAlta }}
                                        <br>
                                        <small>Hora: {{ $timestampHoraAlta }}</small>
                                    </td>

                                    @php
                                        [$timestampFechaModificacion, $timestampHoraModificacion] = explode(' ', $nivel->updated_at);
                                        [$anioModificacion, $mesModificacion, $diaModificacion] = explode('-', $timestampFechaModificacion);
                                    @endphp
                                    <td>
                                        {{ $diaModificacion . " de " . $meses[date("n", mktime(0, 0, 0, $mesModificacion, $diaModificacion, $anioModificacion)) - 1] . " del " . $anioModificacion }}
                                        <br>
                                        <small>Hora: {{ $timestampHoraModificacion }}</small>
                                    </td>

                                    <td>
                                        <div class="d-flex align-items-center justify-content-center gap-10">
                                            <a type="button" class="btn btn-primary" href="{{route('nivelafiliacion.edit', $nivel->id)}}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger" data-nivel-id="{{$nivel->id}}" onclick="modalEliminarNivelAfiliado(event)">
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
                                    <th>Descripción</th>
                                    <th>Fecha alta</th>
                                    <th>Ultimo cambio</th>
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

        function modalEliminarNivelAfiliado(event) {
            const btnTarget = event.currentTarget;
            const idNivel = btnTarget.getAttribute("data-nivel-id");
            const fila = document.getElementById("niveles-id-" + idNivel);
            const cantidadNiveles = document.getElementById("cantidad-niveles");

            Swal.fire({
                title: 'Eliminar nivel?',
                input: 'text',
                text: "Esta seguro de continuar? Escriba la palabra ELIMINAR en la entrada de texto y luego pulse el botón para eliminar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar nivel',
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
                        title: 'Nivel eliminado!',
                        icon: 'success'
                    });

                    const formulario = new FormData();
                    formulario.append("_method", "DELETE");
                    formulario.append("_token", "{{csrf_token()}}");

                    fetch("{{ route('nivelafiliacion.index') }}" + "/" + idNivel, {
                            method: "POST",
                            body: formulario
                        })
                        .then(data => {
                            // Actualizamos el numero de tipo de tours
                            cantidadNiveles.textContent = Number(cantidadNiveles.textContent) - 1;
                            fila.remove();
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

