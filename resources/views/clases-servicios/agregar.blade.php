@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Agregar clase (Servicio)')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Agregar clase (Servicio)</h1>
@stop

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
        </div>

        <div class="card-body">
            <form id="form-agregar-clase-servicio" action="{{ route('clases-servicios.store') }}" method="post">
                @csrf

                <div class="row form-title-section mb-2">
                    <i class="fas fa-umbrella-beach"></i>
                    <h6>Datos generales</h6>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" class="form-control" placeholder="Ingresar nombre. E.g. Clase turista..." maxlength="63" required>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button form="form-agregar-clase-servicio" class="btn btn-primary mx-3" type="submit">
                <i class="fas fa-pencil-alt"></i>
                &nbsp;Agregar clase
            </button>

            <a href="{{ route('clases-servicios.index') }}" class="btn btn-danger" type="button">
                <i class="fas fa-times-circle"></i>
                &nbsp;Cancelar
            </a>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
@stop
