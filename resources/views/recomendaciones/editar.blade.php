@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Editar recomendación')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Editar recomendación</h1>
@stop

@section('content')
    <div class="row mb-2">
        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label class="col-form-label">
                    <i class="fas fa-info-circle"></i>&nbsp;
                    Fecha de creación
                </label>
                <input type="datetime-local" class="form-control form-control-sm" value="{{ $recomendacion->created_at }}" disabled>
            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label class="col-form-label">
                    <i class="fas fa-info-circle"></i>&nbsp;
                    Ultima actualización
                </label>
                <input type="datetime-local" class="form-control form-control-sm" value="{{ $recomendacion->updated_at }}" disabled>
            </div>
        </div>
    </div>

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
        </div>

        <div class="card-body">
            <form id="form-agregar-editar" action="{{ route('recomendaciones.update', $recomendacion->id) }}" method="post">
                @csrf
                @method('put')

                <div class="row form-title-section mb-2">
                    <i class="fas fa-universal-access"></i>
                    <h6>Datos de la recomendación</h6>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ingresar nombre" value="{{ $recomendacion->nombre }}" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="descripcion">Descripción <small>(Opcional)</small></label>
                            <textarea type="text" id="descripcion" name="descripcion" class="form-control" placeholder="Ingresar descripción..." style="height: 100px">{{ $recomendacion->descripcion }}</textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button form="form-agregar-editar" class="btn btn-primary mx-3" type="submit">
                <i class="fas fa-pencil-alt"></i>
                &nbsp;Actualizar recomendación
            </button>

            <a href="{{ route('recomendaciones.index') }}" class="btn btn-danger">
                <i class="fas fa-times-circle"></i>
                &nbsp;Cancelar
            </a>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
@stop
