@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Editar servicio')

@section('content_header')
<h1><span class="font-weight-bold">CloudTravel</span> | Editar forma de pago</h1>
@stop

@section('content')
<div class="row mb-2">
    <div class="col-md-6 col-sm-6">
        <div class="form-group">
            <label for="empresa-nombre-comercial" class="col-form-label">
                <i class="fas fa-info-circle"></i>&nbsp;
                Fecha de creación
            </label>
            <input type="datetime-local" class="form-control form-control-sm" value="{{ $formadepago->created_at }}" disabled>
        </div>
    </div>

    <div class="col-md-6 col-sm-6">
        <div class="form-group">
            <label for="empresa-nombre-comercial" class="col-form-label">
                <i class="fas fa-info-circle"></i>&nbsp;
                Ultima actualización
            </label>
            <input type="datetime-local" class="form-control form-control-sm" value="{{ $formadepago->updated_at }}" disabled>
        </div>
    </div>
</div>

<div class="card col-12">
    <form action="{{route('formaspago.update', $formadepago->id)}}"  method="post">
        <input type="hidden" name="idforma" value="{{$formadepago->id}}" />
        @csrf
        @method('put')
        <div class="card-header">
            <h3 class="card-title">Datos de la forma de pago</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" required name="nombre" class="form-control" value="{{$formadepago->nombre}}" placeholder="Ingresar Nombre">
                    </div>
                </div>

                <div class="col-md-6 col-sm-6">
                    <div class="form-floating">
                        <label>Descripción</label>
                        <textarea required name="descripcion" class="form-control" placeholder="Agregar una descripción" id="floatingTextarea2" style="height: 100px">{{$formadepago->descripcion}}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-header"></div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button class="btn btn-primary mx-3" type="submit"><i class="fas fa-pencil-alt"></i>Editar forma</button>
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
