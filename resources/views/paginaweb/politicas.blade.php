@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Políticas de cancelación')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Agregar Políticas de cancelación</h1>
@stop

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
        </div>

        <div class="card-body">
            <form id="form-politicas" action="{{ route('paginas-web.update', $paginaweb[0]->id) }}" method="post">
                <input type="hidden" value="{{ $paginaweb[0]->id }}" name="id" />
                <input type="hidden" value="politicacancelacion" name="ruta" />

                @csrf
                @method('put')

                <div class="row form-title-section mb-4">
                    <i class="fas fa-book"></i>
                    <h6>Redacte sus términos y condiciones y sus políticas de cancelación</h6>
                </div>

                <textarea id="summernote" name="politicas">{{ $paginaweb[0]->politicas }}</textarea>
            </form>
        </div>

        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button form="form-politicas" class="btn btn-primary mx-3" type="submit">
                <i class="far fa-save"></i>
                &nbsp;Guardar
            </button>
        </div>
    </div>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: 'Agregar Políticas de cancelación',
                tabsize: 2,
                height: 500
            });
        });
    </script>
@stop
