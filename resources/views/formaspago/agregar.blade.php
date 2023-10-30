@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Agregar servicio')

@section('content_header')
<h1><span class="font-weight-bold">CloudTravel</span> | Agregar forma de pago</h1>
@stop

@section('content')
<div class="card col-12">
    <form action="{{route('formaspago.store')}}" method="post">
        @csrf
        <div class="card-header">
            <h3 class="card-title">Datos de la forma de pago</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" required name="nombre" class="form-control" value="" placeholder="Ingresar Nombre">
                    </div>
                </div>

                <div class="col-md-6 col-sm-6">
                    <div class="form-floating">
                        <label>Descripción</label>
                        <textarea required name="descripcion" class="form-control" placeholder="Agregar una descripción style="height: 100px"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-header"></div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button class="btn btn-primary mx-3" type="submit"><i class="fas fa-pencil-alt"></i>Agregar forma</button>
            <a href="{{route('formaspago.index')}}"><button class="btn btn-danger" type="button"><i class="fas fa-times-circle"></i> Cancelar</button></a>
        </div>
    </form>
</div>
@stop

@section('css')
    <link rel="stylesheet" href={{ asset("/assets/css/admin_custom.css") }}>
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
