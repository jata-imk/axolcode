@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Editar moneda')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Editar moneda</h1>
@stop

@section('content')
    <div class="row mb-2">
        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label class="col-form-label">
                    <i class="fas fa-info-circle"></i>&nbsp;
                    Fecha de creación
                </label>
                <input type="datetime-local" class="form-control form-control-sm" value="{{ $moneda->created_at }}" disabled>
            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label class="col-form-label">
                    <i class="fas fa-info-circle"></i>&nbsp;
                    Ultima actualización
                </label>
                <input type="datetime-local" class="form-control form-control-sm" value="{{ $moneda->updated_at }}"
                    disabled>
            </div>
        </div>
    </div>

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
        </div>

        <div class="card-body">
            <form id="form-editar-moneda" action="{{ route('monedas.update', $moneda->id) }}" method="post">
                <input type="hidden" name="idMoneda" value="{{ $moneda->id }}" />
                @csrf

                @method('put')

                <div class="row form-title-section mb-2">
                    <i class="fas fa-coins"></i>
                    <h6>Datos de la <span class="text-info">moneda</span></h6>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" value="{{ $moneda->nombre }}"
                                placeholder="Ingresar nombre de la moneda" required >
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="iso">ISO</label>
                            <input type="text" id="iso" name="iso" class="form-control" value="{{ $moneda->iso }}"
                                placeholder="Ejemplo: MXN" required>
                            <small class="form-text text-muted">
                                Códigos de tres letras para todas las divisas del mundo.
                            </small>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="tipo_cambio">Tipo de cambio</label>
                            <input type="number" step="any" id="tipo_cambio" name="tipo_cambio" class="form-control" value="{{ $moneda->tipo_cambio }}"
                                placeholder="Escriba el tipo de cambio" required>
                            <small class="form-text text-muted">
                                El tipo de cambio se calcula respecto al peso mexicano (MXN).
                            </small>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button form="form-editar-moneda" class="btn btn-primary mx-3" type="submit">
                <i class="fas fa-pencil-alt"></i>
                &nbsp;Editar moneda
            </button>

            <a href="{{ route('monedas.index') }}" class="btn btn-danger">
                <i class="fas fa-times-circle"></i>
                &nbsp;Cancelar
            </a>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
@stop
