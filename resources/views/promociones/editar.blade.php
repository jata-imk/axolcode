@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Editar promoción')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Editar promoción</h1>
@stop

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
        </div>

        <div class="card-body">
            <form id="form-editar-promocion" @can('update', $promocion) action="{{ route('promociones.update', $promocion->id) }}" method="post" @ENDCAN>
                <input type="hidden" name="id" value="{{ $promocion->id }}" />
                
                @can('update', $promocion)
                    @csrf
                    @method('put')
                @endcan
            
                <div class="row form-title-section mb-2">
                    <i class="fas fa-comments-dollar"></i>
                    <h6>Datos de la promoción</h6>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>Nombre de la promoción</label>
                                <input type="text" name="nombre" class="form-control" value="{{ $promocion->nombre }}" placeholder="Ejemplo: 10% de Descuento">
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>¿Se aplica descuento?</label>
                                <select id="aplicaDescuento" class="form-control" name="descuento" style="width: 100%;">
                                    <option value="1" {{ $promocion->descuento == '1' ? 'selected' : '' }}>Sí</option>
                                    <option value="0" {{ $promocion->descuento == '0' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                        </div>

                        <div id="tipoDescuento" class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>Tipo de descuento</label>
                                <select id="tipo_descuento" class="form-control" name="tipo_descuento" style="width: 100%;" required>
                                    <option value="1" {{ $promocion->tipo_descuento == '1' ? 'selected' : '' }}>Porcentaje</option>
                                    <option value="2" {{ $promocion->tipo_descuento == '2' ? 'selected' : '' }}>Monto</option>
                                </select>
                            </div>
                        </div>

                        <div id="valorDescuento" class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>Valor del descuento</label>
                                <input id="valor_promocion" type="number" name="valor_promocion" class="form-control" min="0" value="{{ $promocion->valor_promocion }}" required>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>Descripción de la promoción</label>
                                <textarea required name="descripcion" class="form-control" placeholder="Agrega una descripción de la promoción" id="groupTextarea2" style="height: 100px">{{ $promocion->descripcion }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>¿Publicar en el sitio web?</label>
                                <select class="form-control" name="publicar" style="width: 100%;">
                                    <option value="0" {{ $promocion->publicar == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ $promocion->publicar == '1' ? 'selected' : '' }}>Sí</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @can('update', $promocion)
        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button form="form-editar-promocion" class="btn btn-primary mx-3" type="submit">
                <i class="fas fa-pencil-alt"></i>
                &nbsp;Editar promoción
            </button>

            <a href="{{ route('promociones.index') }}" class="btn btn-danger" type="button">
                <i class="fas fa-times-circle"></i>
                &nbsp;Cancelar
            </a>
        </div>
        @endcan
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
