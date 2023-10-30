@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Editar fecha')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Editar fecha</h1>
@stop

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
        </div>

        <div class="card-body">
            <form id="form-editar-fecha" action="{{ route('excursion-fechas-actualizar', [$excursion[0]->id, implode(',', [$fecha->fecha_inicio,$fecha->fecha_fin])]) }}" method="post">
                @csrf
                @method("put")

                <input type="hidden" name="excursion_id" value="{{ $excursion[0]->id }}">

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="id_excursion">Seleccionar excursión</label>
                            <select id="id_excursion" class="form-control" name="id_excursion" disabled>
                                <option value="{{ $excursion[0]->id }}" selected>{{ $excursion[0]->nombre }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                    </div>
                </div>

                <div id="form-fechas__contenido" class="form-fechas__contenido">
                    <div class="form-fechas__temporada">
                        <div class="form-group m-0 mb-2">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input checkbox-temporada" data-temporada-id="{{ $fecha->temporada->id }}" id="checkbox-temporada-{{ $fecha->temporada->id }}" checked disabled name="temporadas[]" value="{{ $fecha->temporada->id }}" >
                                <label class="custom-control-label" for="checkbox-temporada-{{ $fecha->temporada->id }}">Temporada {{ $fecha->temporada->nombre }}</label>
                            </div>
                        </div>

                        <div class="form-fechas__fechas ocultar mostrar" data-temporada-id="{{ $fecha->temporada->id }}">                            
                            <div class="form-fechas__fecha align-items-center">
                                <input type="hidden" name="temporada-{{ $fecha->temporada->id }}-id[]" value="{{ $fecha->id }}">
                                
                                <div class="form-fechas__fecha--left">
                                    <div class="form-group">
                                        <label for="temporada-{{ $fecha->temporada->id }}-fecha-inicio">Fecha de inicio</label>
                                        <input type="date" id="temporada-{{ $fecha->temporada->id }}-fecha-inicio" name="temporada-{{ $fecha->temporada->id }}-fecha-inicio" class="form-control" value="{{ $fecha->fecha_inicio }}" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="temporada-{{ $fecha->temporada->id }}-fecha-fin">Fecha final</label>
                                        <input type="date" id="temporada-{{ $fecha->temporada->id }}-fecha-fin" name="temporada-{{ $fecha->temporada->id }}-fecha-fin" class="form-control" value="{{ $fecha->fecha_fin }}" disabled>
                                    </div>
                                </div>

                                <div class="form-fechas__fecha-clases flex-column pt-4 pb-4 rounded">
                                    @foreach ($fecha->clases as $clase)     
                                    <div class="d-flex gap-20">
                                        <div class="form-group">
                                            <label for="temporada-{{ $fecha->temporada->id }}-clase-{{ $clase->id }}-cupo">Cupo máximo</label>
                                            <input type="number" id="temporada-{{ $fecha->temporada->id }}-clase-{{ $clase->id }}-cupo" name="temporada-{{ $fecha->temporada->id }}-clase-{{ $clase->id }}-cupo" class="form-control" min="0" max="1000" value="{{ $clase->cupo }}" required>
                                        </div>
                                                         
                                        <div class="form-group form-check">
                                            <label class="form-check-label" for="temporada-{{ $fecha->temporada->id }}-clase-{{ $clase->id }}">Publicar {{ $clase->nombre }}</label>
                                            <input type="checkbox" @if ($clase->publicar_fecha == 1) checked @endif class="form-check-input" id="temporada-{{ $fecha->temporada->id }}-clase-{{ $clase->id }}" name="temporada-{{ $fecha->temporada->id }}-clases[]" value="{{ $clase->id }}" >
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button form="form-editar-fecha" class="btn btn-primary mx-3" type="submit">
                <i class="fas fa-pencil-alt"></i>
                &nbsp;Agregar fecha
            </button>

            <a href="{{ route('excursiones-fechas.index') }}" class="btn btn-danger">
                <i class="fas fa-times-circle"></i>
                &nbsp;Cancelar
            </a>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css' ) }}>
@stop

@section('js')
    <script>
        $(function() {
            basicValidation();
        });
    </script>
@stop
