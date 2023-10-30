@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Afiliados')

@section('content')
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total de Afiliados</span>
                    <span class="info-box-number" id="cantidad-afiliados">
                    {{count($afiliados)}}
                    </span>
                </div>

            </div>

        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fa fa-check-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Afiliados Activos</span>
                    <span class="info-box-number" id="afiliados-activos">{{$activos}}</span>
                </div>

            </div>

        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-times-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Afiliados Inactivos</span>
                    <span class="info-box-number" id="afiliados-inactivos">{{$inactivos}}</span>
                </div>

            </div>

        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3 text-center">
                <a type="button" href="{{route('afiliados.create')}}" class="btn btn-primary w-100 btn-lg d-flex justify-content-center align-items-center gap-10">
                    <i class="fa fa-plus" ></i>
                    Agregar nuevo Afiliado
                </a>
            </div>
        </div>

        <div class="card col-12">
            @if (session('message'))
                <div id="mensajepersonalizado" class="alert alert-default-success mt-2 alert-dismissible fade show" role="alert">{{ session('message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card-header">
                <h3 class="card-title">Listado de afiliados</h3>
            </div>

            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="dataTableAfiliados" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 5px">#</th>
                                <th>Nombre Comercial</th>
                                <th>Nombre Fiscal</th>
                                <th>Contacto</th>
                                <th>RFC</th>
                                <th>Sitio web</th>
                                <th>Tel.</th>
                                <th>Tel. cel.</th>
                                <th>Compras realizadas</th>
                                <th>Estatus</th>
                                <th colspan="1"></th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($afiliados as $afiliado)
                                <tr class="odd" id="afiliado-id-{{ $afiliado->id }}">
                                    <td class="dtr-control sorting_1" tabindex="0">1</td>
                                    <td>
                                        {{$afiliado->nombre_comercial}}
                                        <br>
                                        <small>Registrado el: {{date("d-m-Y",strtotime("$afiliado->created_at"))}}</small>
                                    </td>
                                    <td>{{$afiliado->razon_social}}</td>
                                    <td>{{$afiliado->nombre_contacto}} {{$afiliado->apellido_contacto}}</td>
                                    <td>{{$afiliado->rfc}}</td>
                                    <td>{{$afiliado->url}}</td>
                                    <td>
                                        <div class="iti" style="width: 35px; vertical-align: middle;">
                                            <div class="iti__flag-container" style="left: 0; right: unset;">
                                                <div class="iti__selected-flag">
                                                    <div class="iti__flag iti__{{ strtolower($afiliado->telefono_oficina_iso_pais) }}"></div>
                                                </div>
                                            </div>
                                        </div>
                                        {{$afiliado->telefono_oficina}}
                                    </td>
                                    <td>
                                        <div class="iti" style="width: 35px; vertical-align: middle;">
                                            <div class="iti__flag-container" style="left: 0; right: unset;">
                                                <div class="iti__selected-flag">
                                                    <div class="iti__flag iti__{{ strtolower($afiliado->telefono_celular_iso_pais) }}"></div>
                                                </div>
                                            </div>
                                        </div>
                                        {{$afiliado->telefono_celular}}
                                    </td>
                                    <td>{{$afiliado->compras_realizadas}}</td>
                                    <td>
                                        @if ($afiliado->estatus == '0')
                                            <span class="text-danger">Inactivo <i class="fas fa-times-circle"></i></span>
                                        @else
                                            <span class="text-success">Activo <i class="fas fa-check-circle"></i></span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center gap-10">
                                            <a type="button" class="btn btn-primary" href="{{route('afiliados.edit', $afiliado->id)}}">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            @if ($afiliado->estatus == '1')
                                            <button type="button" class="btn btn-danger" data-afiliado-id="{{$afiliado->id}}" onclick="modalEliminarDistintivo(event)">
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
                                    <th style="width: 5px">#</th>
                                    <th>Nombre Comercial</th>
                                    <th>Nombre Fiscal</th>
                                    <th>Contacto</th>
                                    <th>RFC</th>
                                    <th>Sitio web</th>
                                    <th>Tel.</th>
                                    <th>Tel. cel.</th>
                                    <th>Compras realizadas</th>
                                    <th>Estatus</th>
                                    <th colspan="1"></th>
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
            const idAfiliado = btnTarget.getAttribute("data-afiliado-id");
            const fila = document.getElementById("afiliado-id-" + idAfiliado);
            const cantidadAfiliados = document.getElementById("cantidad-afiliados");
            const cantidadAfiliadosActivos = document.getElementById("afiliados-activos");
            const cantidadAfiliadosInactivos = document.getElementById("afiliados-inactivos");


            Swal.fire({
                title: 'Eliminar afiliado?',
                input: 'text',
                text: "Esta seguro de continuar? Escriba la palabra ELIMINAR en la entrada de texto y luego pulse el botón para eliminar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar afiliado',
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
                        title: 'Afiliado eliminado!',
                        icon: 'success'
                    });

                    const formulario = new FormData();
                    formulario.append("_method", "DELETE");
                    formulario.append("_token", "{{csrf_token()}}");

                    fetch("{{ route('afiliados.index') }}" + "/" + idAfiliado, {
                            method: "POST",
                            body: formulario
                        })
                        .then(data => {
                            // Actualizamos el numero de tipo de tours
                            //cantidadAfiliados.textContent = Number(cantidadAfiliados.textContent) - 1;
                            $("#afiliados-activos").html(Number(cantidadAfiliadosActivos.textContent) - 1);
                            $("#afiliados-inactivos").html(Number(cantidadAfiliadosInactivos.textContent) + 1);
                            //fila.remove();

                            $("#afiliado-id-"+idAfiliado+" .text-success").removeClass("text-success").addClass("text-danger").html('Inactivo <i class="fas fa-times-circle"></i>');
                            $("#afiliado-id-"+idAfiliado+" .btn-danger").remove();
                        });
                }
            });
        };

        (function() {
            const meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
            const dias_semana = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];

            const tiempoTranscurrido = Date.now();
            const hoy = new Date(tiempoTranscurrido);

            const fecha = dias_semana[hoy.getDay()] + ', ' + hoy.getDate() + ' de ' + meses[hoy.getMonth()] + ' de ' + hoy.getUTCFullYear()

            document.addEventListener("DOMContentLoaded", function() {
                if ($.fn.dataTable.isDataTable('#dataTableAfiliados')) {
                    let table = $('#dataTableAfiliados').DataTable();
                    table.destroy();
                }

                let table = $('#dataTableAfiliados').DataTable({
                    "order": [
                        [0, 'desc']
                    ],
                    "buttons": [
                        "excel",
                        {
                            extend: 'pdfHtml5',
                            orientation: 'landscape',
                            pageSize: 'LETTER',
                            footer: true,
                            customize: function(doc) {
                                doc['footer'] = (function(page, pages) {
                                    return {
                                        columns: [{
                                                // This is the right column
                                                alignment: 'left',
                                                fontSize: 8,
                                                text: 'Elaborado con CloudTravel',
                                                margin: [0, 10]
                                            },
                                            {
                                                // This is the right column
                                                alignment: 'right',
                                                text: ['Página ', {
                                                    text: page.toString()
                                                }, ' de ', {
                                                    text: pages.toString()
                                                }],
                                            }
                                        ],
                                        margin: [10, 0]
                                    }
                                });

                                doc['header'] = (function(page, pages) {
                                    return {
                                        columns: [{
                                                // 'This is your left footer column',
                                                alignment: 'left',
                                                text: '{{ $laempresa->nombre_comercial }}',
                                                margin: [0, 10]
                                            },
                                            {
                                                // This is the right column
                                                alignment: 'right',
                                                text: fecha,
                                                margin: [0, 10]
                                            }
                                        ],
                                        margin: [30, 0]
                                    }
                                });
                            }
                        },
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
                }).buttons().container().appendTo('#dataTableAfiliados_wrapper .col-md-6:eq(0)');
            })
        })();
    </script>
@stop
