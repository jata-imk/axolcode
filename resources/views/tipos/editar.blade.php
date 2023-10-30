@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Editar tipo de excursión')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Editar tipo de excursión</h1>
@stop

@section('content')
    <div class="row mb-2">
        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label class="col-form-label">
                    <i class="fas fa-info-circle"></i>&nbsp;
                    Fecha de creación
                </label>
                <input type="datetime-local" class="form-control form-control-sm" value="{{ $tipoTour->created_at }}" disabled>
            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label class="col-form-label">
                    <i class="fas fa-info-circle"></i>&nbsp;
                    Ultima actualización
                </label>
                <input type="datetime-local" class="form-control form-control-sm" value="{{ $tipoTour->updated_at }}" disabled>
            </div>
        </div>
    </div>

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
        </div>

        <div class="card-body">
            <form id="form-editar-tipo-tour" action="{{ route('tipos.update', $tipoTour->id) }}" method="post">
                @csrf
                @method('put')

                <div class="row form-title-section mb-2">
                    <i class="fas fa-umbrella-beach"></i>
                    <h6>Datos del tipo de excursión</h6>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="{{ $tipoTour->nombre }}" placeholder="Ingresar nombre" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-floating">
                            <label>Descripción del tipo de excursión</label>
                            <textarea name="descripcion" class="form-control" placeholder="Agregar una descripción del tipo de excursión" style="height: 100px" required>{{ $tipoTour->descripcion }}</textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button form="form-editar-tipo-tour" class="btn btn-primary mx-3" type="submit">
                <i class="fas fa-pencil-alt"></i>
                &nbsp;Editar tipo de excursión
            </button>

            <a href="{{ route('tipos.index') }}" class="btn btn-danger">
                <i class="fas fa-times-circle"></i>
                &nbsp;Cancelar
            </a>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
@stop
