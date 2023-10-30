@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Editar terminal')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Editar terminal</h1>
@stop

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
        </div>

        <div class="card-body">
            <form id="form-agregar-temporada" action="{{ route('terminales.update', $terminal->id) }}" method="post">
                <input type="hidden" name="idterminal" value="{{$terminal->id}}" />
                @csrf
                @method('put')

                <div class="row form-title-section mb-2">
                    <i class="fas fa-umbrella-beach"></i>
                    <h6>Datos de la terminal</h6>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" class="form-control" placeholder="Ingresar nombre" required value="{{$terminal->nombre}}">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>Estatus</label>
                            <select name="estatus" required class="form-control select2">
                                <option value="0" @if ($terminal->estatus == 0) selected @endif>Inactiva</option>
                                <option value="1" @if ($terminal->estatus == 1) selected @endif>Activa</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-2 col-sm-12">
                        <div class="form-group">
                            <label>Comisión base</label>
                            <input type="number" name="comision_base" value="{{$terminal->comision_base}}" class="form-control" placeholder="Ingresar comision" required>
                        </div>
                    </div>

                    <div class="col-md-2 col-sm-12">
                        <div class="form-group">
                            <label>Precio base</label>
                            <input type="number" name="precio_base" value="{{$terminal->precio_base}}" class="form-control" placeholder="Ingresar comision" required>
                        </div>
                    </div>

                    <div class="col-md-2 col-sm-12">
                        <div class="form-group">
                            <label>% 3 MSI</label>
                            <input type="number" name="tres_meses" value="{{$terminal->tres_meses}}" class="form-control" placeholder="Ingresar comision" required>
                        </div>
                    </div>

                    <div class="col-md-2 col-sm-12">
                        <div class="form-group">
                            <label>% 6 MSI</label>
                            <input type="number" name="seis_meses" value="{{$terminal->seis_meses}}" class="form-control" placeholder="Ingresar comision" required>
                        </div>
                    </div>

                    <div class="col-md-2 col-sm-12">
                        <div class="form-group">
                            <label>% 9 MSI</label>
                            <input type="number" name="nueve_meses" value="{{$terminal->nueve_meses}}" class="form-control" placeholder="Ingresar comision" required>
                        </div>
                    </div>

                    <div class="col-md-2 col-sm-12">
                        <div class="form-group">
                            <label>% 12 MSI</label>
                            <input type="number" name="doce_meses" value="{{$terminal->doce_meses}}" class="form-control" placeholder="Ingresar comision" required>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button form="form-agregar-temporada" class="btn btn-primary mx-3" type="submit">
                <i class="fas fa-pencil-alt"></i>
                &nbsp;Guardar terminal
            </button>

            <a href="{{ route('terminales.index') }}" class="btn btn-danger">
                <i class="fas fa-times-circle"></i>
                &nbsp;Cancelar
            </a>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
@stop
