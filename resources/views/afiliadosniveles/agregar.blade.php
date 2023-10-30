@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Agregar nivel de afiliado')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Agregar nivel de afiliado</h1>
@stop

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
        </div>

        <div class="card-body">
            <form id="form-agregar-afiliado-nivel" action="{{ route('nivelafiliacion.store') }}" method="post">
                @csrf

                <div class="row form-title-section mb-2">
                    <i class="fas fa-layer-group"></i>
                    <h6>Datos del nivel de afiliación</h6>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" class="form-control" placeholder="Ingresar nombre" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                    </div>

                    <div class="col-md-2 col-sm-6">
                        <div class="form-floating">
                            <label>Comisión</label>
                            <input type="number" name="comision" class="form-control" min="0" max="100" step="any" placeholder="E.g.: 15.00%" required>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button form="form-agregar-afiliado-nivel" class="btn btn-primary mx-3" type="submit">
                <i class="fas fa-pencil-alt"></i>
                &nbsp;Agregar nivel
            </button>

            <a href="{{ route('nivelafiliacion.index') }}" class="btn btn-danger">
                <i class="fas fa-times-circle"></i>
                &nbsp;Cancelar
            </a>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
@stop
