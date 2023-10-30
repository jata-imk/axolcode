@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Agregar temporada')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Agregar temporada</h1>
@stop

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
        </div>

        <div class="card-body">
            <form id="form-agregar-temporada" action="{{ route('temporadas.store') }}" method="post">
                @csrf

                <div class="row form-title-section mb-2">
                    <i class="fas fa-eye"></i>
                    <h6>Previsualización</h6>
                </div>
    
                <div class="row mb-4">
                    <span id="badge" class="badge ml-2 p-2" style="color:#ffffff; background-color: #000000;">&nbsp;</span>
                </div>

                <div class="row form-title-section mb-2">
                    <i class="fas fa-umbrella-beach"></i>
                    <h6>Datos de la temporada</h6>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ingresar nombre" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                    </div>
    
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="color">Color:</label>
                            <input id="color" name="color" type="color" class="form-control" value="#ffffff">
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="background_color">Color de fondo:</label>
                            <input id="background_color" name="background_color" type="color" class="form-control">
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button form="form-agregar-temporada" class="btn btn-primary mx-3" type="submit">
                <i class="fas fa-pencil-alt"></i>
                &nbsp;Agregar temporada
            </button>

            <a href="{{ route('temporadas.index') }}" class="btn btn-danger">
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
          $(function () {
              const inputNombre = document.getElementById("nombre");
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