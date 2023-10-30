@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Costeos')

@section('content')
    <div class="row pt-2 justify-content-end">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cash-register"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total de costeos</span>
                    <span id="cantidad-excursiones" class="info-box-number">
                        {{ $costeos->count() }}
                    </span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box text-center">
                <a type="button" href="{{ route('costeos.create') }}" class="btn btn-primary w-100 btn-lg d-flex justify-content-center align-items-center gap-10">
                    <i class="fa fa-plus" ></i>
                    Agregar costeo
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @if (session('message'))
                <div id="mensajepersonalizado" class="alert alert-default-success mt-2 alert-dismissible fade show" role="alert">{{ session('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de costeos</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="dataTableCosteos" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre y descripción</th>
                                        <th>Restricciones</th>
                                        <th>Detalles</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($costeos as $costeo)
                                        <tr id="costeo-id-{{ $costeo->id }}">
                                            <td>{{ $costeo->id }}</td>
                                            <td>{{ $costeo->nombre }}</td>
                                            <td>No hay restricciones</td>
                                            <td>
                                                {{ $costeo->campos_count }} Campos y {{ $costeo->condiciones->count() }} condiciones
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center gap-10">
                                                    <a type="button" class="btn btn-primary" href="{{route('costeos.edit', $costeo->id)}}">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre y descripción</th>
                                        <th>Restricciones</th>
                                        <th>Detalles</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
@stop

@section('plugins.Datatables_Buttons', true)
@section('js')
    <script>
        $(document).ready(function(){
            if($("#mensajepersonalizado").length > 0){
                setTimeout(function () {
                    esconderAlerta("mensajepersonalizado");
                }, 3000);
            }
        });

        (function() {
            document.addEventListener("DOMContentLoaded", function() {
                if ($.fn.dataTable.isDataTable('#dataTableCosteos')) {
                    let table = $('#dataTableCosteos').DataTable();
                    table.destroy();
                }

                let table = $('#dataTableCosteos').DataTable({
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
                }).buttons().container().appendTo('#dataTableCosteos_wrapper .col-md-6:eq(0)');
            })
        })();
    </script>
@stop
