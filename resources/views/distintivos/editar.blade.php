@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Editar distintivo')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Editar distintivo</h1>
    <p>Por ejemplo sectur, amav, etc etc</p>
@stop

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
        </div>

        <div class="card-body">
            <form id="form-editar-distintivo" action="{{ route('distintivos.update', $distintivo->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')

                <input type="hidden" name="logoactual" value="{{ $distintivo->logo }}" />

                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Nombre del distintivo</label>
                                    <input type="text" name="nombre" value="{{ $distintivo->nombre }}" class="form-control" placeholder="Ingresar Nombre (AMAV, SECTUR, etc...)">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Enlace</label>
                                    <input type="text" name="link" value="{{ $distintivo->link }}" class="form-control" placeholder="https://www.gob.mx/sectur...">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    @if ($distintivo->logo)
                                        <label for="">Cambiar logo del distintivo</label>
                                    @else
                                        <label for="">Subir logo del distintivo</label>
                                    @endif
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="logo" name="logo" accept="image/*" onchange="preview()" required>
                                            <label class="custom-file-label" for="logo">Escoja un fichero</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex align-items-center">
                        <div class="card ml-auto mr-auto d-flex align-items-center justify-content-center" style="width: 75%; min-height: 275px;">
                            <img id="frame" src="storage/{{ $distintivo->logo }}" class="img-fluid" style="width: 90%;" />
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button form="form-editar-distintivo" class="btn btn-primary mx-3" type="submit">
                <i class="fas fa-pencil-alt"></i>
                &nbsp;Editar distintivo
            </button>

            <a href="{{ route('distintivos.index') }}" class="btn btn-danger">
                <i class="fas fa-times-circle"></i>
                &nbsp;Cancelar
            </a>
        </div>
    </div>
@stop

@section('plugins.BS_Custom_FileInput', true)

@section('css')
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
@stop

@section('js')
    <script>
        function preview() {
            frame.src = URL.createObjectURL(event.target.files[0]);
        }

        (function() {
            document.addEventListener("DOMContentLoaded", function() {
                bsCustomFileInput.init();
            });
        })();
    </script>
@stop
