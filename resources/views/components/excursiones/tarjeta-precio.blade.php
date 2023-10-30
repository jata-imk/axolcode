<div class="card p-3 border shadow-sm cost-season-card__room" data-temporada-id="{{ $temporada->id }}" data-clase-servicio-id="{{ $claseServicio->id }}" data-tipo-habitacion="{{ $tipoHabitacion }}">
    <h4 class="card-title font-weight-bold mb-1">Habitación {{ $tipoHabitacion }}</h4>

    <div class="row cost-season-card__room-contenedor-campos-asignacion-directa ml-3 mr-3 ocultar @if ($excursion->metodo_calculo_precio == 1) mostrar @endif" data-temporada-id="{{ $temporada->id }}" data-clase-servicio-id="{{ $claseServicio->id }}" data-tipo-habitacion="{{ $tipoHabitacion }}">
        <div class="col-12">
            <div class="form-group">
                <label class="form-check-label">Adulto</label>
                <input type="number" name="temporada-{{ $temporada->id }}-clase-{{ $claseServicio->id }}-adulto_{{ $tipoHabitacion }}" class="form-control" placeholder="0.00" value="{{ $excursionTemporadaClaseCosto['adulto_' . $tipoHabitacion] ?? '0.00' }}" step="any" data-temporada-id="{{ $temporada->id }}">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-check-label">Menor</label>
                <input type="number" name="temporada-{{ $temporada->id }}-clase-{{ $claseServicio->id }}-menor_{{ $tipoHabitacion }}" class="form-control input-menor" placeholder="0.00" value="{{ $excursionTemporadaClaseCosto['menor_' . $tipoHabitacion] ?? '0.00' }}" step="any" data-temporada-id="{{ $temporada->id }}">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label class="form-check-label">Infante</label>
                <input type="number" name="temporada-{{ $temporada->id }}-clase-{{ $claseServicio->id }}-infante_{{ $tipoHabitacion }}" class="form-control input-infante" placeholder="0.00" value="{{ $excursionTemporadaClaseCosto['infante_' . $tipoHabitacion] ?? '0.00' }}" step="any" data-temporada-id="{{ $temporada->id }}">
            </div>
        </div>
    </div>
    

    <div class="row cost-season-card__room-contenedor-campos-formula-costeo ml-3 mr-3  ocultar @if ($excursion->metodo_calculo_precio == 2) mostrar @endif" data-temporada-id="{{ $temporada->id }}" data-clase-servicio-id="{{ $claseServicio->id }}" data-tipo-habitacion="{{ $tipoHabitacion }}">
        <h4 class="card-title font-weight-bold mb-1" style="font-size: 1rem">Seleccione el costeo</h4>
        @php
            // Costos mediante formulas de costeo
            $excursionTemporadasCosteos = null;
            $excursionTemporadasClasesCosteos = null;
            $excursionTemporadasClasesHabitacionCosteos = null;
                                    
            if ($excursionCosteos->contains('pivot.id_temporada', $temporada->id)) {
                $excursionTemporadasCosteos = $excursionCosteos->where('pivot.id_temporada', $temporada->id);
            
                if ($excursionTemporadasCosteos->contains('pivot.id_clase_servicio', $claseServicio->id)) {
                    $excursionTemporadasClasesCosteos = $excursionTemporadasCosteos->where('pivot.id_clase_servicio', $claseServicio->id);

                    if ($excursionTemporadasClasesCosteos->contains('pivot.id_habitacion_tipo', $tipoHabitacion)) {
                        $excursionTemporadasClasesHabitacionCosteos = $excursionTemporadasClasesCosteos->firstWhere('pivot.id_habitacion_tipo', $tipoHabitacion);
                    }
                }
            }
        @endphp

        <div class="col-12">
            <div class="form-group">
                <input type="hidden" name="temporada-{{ $temporada->id }}-clase-{{ $claseServicio->id }}-habitaciones-tipos[]" value="{{ $tipoHabitacion }}">
                <select id="temporada-{{ $temporada->id }}-clase-{{ $claseServicio->id }}-habitacion-tipo-{{ $tipoHabitacion }}-costeo-id"
                        name="temporada-{{ $temporada->id }}-clase-{{ $claseServicio->id }}-habitacion-tipo-{{ $tipoHabitacion }}-costeo-id"
                        class="form-control"
                        data-temporada-id="{{ $temporada->id }}"
                        data-clase-servicio-id="{{ $claseServicio->id }}"
                        data-tipo-habitacion="{{ $tipoHabitacion }}"
                        data-select-costeo >
                    
                    <option value="" selected @if ($excursionTemporadasClasesHabitacionCosteos === null) disabled @endif>Ningún costeo seleccionado</option>

                    @foreach ($costeos as $costeo)
                        <option value="{{ $costeo->id }}" @if (($excursionTemporadasClasesHabitacionCosteos !== null) && ($excursionTemporadasClasesHabitacionCosteos->pivot->id_costeo === $costeo->id)) selected @endif  >{{ $costeo->nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <h4 class="card-title font-weight-bold mb-1" style="font-size: 1rem">Rellenar campos</h4>

        <div class="col-12 cost-season-card__room-campos-formula-costeo">            
            @if ($excursionTemporadasClasesHabitacionCosteos !== null)
                @php
                    $costeoTemporadaClaseHabitacionCampos = $costeo->firstWhere("id", $excursionTemporadasClasesHabitacionCosteos->pivot->id_costeo);
                @endphp

                @foreach ($costeoTemporadaClaseHabitacionCampos->campos as $campo)
                    @php
                        $excursionTemporadasClasesHabitacionCosteosPivotCampos = $excursionTemporadasClasesHabitacionCosteos->pivot->campos;
                        $excursionTemporadasClasesHabitacionCosteoCampos = $excursionTemporadasClasesHabitacionCosteosPivotCampos->firstWhere("id_costeo_campo", $campo->id);
                    @endphp
                    @if (($campo->definido_por_usuario === 1) || ($campo->definido_por_excursion === 1))
                        @continue;
                    @endif
                    <div class="form-group">
                        <label class="form-check-label">{{ $campo->nombre }}</label>
                        <input type="hidden" name="temporada-{{ $temporada->id }}-clase-{{ $claseServicio->id }}-habitacion-tipo-{{ $tipoHabitacion }}-costeo-{{ $costeoTemporadaClaseHabitacionCampos->id }}-campos-id[]" value="{{ $campo->id }}" >
                        <input type="number" name="temporada-{{ $temporada->id }}-clase-{{ $claseServicio->id }}-habitacion-tipo-{{ $tipoHabitacion }}-costeo-{{ $costeoTemporadaClaseHabitacionCampos->id }}-campo-{{ $campo->id }}-valor" class="form-control" placeholder="0.00" value="{{ $excursionTemporadasClasesHabitacionCosteoCampos->valor }}" step="any" >
                    </div>
                @endforeach

                <div class="form-group">
                    <label class="form-check-label">Descuento menores</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <input type="checkbox" name="temporada-{{ $temporada->id }}-clase-{{ $claseServicio->id }}-habitacion-tipo-{{ $tipoHabitacion }}-costeo-{{ $costeoTemporadaClaseHabitacionCampos->id }}-campo-tipo-descuento-menor" @if ($excursionTemporadasClasesHabitacionCosteos->pivot->descuento_menores_tipo === 1) checked @endif>
                            </span>
                        </div>
                        <input type="text" class="form-control" name="temporada-{{ $temporada->id }}-clase-{{ $claseServicio->id }}-habitacion-tipo-{{ $tipoHabitacion }}-costeo-{{ $costeoTemporadaClaseHabitacionCampos->id }}-campo-descuento-menor" value="{{ $excursionTemporadasClasesHabitacionCosteos->pivot->descuento_menores }}">
                    </div>
                    <small class="form-text text-muted">Marque el recuadro si el descuento es un porcentaje (%)</small>
                </div>
                
                <div class="form-group">
                    <label class="form-check-label">Descuento infantes</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <input type="checkbox" name="temporada-{{ $temporada->id }}-clase-{{ $claseServicio->id }}-habitacion-tipo-{{ $tipoHabitacion }}-costeo-{{ $costeoTemporadaClaseHabitacionCampos->id }}-campo-tipo-descuento-infante" @if ($excursionTemporadasClasesHabitacionCosteos->pivot->descuento_infantes_tipo === 1) checked @endif>
                            </span>
                        </div>
                        <input type="text" class="form-control" name="temporada-{{ $temporada->id }}-clase-{{ $claseServicio->id }}-habitacion-tipo-{{ $tipoHabitacion }}-costeo-{{ $costeoTemporadaClaseHabitacionCampos->id }}-campo-descuento-infante" value="{{ $excursionTemporadasClasesHabitacionCosteos->pivot->descuento_infantes }}">
                    </div>
                    <small class="form-text text-muted">Marque el recuadro si el descuento es un porcentaje (%)</small>
                </div>
            @else
                Aun no se selecciona costeo
            @endif
        </div>
    </div>
</div>