@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Código externo')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Código externo</h1>
@stop

@section('content')

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
        </div>

        <div class="card-body">
            <form id="form-codigo-externo" action="{{ route('paginas-web.update', $paginaweb[0]->id) }}" method="post">
                <input type="hidden" value="{{ $paginaweb[0]->id }}" name="id" />
                <input type="hidden" value="codigoexterno" name="ruta" />

                @csrf
                @method('put')

                <div class="row form-title-section mb-4">
                    <i class="fas fa-book"></i>
                    <h6>Agregué el código que considere necesario</h6>
                </div>

                <div class="col-md-12">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                Snippet Header
                            </h3>
                        </div>
        
                        <div class="card-body p-0">
                            <textarea id="snippet_header" name="snippet_header" class="p-3">@if ($paginaweb[0]->snippet_header == "")<!-- Ingrese código HTML  -->@else{{ $paginaweb[0]->snippet_header }}@endif</textarea>
                        </div>
                        <div class="card-footer">
                            Este snippet de código se ejecutará dentro de la  sección &lt;head&gt; de HTML, la cual provee información general (metadatos) acerca del documento, incluyendo su título y enlaces a scripts y hojas de estilos.
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                Snippet Footer
                            </h3>
                        </div>
        
                        <div class="card-body p-0">
                            <textarea id="snippet_footer" name="snippet_footer" class="p-3">@if ($paginaweb[0]->snippet_footer == "")<!-- Ingrese código HTML  -->@else{{ $paginaweb[0]->snippet_footer }}@endif</textarea>
                        </div>
                        <div class="card-footer">
                            Este snippet de código se ejecutará dentro de la  sección &lt;footer&gt; de HTML, la cual representa un pie de página para el contenido de sección más cercano o el elemento raíz de sección (En este caso el elemento &lt;body&gt;)
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button form="form-codigo-externo" class="btn btn-primary mx-3" type="submit">
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
            CodeMirror.fromTextArea(document.getElementById("snippet_header"), {
                mode: "htmlmixed",
                theme: "monokai"
            });
            
            CodeMirror.fromTextArea(document.getElementById("snippet_footer"), {
                mode: "htmlmixed",
                theme: "monokai"
            });
        });
    </script>
@stop
