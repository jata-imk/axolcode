@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Agregar promoción')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Agregar promoción</h1>
@stop

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
        </div>

        <div class="card-body">
            <form id="form-agregar-promocion" action="{{ route('promociones.store') }}" method="post">
                @csrf

                <div class="row form-title-section mb-2">
                    <i class="fas fa-comments-dollar"></i>
                    <h6>Datos de la promoción</h6>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Nombre de la promoción</label>
                            <input type="text" name="nombre" class="form-control" placeholder="Ejemplo: 10% de Descuento" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>¿Se aplica descuento?</label>
                            <select class="form-control" name="descuento" id="aplicaDescuento" style="width: 100%;">
                                <option value="0" selected>No</option>
                                <option value="1">Sí</option>
                            </select>
                        </div>
                    </div>

                    <div id="tipoDescuento" class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Tipo de descuento</label>
                            <select id="tipo_descuento" class="form-control" name="tipo_descuento" style="width: 100%;" required>
                                <option value="" selected disabled hidden> -- Selecciona una opción</option>
                                <option value="1">Porcentaje</option>
                                <option value="2">Monto</option>
                            </select>
                        </div>
                    </div>

                    <div id="valorDescuento" class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Valor del descuento</label>
                            <input id="valor_promocion" type="number" name="valor_promocion" class="form-control" min="0" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Descripción de la promoción</label>
                            <textarea name="descripcion" class="form-control" placeholder="Agrega una descripción de la promoción" style="height: 100px" required></textarea>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>¿Publicar en el sitio web?</label>
                            <select class="form-control" name="publicar" style="width: 100%;">
                                <option value="0" selected>No</option>
                                <option value="1">Sí</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button form="form-agregar-promocion" class="btn btn-primary mx-3" type="submit">
                <i class="fas fa-pencil-alt"></i>
                &nbsp;Agregar promoción
            </button>

            <a href="{{ route('promociones.index') }}" class="btn btn-danger" type="button">
                <i class="fas fa-times-circle"></i>
                &nbsp;Cancelar
            </a>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
@stop

@section('js')
    <script>
        $( document ).ready(function() {
            function handleChangeSelectAplicaDescuento(value) {
                if (parseInt(value) === 0) {
                    $("#tipoDescuento").hide();
                    $("#tipo_descuento").prop('required', false);
                    $("#tipo_descuento").prop('disabled', true);

                    $("#valorDescuento").hide();
                    $("#valor_promocion").prop('required', false);
                    $("#valor_promocion").prop('disabled', true);
                } else {
                    $("#tipoDescuento").show();
                    $("#tipo_descuento").prop('required', true);
                    $("#tipo_descuento").prop('disabled', false);

                    $("#valorDescuento").show();
                    $("#valor_promocion").prop('required', true);
                    $("#valor_promocion").prop('disabled', false);
                }
            }
            $("#aplicaDescuento").change(function() {
                const opcion = $(this).val();

                handleChangeSelectAplicaDescuento(opcion);
            });

            handleChangeSelectAplicaDescuento($("#aplicaDescuento").val());
        });
    </script>
@stop
