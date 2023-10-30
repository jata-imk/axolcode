@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Agregar recomendación')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Agregar recomendación</h1>
@stop

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
        </div>

        <div class="card-body">
            <div class="row form-title-section mb-2">
                <i class="fas fa-universal-access"></i>
                <h6>Datos de la recomendación</h6>
            </div>

            <x-recomendaciones.formularios.agregar btnSubmit="false" />
        </div>

        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button form="form-agregar-recomendacion" class="btn btn-primary mx-3" type="submit">
                <i class="fas fa-pencil-alt"></i>
                &nbsp;Agregar recomendación
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
