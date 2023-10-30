@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Agregar modulo')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Agregar modulo</h1>
@stop

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
        </div>

        <div class="card-body">
            <form id="form-agregar-modulo" action="{{ route('modulos.store') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="row border-bottom mb-2">
                    <h6>Información general</h6>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="text">Nombre</label>
                            <input id="text" type="text" name="text" maxlength="63" class="form-control" placeholder="Ingresar nombre..." required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="url">URL</label>
                            <input id="url" type="text" name="url" maxlength="63" class="form-control" placeholder="Ingresar URL...">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="icon">Icono (Clase FontAwesome)</label>
                            <input id="icon" type="text" name="icon" maxlength="63" class="form-control" placeholder="Ingresar clase de fontawesome..." required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="icon_color">Color del icono</label>
                            <select id="icon_color" class="form-control" name="icon_color">
                                @php
                                    $arrColores = [
                                        'value' => ['primary', 'secondary', 'info', 'success', 'warning', 'danger', 'black', 'gray-dark', 'gray', 'indigo', 'lightblue', 'navy', 'purple', 'fuchsia', 'pink', 'maroon', 'orange', 'lime', 'teal', 'olive'],
                                    ];
                                @endphp

                                <option value="" class="bg-light" selected>
                                    Por defecto
                                </option>

                                @foreach ($arrColores['value'] as $i => $color)
                                    <option value="{{ $arrColores['value'][$i] }}" class="bg-{{ $arrColores['value'][$i] }}">
                                        {{ ucwords($arrColores['value'][$i]) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="section">Sección</label>
                            <select id="section" class="form-control" name="section">
                                @php
                                    $arrSecciones = [
                                        'nombre' => ['Operaciones', 'Terminal Online', 'Configuración'],
                                    ];
                                @endphp

                                @foreach ($arrSecciones['nombre'] as $i => $seccion)
                                    <option value="{{ $arrSecciones['nombre'][$i] }}" class="bg-{{ $arrSecciones['nombre'][$i] }}">
                                        {{ ucwords($arrSecciones['nombre'][$i]) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6"> </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="key">Identificador (Para poder añadir submenus)</label>
                            <input id="key" type="text" name="key" maxlength="31" class="form-control" placeholder="Ingresar identificador...">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="add_in">Identificador del contenedor (Para los submenus)</label>
                            <select id="add_in" class="form-control" name="add_in">
                                <option value="" selected>
                                    Ninguno
                                </option>

                                @foreach ($keysContenedores as $i => $keyContenedor)
                                    <option value="{{ $keyContenedor->key }}">
                                        {{ $keyContenedor->key }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button form="form-agregar-modulo" class="btn btn-primary mx-3" type="submit">
                <i class="fas fa-pencil-alt"></i>
                Agregar modulo
            </button>

            <a href="{{ route('modulos.index') }}" class="btn btn-danger" type="button">
                <i class="fas fa-times-circle"></i> Cancelar
            </a>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
@stop
