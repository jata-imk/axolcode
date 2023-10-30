@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Editar link')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Editar link</h1>
@stop

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
        </div>

        <div class="card-body">
            <form id="form-agregar-temporada" action="{{ route('banregiolinks.update', $link->id) }}" method="post">
                <input type="hidden" name="id_terminal" value="1" />
                <input type="hidden" name="id" value="{{$link->id}}" />
                @csrf
                @method('put')

                <div class="row form-title-section mb-2">
                    <i class="fas fa-umbrella-beach"></i>
                    <h6>Editar link de pago</h6>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="form-group">
                            <label>Nombre del cliente</label>
                            <input type="text" name="nombre_cliente" value="{{$link->nombre_cliente}}" class="form-control" placeholder="Ingresar nombre" required>
                        </div>
                    </div>

                    <div class="col-md-2 col-sm-12">
                        <div class="form-group">
                            <label>Monto a pagar</label>
                            <input type="number" name="monto" value="{{$link->monto}}" class="form-control" placeholder="Ingresar monto" required>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-12">
                        <div class="form-group">
                            <label>Forma de pago (MSI)</label>
                            <select name="meses" required="" class="form-control select2">
                                <option value="1" @if ($link->meses == 1) selected @endif>1 exhibición</option>
                                <option value="3" @if ($link->meses == 3) selected @endif>3 MSI</option>
                                <option value="6" @if ($link->meses == 6) selected @endif>6 MSI</option>
                                <option value="9" @if ($link->meses == 9) selected @endif>9 MSI</option>
                                <option value="12" @if ($link->meses == 12) selected @endif>12 MSI</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button form="form-agregar-temporada" class="btn btn-primary mx-3" type="submit">
                <i class="fas fa-pencil-alt"></i>
                &nbsp;Modificar link
            </button>

            <a href="{{ route('banregiolinks.index') }}" class="btn btn-danger">
                <i class="fas fa-times-circle"></i>
                &nbsp;Cancelar
            </a>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
@stop
