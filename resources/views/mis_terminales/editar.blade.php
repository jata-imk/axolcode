@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Agregar terminal')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Configurar mi terminal</h1>
@stop

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
        </div>

        <div class="card-body">
            <form id="form-agregar-temporada" action="{{ route('mis-terminales.update', $terminal->id) }}" method="post">
                <input type="hidden" name="id_terminal" value="{{$terminal->id}}" />
                @csrf
                @method('put')

                <div class="row form-title-section mb-2">
                    <i class="fas fa-umbrella-beach"></i>
                    <h6>Datos de la terminal</h6>
                </div>

                <div class="row">
                    <div class="col-md-2 col-sm-12">
                        <div class="form-group">
                            <label>Afiliación</label>
                            <input type="text" name="id_afiliacion" value="{{$terminal->id_afiliacion}}" class="form-control" placeholder="Ingrese el # de afiliación" required>
                        </div>
                    </div>

                    <div class="col-md-2 col-sm-12">
                        <div class="form-group">
                            <label>ID Medio</label>
                            <input type="text" name="id_medio" value="{{$terminal->id_medio}}" class="form-control" placeholder="Ingrese la información">
                        </div>
                    </div>

                    <div class="col-md-2 col-sm-12">
                        <div class="form-group">
                            <label>Modo</label>
                            <select name="enviroment" required class="form-control select2">
                                <option value="sandbox" @if ($terminal->enviroment == 'sandbox') selected @endif>Pruebas</option>
                                <option value="prod" @if ($terminal->enviroment == 'prod') selected @endif>Producción</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2 col-sm-12">
                        <div class="form-group">
                            <label>Llave privada</label>
                            <input type="text" name="llave_privada" value="{{$terminal->llave_privada}}" class="form-control" placeholder="Ingresar comision" required>
                        </div>
                    </div>

                    <div class="col-md-2 col-sm-12">
                        <div class="form-group">
                            <label>Llave pública</label>
                            <input type="text" name="llave_publica" value="{{$terminal->llave_publica}}" class="form-control" placeholder="Ingresar comision" required>
                        </div>
                    </div>

                    <div class="col-md-2 col-sm-12">
                        <div class="form-group">
                            <label>Estatus</label>
                            <select name="estatus" required class="form-control select2">
                                <option value="0" @if ($terminal->estatus == 0) selected @endif>No usar en el sitio web</option>
                                <option value="1" @if ($terminal->estatus == 1) selected @endif>Usar en el sitio web</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label>URL de respuesta</label>
                            <input type="text" name="url_respuesta" value="{{$terminal->url_respuesta}}" class="form-control" placeholder="Ingrese la URL de respuesta después de una transacción" required>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button form="form-agregar-temporada" class="btn btn-primary mx-3" type="submit">
                <i class="fas fa-pencil-alt"></i>
                &nbsp;Configurar terminal
            </button>

            <a href="{{ route('mis-terminales.index') }}" class="btn btn-danger">
                <i class="fas fa-times-circle"></i>
                &nbsp;Cancelar
            </a>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
@stop
