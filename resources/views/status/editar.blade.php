@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Editar status')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Editar status</h1>
@stop

@section('content')
    <div class="row mb-2">
        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label class="col-form-label">
                    <i class="fas fa-info-circle"></i>&nbsp;
                    Fecha de creación
                </label>
                <input type="datetime-local" class="form-control form-control-sm" value="{{ $status->created_at }}" disabled>
            </div>
        </div>

        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label class="col-form-label">
                    <i class="fas fa-info-circle"></i>&nbsp;
                    Ultima actualización
                </label>
                <input type="datetime-local" class="form-control form-control-sm" value="{{ $status->updated_at }}" disabled>
            </div>
        </div>
    </div>

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
        </div>

        <div class="card-body">
            <form id="form-editar-status" action="{{ route('status.update', $status->id) }}" method="post">
                @csrf
                @method('put')
                
                <div class="row form-title-section mb-2">
                    <i class="fas fa-eye"></i>
                    <h6>Previsualización</h6>
                </div>

                <div class="row mb-4">
                    <span id="badge" class="badge ml-2 p-2" style="color:{{ $status->color }}; background-color: {{ $status->background_color }};">{{ $status->descripcion }}</span>
                </div>

                <div class="row form-title-section mb-2">
                    <i class="fas fa-info-circle"></i>
                    <h6>Información general</h6>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input id="descripcion" type="text" name="descripcion" value="{{ $status->descripcion }}" class="form-control" placeholder="Ingresar nombre" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="color">Color:</label>
                            <input id="color" name="color" type="color" class="form-control" value="{{ $status->color }}">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="background_color">Color de fondo:</label>
                            <input id="background_color" name="background_color" type="color" class="form-control" value="{{ $status->background_color }}">
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button form="form-editar-status" class="btn btn-primary mx-3" type="submit">
                <i class="fas fa-pencil-alt"></i>
                &nbsp;Editar status
            </button>

            <a href="{{ route('status.index') }}" class="btn btn-danger">
                <i class="fas fa-times-circle"></i>
                &nbsp;Cancelar
            </a>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
@stop

@section('js')
    <script>
        $(function() {
            const inputNombre = document.getElementById("descripcion");
            const inputColor = document.getElementById("color");
            const inputBgColor = document.getElementById("background_color");

            const badgePrevis = document.getElementById("badge");

            inputNombre.addEventListener("input", (event) => {
                if (inputNombre.value === "") {
                    badgePrevis.innerHTML = "&nbsp;";
                } else {
                    badgePrevis.textContent = inputNombre.value;
                }
            });

            inputColor.addEventListener("input", (event) => {
                badgePrevis.style.color = inputColor.value;
            });

            inputBgColor.addEventListener("input", (event) => {
                badgePrevis.style.backgroundColor = inputBgColor.value;
            });
        });
    </script>
@stop
