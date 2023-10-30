@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Reseñas')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Código para reseñas</h1>
@stop

@section('content')
<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">&nbsp;</h3>
    </div>

    <div class="card-body">
        <form id="form-resenas" action="{{ route('paginas-web.update', $paginaweb[0]->id) }}" method="post">
            <input type="hidden" value="{{ $paginaweb[0]->id }}" name="id" />
            <input type="hidden" value="resenas" name="ruta" />
            
            @csrf
            @method('put')
            
            <div class="row form-title-section mb-4">
                <i class="fas fa-book"></i>
                <h6>Agregué su código especial para las reseñas</h6>
            </div>

            <div class="col-md-12">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            Snippet reseñas
                        </h3>
                    </div>
    
                    <div class="card-body p-0">
                        <textarea id="snippet_reviews" name="snippet_reviews" class="p-3">@if ($paginaweb[0]->snippet_reviews == "")<!-- Ingrese código HTML  -->@else{{ $paginaweb[0]->snippet_reviews }}@endif</textarea>
                    </div>
                    <div class="card-footer">
                        Este snippet puede y debe ser usado para agregar widgets de comentarios a nuestra pagina (E.g. Comentarios de la pagina de TripAdvisor), puede ser usado en diversas paginas de nuestro sitio web, como en la pagina de 'Inicio' y en la pagina 'Acerca de nosotros'
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
        <button form="form-resenas" class="btn btn-primary mx-3" type="submit">
            <i class="far fa-save"></i>
            &nbsp;Guardar
        </button>
    </div>
</div>
@stop

@section('plugins.CodeMirror', true)

@section('css')
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            // CodeMirror
            CodeMirror.fromTextArea(document.getElementById("snippet_reviews"), {
                mode: "htmlmixed",
                theme: "monokai"
            });
        });
    </script>
@stop
