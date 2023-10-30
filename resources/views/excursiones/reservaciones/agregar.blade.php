@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Agregar reservación')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Agregar reservación</h1>
@stop

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
        </div>

        <div class="card-body">
            <div class="resumen-reserva">
                <div id="resumen-reserva__contenido" class="resumen-reserva__contenido">
                    <span id="resumen-reserva__btn-close" class="resumen-reserva__btn-close">
                        <i class="fas fa-times"></i>
                    </span>

                    <div class="resumen-reserva__titles">
                        <h5 id="resumen-reserva__excursion-nombre"></h5>
                        <small class="w-100 d-block"><span id="resumen-reserva__excursion-temporada"></span> <span id="resumen-reserva__excursion-clase"></span></small>
                        <small id="resumen-reserva__excursion-fecha" class="w-100 d-block"></small>
                    </div>

                    <div class="resumen-reserva__titles mt-3">
                        <h5 id="resumen-reserva__cliente"></h6>
                    </div>

                    <div id="resumen-reserva__body" class="resumen-reserva__body mt-3">
                        
                    </div>

                    <div class="resumen-reserva__titles  resumen-reserva__precios mt-3">
                        <div class="resumen-reserva__precio">
                            <h5 style="font-size: 90%">Subtotal:</h5>
                            <h5>$ <span id="resumen-reserva__subtotal">00.00</span> <span class="resumen-reserva__iso-moneda"></span></h5>
                        </div>
                        
                        <div class="resumen-reserva__precio">
                            <h5 style="font-size: 90%">Descuento:</h5>
                            <h5><span id="resumen-reserva__descuento">$ 00.00</span> <span class="resumen-reserva__iso-moneda"></span></h5>
                        </div>
                        
                        <div id="resumen-reserva__vuelos" class="resumen-reserva__precio" style="display: none">
                            <h5 style="font-size: 90%">Vuelos:</h5>
                            <h5>$ <span id="resumen-reserva__vuelos-span">00.00</span> <span class="resumen-reserva__iso-moneda"></span></h5>
                        </div>

                        <div class="resumen-reserva__precio">
                            <h5 style="font-size: 90%">Total:</h5>
                            <h5>$ <span id="resumen-reserva__total">00.00</span> <span class="resumen-reserva__iso-moneda"></span></h5>
                        </div>
                    </div>

                </div>

                <div id="resumen-reserva__btn" class="resumen-reserva__btn animated zoomIn faster dn">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
            </div>

            <form id="form-agregar-reservacion" action="{{ route('reservacion-excursiones.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="row form-title-section mb-2">
                    <i class="fas fa-info-circle"></i>
                    <h6>Información general</h6>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="id_excursion">Seleccionar excursión</label>
                            <select id="id_excursion" class="form-control" name="id_excursion" required>
                                <option value="" selected disabled hidden> Seleccione una opción </option>
                                @foreach ($excursiones as $excursion)
                                    <option value="{{ $excursion->id }}">
                                        {{ $excursion->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group d-flex align-items-center justify-content-center h-100">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input" id="fecha-personalizada" name="fecha-personalizada" value="1">
                                <label class="custom-control-label" for="fecha-personalizada">Es una fecha
                                    personalizada?</label>
                            </div>
                        </div>
                    </div>

                    <div id="wrapper__inputs-fechas" class="w-100 d-flex flex-wrap">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="id_temporada">Seleccionar temporada</label>
                                <select id="id_temporada" class="form-control" name="id_temporada" required>
                                    <option value="" selected disabled hidden> Primero seleccione una excursión</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="id_clase_servicio">Seleccionar clase</label>
                                <select id="id_clase_servicio" class="form-control" name="id_clase_servicio" required>
                                    <option value="" selected disabled hidden> Primero seleccione una temporada</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="fechas-txt">Seleccionar fecha</label>
                                <style>
                                    #fechas-txt option {
                                        font-family: 'Courier New', Courier, monospace
                                    }
                                </style>

                                <input type="hidden" id="id_fecha" name="id_fecha" value="0">
                                <select id="fechas-txt" class="form-control" name="fechas-txt" required>
                                    <option value="" selected disabled hidden> Primero seleccione una clase </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div id="wrapper__inputs-fechas-personalizadas" class="col-md-6 col-sm-6 d-flex p-0" style="display: none !important">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="fecha_inicio">Fecha de inicio</label>
                                <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" min="{{ date('Y-m-d') }}" />
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label for="fecha_fin">Fecha final</label>
                                <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" min="{{ date('Y-m-d') }}" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row form-title-section mb-2">
                    <i class="fas fa-info-circle"></i>
                    <h6>Información de la excursion</h6>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6 d-flex align-items-center justify-content-center text-center flex-wrap">
                        <label class="w-100">Menores e infantes</label>
                        
                        <div class="form-group">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input" id="menores" name="menores" value="1" >
                                <label class="custom-control-label" for="menores">Menores</label>
                            </div>
                        </div>
                        
                        <div class="form-group ml-4">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input" id="infantes" name="infantes" value="1" >
                                <label class="custom-control-label" for="infantes">Infantes</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-sm-6 d-flex align-items-center justify-content-center text-center flex-wrap">
                        <label class="w-100">Hotelería y vuelos</label>
                        
                        <div class="form-group">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input" id="hoteleria" name="hoteleria" value="1" >
                                <label class="custom-control-label" for="hoteleria">Hotelería</label>
                            </div>
                        </div>
                        
                        <div class="form-group ml-4">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input" id="vuelos" name="vuelos" value="1" >
                                <label class="custom-control-label" for="vuelos">Vuelos</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 p-0">
                        <label class="ml-2">Precios por persona</label>
                        <div id="cost-season-card__rooms" class="cost-season-card__rooms">
                            <div class="card p-3 border shadow-sm cost-season-card__room" data-room-type="sencilla">
                                <h4 class="card-title font-weight-bold mb-1" style="display: none">Habitación sencilla</h4>
                                <div class="row ml-3 mr-3">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-check-label">Adulto</label>
                                            <input type="number" name="adulto_sencilla" data-pax-type="adulto" class="form-control" placeholder="0.00" value="" step="any">
                                        </div>
                                    </div>
                                    <div class="col-12" style="display: none">
                                        <div class="form-group">
                                            <label class="form-check-label">Menor</label>
                                            <input type="number" name="menor_sencilla" data-pax-type="menor" class="form-control input-menor" placeholder="0.00" value="" step="any">
                                        </div>
                                    </div>
                                    <div class="col-12" style="display: none">
                                        <div class="form-group">
                                            <label class="form-check-label">Infante</label>
                                            <input type="number" name="infante_sencilla" data-pax-type="infante" class="form-control input-infante" placeholder="0.00" value="" step="any">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card p-3 border shadow-sm cost-season-card__room" data-room-type="doble" style="display: none">
                                <h4 class="card-title font-weight-bold mb-1">Habitación doble</h4>
                                <div class="row ml-3 mr-3">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-check-label">Adulto</label>
                                            <input type="number" name="adulto_doble" data-pax-type="adulto" class="form-control" placeholder="0.00" value="" step="any">
                                        </div>
                                    </div>
                                    <div class="col-12" style="display: none">
                                        <div class="form-group">
                                            <label class="form-check-label">Menor</label>
                                            <input type="number" name="menor_doble" data-pax-type="menor" class="form-control input-menor" placeholder="0.00" value="" step="any">
                                        </div>
                                    </div>
                                    <div class="col-12" style="display: none">
                                        <div class="form-group">
                                            <label class="form-check-label">Infante</label>
                                            <input type="number" name="infante_doble" data-pax-type="infante" class="form-control input-infante" placeholder="0.00" value="" step="any">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card p-3 border shadow-sm cost-season-card__room" data-room-type="triple" style="display: none">
                                <h4 class="card-title font-weight-bold mb-1">Habitación triple</h4>
                                <div class="row ml-3 mr-3">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-check-label">Adulto</label>
                                            <input type="number" name="adulto_triple" data-pax-type="adulto" class="form-control" placeholder="0.00" value="" step="any">
                                        </div>
                                    </div>
                                    <div class="col-12" style="display: none">
                                        <div class="form-group">
                                            <label class="form-check-label">Menor</label>
                                            <input type="number" name="menor_triple" data-pax-type="menor" class="form-control input-menor" placeholder="0.00" value="" step="any">
                                        </div>
                                    </div>
                                    <div class="col-12" style="display: none">
                                        <div class="form-group">
                                            <label class="form-check-label">Infante</label>
                                            <input type="number" name="infante_triple" data-pax-type="infante" class="form-control input-infante" placeholder="0.00" value="" step="any">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card p-3 border shadow-sm cost-season-card__room" data-room-type="cuadruple" style="display: none">
                                <h4 class="card-title font-weight-bold mb-1">Habitación cuádruple</h4>
                                <div class="row ml-3 mr-3">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-check-label">Adulto</label>
                                            <input type="number" name="adulto_cuadruple" data-pax-type="adulto" class="form-control" placeholder="0.00" value="" step="any">
                                        </div>
                                    </div>
                                    <div class="col-12" style="display: none">
                                        <div class="form-group">
                                            <label class="form-check-label">Menor</label>
                                            <input type="number" name="menor_cuadruple" data-pax-type="menor" class="form-control input-menor" placeholder="0.00" value="" step="any">
                                        </div>
                                    </div>
                                    <div class="col-12" style="display: none">
                                        <div class="form-group">
                                            <label class="form-check-label">Infante</label>
                                            <input type="number" name="infante_cuadruple" data-pax-type="infante" class="form-control input-infante" placeholder="0.00" value="" step="any">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 row w-100">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>Promoción</label>
                                <input type="hidden" id="id_promocion" name="id_promocion" value="0">
                                <input type="hidden" id="promocion_travel_window_inicio" name="promocion_travel_window_inicio" value="">
                                <input type="hidden" id="promocion_travel_window_fin" name="promocion_travel_window_fin" value="">
                                <input type="text" id="info-excursion__promocion" class="form-control" value="Aun no se ha seleccionado ninguna excursión" disabled />
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>Moneda</label>
                                <input type="hidden" id="id_moneda" name="id_moneda" value="0" />
                                <input type="hidden" id="iso_moneda" name="iso_moneda" value="" />
                                <input type="text" id="moneda_nombre" name="moneda_nombre" class="form-control" value="Aun no se ha seleccionado ninguna excursión" disabled />
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <div id="resumen_promocion" class="form-group" style="display: none;">
                                <label>Resumen de la promoción</label>
                                <p id="txtDescuento" class="text-danger"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row form-title-section mb-2">
                    <i class="fas fa-info-circle"></i>
                    <h6>Información de la reserva</h6>
                </div>

                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <label>Cliente</label>
                            <input type="hidden" id="id_ejecutivo" name="id_ejecutivo" value="0">
                            <select name="id_cliente" class="select2-ajax-cliente" required>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <div class="form-group">
                            <label for="identificacion">Agregar identificación <span class="text-danger">(Imagen)</span></label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="identificacion" name="identificacion" accept="image/*" required>
                                    <label class="custom-file-label" for="identificacion">Ningún archivo seleccionado...</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Subir</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="wrapper-cliente-vuelos" class="col-md-12 col-sm-12 row p-0 m-0 mt-4 mb-4" style="display:none" >
                        <div class="col-md-12 col-sm-12">
                            <label class="w-100 text-info">Vuelo de llegada</label>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group" data-vuelo-llegada-ciudad-origen>
                                <label>Origen:</label>
                            </div>
                            <pre class="results m-0 p-0"></pre>
                        </div>
                    
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group" data-vuelo-llegada-ciudad-destino>
                                <label>Destino:</label>
                            </div>
                            <pre class="results m-0 p-0"></pre>
                        </div>
                    
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label>Aerolínea:</label>
                                <select name="cliente-vuelo-llegada-id-aerolinea[]" data-vuelo-llegada-id-aerolinea class="form-control" >
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label>No. de vuelo:</label>
                                <input type="text" name="cliente-vuelo-llegada-no-vuelo[]" class="form-control" />
                            </div>
                        </div>
                    
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label>Fecha y hora:</label>
                                <input type="datetime-local" name="cliente-vuelo-llegada-fecha-y-hora[]" class="form-control" />
                            </div>
                        </div>
                    
                        <div class="col-md-4 col-sm-6" >
                            <div class="form-group">
                                <label>Precio:</label>
                                <input type="number" name="cliente-vuelo-llegada-precio[]" data-input-vuelo-precio class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12">
                            <label class="w-100 text-info">Vuelo de regreso</label>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group" data-vuelo-regreso-ciudad-origen>
                                <label>Origen:</label>
                            </div>
                            <pre class="results m-0 p-0"></pre>
                        </div>
                    
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group" data-vuelo-regreso-ciudad-destino>
                                <label>Destino:</label>
                            </div>
                            <pre class="results m-0 p-0"></pre>
                        </div>
                    
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label>Aerolínea:</label>
                                <select name="cliente-vuelo-regreso-id-aerolinea[]" data-vuelo-regreso-id-aerolinea class="form-control" >
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label>No. de vuelo:</label>
                                <input type="text" name="cliente-vuelo-regreso-no-vuelo[]" class="form-control" />
                            </div>
                        </div>
                    
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label>Fecha y hora:</label>
                                <input type="datetime-local" name="cliente-vuelo-regreso-fecha-y-hora[]" class="form-control" />
                            </div>
                        </div>
                    
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label>Precio:</label>
                                <input type="number" name="cliente-vuelo-regreso-precio[]" data-input-vuelo-precio class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Tipo de venta</label>
                            <select class="form-control" id="tipo_venta" name="tipo_venta" required>
                                <option value="1">Venta interna</option>
                                <option value="2">Venta por Afiliados</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6 d-flex align-items-center justify-content-center text-center flex-wrap">
                    </div>

                    <div id="wrapper__afiliados" class="w-100" style="display: none">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>Afiliado</label>
                                <select name="id_afiliado" class="select2-ajax-afiliados">
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Forma de pago</label>
                            <select class="form-control" name="id_forma_pago" required>
                                <option value="" selected disabled hidden>Seleccione una opción</option>
                                @foreach ($formasPago as $formaPago)
                                    <option value="{{ $formaPago->id }}">
                                        {{ $formaPago->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row form-title-section mb-2">
                    <i class="fas fa-info-circle"></i>
                    <h6>Información de los acompañantes</h6>
                </div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <button type="button" class="btn btn-outline-secondary btn-xs btn-agregar-acompaniante" data-target="wrapper__adultos" data-input-name="adulto"  style="width: 125px;">
                                <i class="fas fa-user-plus mr-2 w-100"></i>
                                Agregar adulto
                            </button>
                            
                            <label class="m-0 ml-2">Adultos</label>
                        </div>

                        <div id="wrapper__adultos">
                            
                        </div>
                    </div>


                    <div class="col-md-12 col-sm-12 mb-3" style="display: none">
                        <div class="d-flex align-items-center mb-2">
                            <button type="button" class="btn btn-outline-secondary btn-xs btn-agregar-acompaniante" data-target="wrapper__menores" data-input-name="menor"  style="width: 125px;">
                                <i class="fas fa-user-plus mr-2 w-100"></i>
                                Agregar menor
                            </button>
                            
                            <label class="m-0 ml-2">Menores</label>
                        </div>

                        <div id="wrapper__menores">

                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12" style="display: none">
                        <div class="d-flex align-items-center mb-2">
                            <button type="button" class="btn btn-outline-secondary btn-xs btn-agregar-acompaniante" data-target="wrapper__infantes" data-input-name="infante"  style="width: 125px;">
                                <i class="fas fa-user-plus mr-2 w-100"></i>
                                Agregar infante
                            </button>
                            
                            <label class="m-0 ml-2">Infantes</label>
                        </div>

                        <div id="wrapper__infantes">
                            
                        </div>
                    </div>
                </div>

                <div id="wrapper__hoteleria" style="display: none">
                    <div class="row form-title-section mt-4 mb-2">
                        <i class="fas fa-info-circle"></i>
                        <h6>Información de la hotelería</h6>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 mb-4">
                            <div class="form-group mb-0">
                                <label>Nombre del hotel</label>
                                <input type="text" name="hotel-nombre" class="form-control" />
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <button type="button" class="btn btn-outline-secondary btn-xs btn-agregar-habitacion" data-target="wrapper__habitaciones" style="width: 125px;">
                                    <i class="fas fa-hotel mr-2 w-100"></i>
                                    Agregar habitación
                                </button>
                                
                                <label class="m-0 ml-2">Habitaciones</label>
                            </div>

                            <div id="wrapper__habitaciones">
                    
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 mb-3">
                            <div class="d-flex align-items-center mb-2">                                
                                <label class="m-0 ml-2">
                                    <i class="fas fa-hotel mr-2"></i>
                                    &nbsp;Distribución de la(s) habitacion(es)
                                </label>
                            </div>

                            <div id="wrapper__distribucion-habitaciones" class="dist-rooms">
                                <ul id="dist-rooms__clients" class="dist-rooms__clients">
                                </ul>

                                <ul id="dist-rooms__rooms" class="dist-rooms__rooms">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button form="form-agregar-reservacion" class="btn btn-primary mx-3" type="submit">
                <i class="fas fa-pencil-alt"></i>
                &nbsp;Agregar reservación
            </button>

            <a href="{{ route('reservacion-excursiones.index') }}" class="btn btn-danger">
                <i class="fas fa-times-circle"></i>
                &nbsp;Cancelar
            </a>
        </div>
    </div>
@stop

@section('plugins.MomentJS', true)
@section('plugins.Select2', true)
@section('plugins.BS_Custom_FileInput', true)
@section('plugins.jQueryUI', true)
@section('plugins.MapboxGL', true)
@section('plugins.MapboxGL_Geocoder', true)

@section('css')
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
@stop

@section('js')
    <script>
        $(function() {
            moment.locale("es-mx");
            $.fn.select2.defaults.set('language', 'es');
            
            // Se inicia el file input custom
            bsCustomFileInput.init();

            mapboxgl.accessToken = 'pk.eyJ1IjoiamF0YS1pbWsiLCJhIjoiY2t4cWZrcWxiNWp3ejJxcnl3ZGsxNGpsOCJ9.8XKJesiS_V1qQwmXcTuOoA';

            const idInterval = setInterval(() => {
                clearInterval(idInterval);
                document.getElementById("resumen-reserva__btn").classList.remove("dn");
            }, 1000);

            let objExcursion = {};

            const resumenBtnOpen = document.getElementById("resumen-reserva__btn");
            const resumenBtnClose = document.getElementById("resumen-reserva__btn-close");
            const resumenContenido = document.getElementById("resumen-reserva__contenido");

            const resumenExcursionNombre = document.getElementById("resumen-reserva__excursion-nombre");
            const resumenTemporadaNombre = document.getElementById("resumen-reserva__excursion-temporada");
            const resumenClaseNombre = document.getElementById("resumen-reserva__excursion-clase");
            const resumenFechaTexto = document.getElementById("resumen-reserva__excursion-fecha");

            function toggleResumen() {
                if (resumenBtnOpen.classList.contains("dn")) {
                    resumenBtnOpen.classList.remove("dn");
                    resumenContenido.classList.remove("open");
                } else {
                    resumenBtnOpen.classList.add("dn");
                    resumenContenido.classList.add("open");
                }
            }

            resumenBtnOpen.addEventListener("click", toggleResumen);
            resumenBtnClose.addEventListener("click", toggleResumen);

            basicValidation();

            const formulario = document.getElementById("form-agregar-reservacion");
            const selectExcursion = document.getElementById("id_excursion");

            const selectTemporada = document.getElementById("id_temporada");
            const selectClases = document.getElementById("id_clase_servicio");
            const selectFechas = document.getElementById("fechas-txt");

            const selectTipoVenta = document.getElementById("tipo_venta");
            const wrapperAfiliados = document.getElementById("wrapper__afiliados");

            const wrapperFechas = document.getElementById("wrapper__inputs-fechas");
            const wrapperFechasPersonalizadas = document.getElementById("wrapper__inputs-fechas-personalizadas");
            const checkboxFechaPersonalizada = document.getElementById("fecha-personalizada");
            const fechaPersonalizadaInicio = document.getElementById("fecha_inicio");
            const fechaPersonalizadaFin = document.getElementById("fecha_fin");

            const checkboxMenores = document.getElementById("menores");
            const checkboxInfantes = document.getElementById("infantes");

            const wrapperAdultos = document.getElementById("wrapper__adultos");
            const wrapperMenores = document.getElementById("wrapper__menores");
            const wrapperInfantes = document.getElementById("wrapper__infantes");

            const contenedorHabitaciones = document.getElementById("cost-season-card__rooms");
            const checkboxHoteleria = document.getElementById("hoteleria");
            const wrapperInfoHoteleria = document.getElementById("wrapper__hoteleria");

            const inputAdultoSencilla =  document.querySelector("input[name='adulto_sencilla']");
            const inputAdultoDoble =  document.querySelector("input[name='adulto_doble']");
            const inputAdultoTriple =  document.querySelector("input[name='adulto_triple']");
            const inputAdultoCuadruple =  document.querySelector("input[name='adulto_cuadruple']");
            const inputMenorSencilla =  document.querySelector("input[name='menor_sencilla']");
            const inputMenorDoble =  document.querySelector("input[name='menor_doble']");
            const inputMenorTriple =  document.querySelector("input[name='menor_triple']");
            const inputMenorCuadruple =  document.querySelector("input[name='menor_cuadruple']");
            const inputInfanteSencilla =  document.querySelector("input[name='infante_sencilla']");
            const inputInfanteDoble =  document.querySelector("input[name='infante_doble']");
            const inputInfanteTriple =  document.querySelector("input[name='infante_triple']");
            const inputInfanteCuadruple =  document.querySelector("input[name='infante_cuadruple']");
            
            const checkboxVuelos = document.getElementById("vuelos");

            const buttonsAgregarAcompaniante =document.getElementsByClassName("btn-agregar-acompaniante");
            const buttonsAgregarHabitacion =document.getElementsByClassName("btn-agregar-habitacion");

            var $clients = $("#dist-rooms__clients"), $habitaciones = $("#dist-rooms__rooms > li > .dist-rooms__room-droppable");

            function calcularPreciosFinales () {
                const monedaIso = document.getElementById("iso_moneda").value.toUpperCase();
                let descuento = 0;
                let tipoDescuento = 0;

                if (promocionExcursion.validity === true) {
                    if (promocionExcursion.promocion.descuento === 1) {
                        descuento = Number(promocionExcursion.promocion.valor_promocion);
                        tipoDescuento = promocionExcursion.promocion.tipo_descuento;
                    }
                }

                let subtotal = 0;
                let totalVuelos = 0;
                let htmlResumen = "";

                if (checkboxHoteleria.checked) {
                    let arrHabitaciones = [];
                    const habitaciones = document.getElementById("dist-rooms__rooms");

                    for (let [indexHabitacion, habitacion] of Object.entries(habitaciones.children)) {
                        habitacion = habitacion.querySelector(".dist-rooms__room-droppable");

                        const habitacionId = habitacion.getAttribute("data-habitacion-id");
                        const contenedorHabitacion = document.querySelector(`input[name='habitacion-id[]'][value='${habitacionId}']`).parentElement;
                        const tipoHabitacion = contenedorHabitacion.querySelector(`select[name='habitacion-tipo[]']`).value;

                        if (tipoHabitacion === "") {
                            continue;
                        }

                        arrHabitaciones.push(
                            {
                                id: indexHabitacion,
                                tipo: tipoHabitacion,
                                pasajeros: {
                                    adulto: 0,
                                    menor: 0,
                                    infante: 0
                                }
                            }
                        );
                                                
                        const pasajerosHabitacion = habitacion.querySelectorAll(".dist-rooms__client");

                        for (let pasajeroHabitacion of pasajerosHabitacion) {
                            if (pasajeroHabitacion.id === "draggable-pax-client") {
                                arrHabitaciones[arrHabitaciones.length - 1].pasajeros["adulto"] += 1;

                                continue;
                            } 

                            const pasajeroId = pasajeroHabitacion.getAttribute("data-pax-id");
                            const pasajeroTipo = document.querySelector(`.item-list[data-pax-id='${pasajeroId}']`).getAttribute("data-pax-type");
                            
                            if (pasajeroTipo === "menor" && !checkboxMenores.checked) {
                                continue;
                            }
                            
                            if (pasajeroTipo === "infante" && !checkboxInfantes.checked) {
                                continue;
                            }
                            
                            arrHabitaciones[arrHabitaciones.length - 1].pasajeros[pasajeroTipo] += 1;
                        }
                    }

                    htmlResumen = '<h5 class="resumen-reserva__subtitles">Habitaciones</h5>';
                    for (let habitacion of arrHabitaciones) {
                        if ((habitacion.pasajeros.adulto + habitacion.pasajeros.menor + habitacion.pasajeros.infante) > 0) {
                            htmlResumen += `
                            <ul>
                                <li class="resumen-reserva__subtitles">
                                ${habitacion.tipo[0].toUpperCase() + habitacion.tipo.slice(1)}

                                <ul>
                                    <li class="resumen-reserva__pasajero-precios">
                                        <span>Descripción</span>
                                        <span>Precio Unit.</span>
                                        <span>Precio Total</span>
                                    </li>
                            `;
                        }

                        for (let [tipoPasajero, pasajeroCantidad] of Object.entries(habitacion.pasajeros)) {
                            if (pasajeroCantidad === 0) {
                                continue;
                            }

                            const habitacionPrecios = document.querySelector(`.cost-season-card__room[data-room-type='${habitacion.tipo}']`);
                            const precioPasajero = habitacionPrecios.querySelector(`input[data-pax-type='${tipoPasajero}']`).value;

                            subtotal += Number(precioPasajero * pasajeroCantidad);
                            htmlResumen += `<li class="resumen-reserva__pasajero-precios">
                                                            <span>${pasajeroCantidad} x ${tipoPasajero[0].toUpperCase() + tipoPasajero.slice(1)}</span>
                                                            <span>$ ${formatearMoneda(precioPasajero)} ${monedaIso}</span>
                                                            <span>$ ${formatearMoneda(precioPasajero * pasajeroCantidad)} ${monedaIso}</span>
                                                        </li>`;
                        }

                        htmlResumen += `
                                </ul>
                            </ul>
                        `;
                    }
                } else {
                    const contenedorPrecios = document.querySelector(`.cost-season-card__room[data-room-type='sencilla']`);

                    let cantidadAdultos = wrapperAdultos.childElementCount;
                    const precioAdulto = contenedorPrecios.querySelector(`input[data-pax-type='adulto']`).value;
                    
                    const cantidadMenores = (checkboxMenores.checked) ? wrapperMenores.childElementCount : 0;
                    const precioMenor = contenedorPrecios.querySelector(`input[data-pax-type='menor']`).value;
                    
                    const cantidadInfantes = (checkboxInfantes.checked) ? wrapperInfantes.childElementCount : 0;
                    const precioInfante = contenedorPrecios.querySelector(`input[data-pax-type='infante']`).value;

                    if (document.querySelector("select[name='id_cliente']").value !== "") {
                        cantidadAdultos += 1;
                    }

                    if ((cantidadAdultos + cantidadMenores + cantidadInfantes) > 0) {
                        htmlResumen += `
                        <h5 class="resumen-reserva__subtitles">Pasajeros</h5>

                        <ul>
                            <li class="font-weight-bold resumen-reserva__pasajero-precios">
                                <span>Descripción</span>
                                <span>Precio Unit.</span>
                                <span>Precio Total</span>
                            </li>
                        `;

                        if (cantidadAdultos > 0) {
                            subtotal += precioAdulto * cantidadAdultos;
                            htmlResumen += `
                                <li class="resumen-reserva__pasajero-precios">
                                    <span>${cantidadAdultos} x Adultos</span> <span>$ ${formatearMoneda(precioAdulto)} ${monedaIso}</span> <span>$ ${formatearMoneda(precioAdulto * cantidadAdultos)} ${monedaIso}</span>
                                </li>
                            `;
                        }

                        if (cantidadMenores > 0) {
                            subtotal += precioMenor * cantidadMenores;

                            htmlResumen += `
                                <li class="resumen-reserva__pasajero-precios">
                                    <span>${cantidadMenores} x Menores</span> <span>$ ${formatearMoneda(precioMenor)} ${monedaIso}</span> <span>$ ${formatearMoneda(precioMenor * cantidadMenores)} ${monedaIso}</span>
                                </li>
                            `;
                        }
                        
                        if (cantidadInfantes > 0) {
                            subtotal += precioInfante * cantidadInfantes;
                            htmlResumen += `
                                <li class="resumen-reserva__pasajero-precios">
                                    <span>${cantidadInfantes} x Infantes</span> <span>$ ${formatearMoneda(precioInfante)} ${monedaIso}</span> <span>$ ${formatearMoneda(precioInfante * cantidadInfantes)} ${monedaIso}</span>
                                </li>
                            `;
                        }

                        htmlResumen += `
                        </ul>
                        `;
                    }
                }

                if ((objExcursion.vuelos == 0) && (checkboxVuelos.checked)) {
                    const inputsVuelosPrecios = document.querySelectorAll("[data-input-vuelo-precio]");
                    for (const inputVueloPrecio of inputsVuelosPrecios) {
                        totalVuelos += Number(inputVueloPrecio.value);
                    }

                    htmlResumen += `
                    <h5 class="mt-4 resumen-reserva__subtitles">Vuelos </h5>

                        <ul>
                            <li class="font-weight-bold resumen-reserva__pasajero-precios">
                                <span>Descripción</span>
                                <span>Precio Unit.</span>
                                <span>Precio Total</span>
                            </li>
                            
                            <li class="resumen-reserva__pasajero-precios">
                                <span style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;">Vuelos pasajeros (Total)</span>
                                <span>$ ${formatearMoneda(totalVuelos)} ${monedaIso}</span>
                                <span>$ ${formatearMoneda(totalVuelos)} ${monedaIso}</span>
                            </li>
                        </ul>
                    `;
                }

                if ((htmlResumen !== '') && (htmlResumen !== '<h5 class="resumen-reserva__subtitles">Habitaciones</h5>')) {
                    document.getElementById("resumen-reserva__body").innerHTML = htmlResumen;

                    // Totales
                    document.getElementById("resumen-reserva__subtotal").textContent = formatearMoneda(subtotal);

                    if (tipoDescuento === 1) {
                        document.getElementById("resumen-reserva__descuento").textContent = `(${descuento}%) $ ${formatearMoneda( subtotal * (descuento / 100) )}`;
                        document.getElementById("resumen-reserva__total").textContent = formatearMoneda((subtotal * (1 - (descuento / 100))) + totalVuelos);
                    } else if (tipoDescuento === 2) {
                        document.getElementById("resumen-reserva__descuento").textContent = `$ ${formatearMoneda(descuento)}`;
                        document.getElementById("resumen-reserva__total").textContent = formatearMoneda(subtotal + totalVuelos - descuento);
                    } else {
                        document.getElementById("resumen-reserva__descuento").textContent = formatearMoneda(0);
                        document.getElementById("resumen-reserva__total").textContent = formatearMoneda(subtotal + totalVuelos);
                    }

                    //Vuelos
                    document.getElementById("resumen-reserva__vuelos").style.display = ((objExcursion.vuelos == 0) && (checkboxVuelos.checked)) ? "flex" : "none";
                    document.getElementById("resumen-reserva__vuelos-span").textContent = ((objExcursion.vuelos == 0) && (checkboxVuelos.checked)) ? formatearMoneda(totalVuelos) : formatearMoneda(0);
                } else {
                    document.getElementById("resumen-reserva__body").innerHTML = "";
                }
            }

            function deleteClient(event, $item) {
                $item.fadeOut(function () {
                    var $list = event.target;
                    $item
                        .css({
                            position: "relative",
                            top: "unset",
                            left: "unset"
                        })
                        .appendTo($list)
                        .fadeIn();

                    calcularPreciosFinales();
                });
            }

            // Image recycle function
            function restoreClient($item) {
                $item.fadeOut(function () {
                    $item
                        .css({
                            position: "relative",
                            top: "unset",
                            left: "unset"
                        })
                        .appendTo($clients)
                        .fadeIn();

                    calcularPreciosFinales();
                });
            }

            function dragAndDropClientsRooms () {
                $("li", $clients).draggable({
                    cancel: "a.ui-icon", // clicking an icon won't initiate dragging
                    revert: "invalid", // when not dropped, the item will revert back to its initial position
                    containment: "document",
                    helper: "original",
                });

                $habitaciones = $("#dist-rooms__rooms > li > .dist-rooms__room-droppable");

                $habitaciones.droppable({
                    accept: "#dist-rooms__clients > li",
                    classes: {
                        "ui-droppable-active": "ui-state-highlight"
                    },
                    drop: function (event, ui) {
                        deleteClient(event, ui.draggable);
                    }
                });

                $clients.droppable({
                    accept: "#dist-rooms__rooms .dist-rooms__client",
                    classes: {
                        "ui-droppable-active": "custom-state-active"
                    },
                    drop: function (event, ui) {
                        restoreClient(ui.draggable);
                    }
                });
            }

            const wrapperClientesDraggable = document.getElementById("dist-rooms__clients");
            const wrapperRoomsDroppable = document.getElementById("dist-rooms__rooms");

            let promocionExcursion = {
                excursionPromocion: [],
                promocion: {},
                validity: false
            };

            function addSelect2Airlines(cssSelector) {
                $(cssSelector).select2({
                    ajax: {
                        url: `{{ route('api-v1-aerolineas.index') }}`,
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            var query = {
                                term: params.term,
                                q: params.term
                            }

                            // Query parameters will be ?search=[term]&type=public
                            return query;
                        },
                        processResults: function(data) {
                            // Transforms the top-level key of the response object from 'items' to 'results'
                            return {
                                results: data.body.aerolineas
                            };
                        },
                        // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                    },
                    placeholder: 'Buscar aerolínea...',
                    minimumInputLength: 3,
                    width: "100%",
                    templateResult: formatRepoAirlines,
                    templateSelection: formatRepoSelectionAirline,
                });
            }

            function formatRepoAirlines(repo) {
                if (repo.loading) {
                    return repo.text;
                }

                var $container = $(
                    "<div class='select2-result-repository clearfix'>" +
                    "<div class='select2-result-repository__meta' style='margin-left: 0'>" +
                    "<div class='select2-result-repository__title'></div>" +
                    "<div class='select2-result-repository__statistics'>" +
                    "<div class='select2-result-repository__forks'><i class='fas fa-passport'></i> </div>" +
                    "<div class='select2-result-repository__stargazers'><i class='fas fa-bullhorn'></i> </div>" +
                    "<div class='select2-result-repository__watchers'><i class='fas fa-flag'></i></i> </div>" +
                    "</div>" +
                    "</div>" +
                    "</div>"
                );

                $container.find(".select2-result-repository__title").text(repo.name);
                $container.find(".select2-result-repository__forks").append((repo.icao !== "") ? repo.icao : repo.iata);
                $container.find(".select2-result-repository__stargazers").append(repo.callsign);
                $container.find(".select2-result-repository__watchers").append(repo.country);

                return $container;
            }

            function formatRepoSelectionAirline(repo) {
                return repo.name || repo.text;
            }

            // Select2 clientes
            $('.select2-ajax-cliente').select2({
                ajax: {
                    url: `{{ route('clientes.index') }}`,
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        var query = {
                            term: params.term,
                            q: params.term,
                            api: "true"
                        }

                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    },
                    processResults: function(data) {
                        // Transforms the top-level key of the response object from 'items' to 'results'
                        return {
                            results: data.body.clientes
                        };
                    },
                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                },
                placeholder: 'Búsqueda de clientes por nombre, numero telefónico o correo...',
                minimumInputLength: 5,
                width: "100%",
                templateResult: formatRepo,
                templateSelection: formatRepoSelection,
            });

            function formatRepo(repo) {
                if (repo.loading) {
                    return repo.text;
                }

                var $container = $(
                    "<div class='select2-result-repository clearfix'>" +
                    "<div class='select2-result-repository__meta' style='margin-left: 0'>" +
                    "<div class='select2-result-repository__title'></div>" +
                    "<div class='select2-result-repository__statistics'>" +
                    "<div class='select2-result-repository__forks'><i class='fas fa-phone-alt'></i> </div>" +
                    "<div class='select2-result-repository__stargazers'><i class='fas fa-envelope'></i> </div>" +
                    "</div>" +
                    "</div>" +
                    "</div>"
                );

                $container.find(".select2-result-repository__title").text(repo.nombre_completo);
                $container.find(".select2-result-repository__forks").append(repo.telefono_celular_codigo_pais + " " + repo.telefono_celular);
                $container.find(".select2-result-repository__stargazers").append(repo.email_principal);

                return $container;
            }

            function formatRepoSelection(repo) {
                document.getElementById("id_ejecutivo").value = repo.id_ejecutivo;

                if ((repo.id !== "")) {
                    if (document.getElementById("draggable-pax-client")) {
                        document.getElementById("draggable-pax-client").textContent = repo.nombre_completo;
                    } else {
                        let templateLi = ` <li id="draggable-pax-client" class="dist-rooms__client">${repo.nombre_completo}</li>`;
                        wrapperClientesDraggable.insertAdjacentHTML('beforeend', templateLi);
                    }
                    
                    document.getElementById("resumen-reserva__cliente").innerHTML = `Titular de la reserva: <span>${repo.nombre_completo}</span>`;
                    dragAndDropClientsRooms();
                    calcularPreciosFinales();
                }

                return repo.nombre_completo || repo.text;
            }
            
            // Select2 Afiliados
            $('.select2-ajax-afiliados').select2({
                ajax: {
                    url: `{{ route('afiliados.index') }}`,
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        var query = {
                            term: params.term,
                            q: params.term,
                            api: "true"
                        }

                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    },
                    processResults: function(data) {
                        // Transforms the top-level key of the response object from 'items' to 'results'
                        return {
                            results: data.body.afiliados
                        };
                    },
                    // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
                },
                placeholder: 'Búsqueda de afiliados por nombre comercial, razón social, numero telefónico o RFC...',
                minimumInputLength: 5,
                width: "100%",
                templateResult: formatRepoAfiliados,
                templateSelection: formatRepoSelectionAfiliados,
            });

            function formatRepoAfiliados(repo) {
                if (repo.loading) {
                    return repo.text;
                }

                var $container = $(
                    "<div class='select2-result-repository clearfix'>" +
                        "<div class='select2-result-repository__meta' style='margin-left: 0'>" +
                            "<div class='select2-result-repository__title'></div>" +
                            "<div class='select2-result-repository__statistics'>" +
                                "<div class='select2-result-repository__stargazers'><i class='fas fa-building'></i> </div>" +
                                "<div class='select2-result-repository__forks'><i class='fas fa-phone-alt'></i> </div>" +
                            "</div>" +
                        "</div>" +
                    "</div>"
                );

                $container.find(".select2-result-repository__title").text(repo.razon_social + " (" + repo.rfc + ")");
                $container.find(".select2-result-repository__stargazers").append(repo.nombre_comercial);
                $container.find(".select2-result-repository__forks").append(repo.telefono_celular_codigo_pais + " " + repo.telefono_celular);

                return $container;
            }

            function formatRepoSelectionAfiliados(repo) {

                return repo.razon_social || repo.text;
            }

            function handleChangeTipoVenta() {
                if (selectTipoVenta.value === "1") {
                    wrapperAfiliados.style.display = "none";
                } else {
                    wrapperAfiliados.style.display = "block";
                }
            }

            function handleValueHoteleria() {
                wrapperInfoHoteleria.style.display = (!checkboxHoteleria.checked) ? "none" : "block";

                const inputsHoteleria = wrapperInfoHoteleria.querySelectorAll("input");
                for (let i = 0, l = inputsHoteleria.length; i < l; i++) {
                    inputsHoteleria[i].required = checkboxHoteleria.checked;
                }

                for (let i = 0, l = contenedorHabitaciones.children.length; i < l; i++) {
                    if (i === 0) { // Primer tarjeta de precios
                        const title = contenedorHabitaciones.children[i].querySelector(".card-title");
                        title.style.display = (!checkboxHoteleria.checked) ? "none" : "block";
                    } else {
                        contenedorHabitaciones.children[i].style.display = (!checkboxHoteleria.checked) ? "none" : "flex";
                    }
                }

                basicValidation();
            }

            function handleChangeCheckboxMenores() {
                const inputsMenores = document.querySelectorAll(".input-menor");

                for (let input of inputsMenores) {
                    input.parentElement.parentElement.style.display = (checkboxMenores.checked) ? "block" : "none";
                    input.required = !checkboxMenores.checked;
                }

                wrapperMenores.parentElement.style.display = (checkboxMenores.checked) ? "block" : "none";

                // Se ocultan los menores de las habitaciones
                const menoresContenedores = wrapperMenores.querySelectorAll("[data-pax-id]");

                for (const menorContenedor of menoresContenedores) {
                    const menorId = menorContenedor.getAttribute("data-pax-id");

                    const draggablePax = document.getElementById(`draggable-pax-${menorId}`);
                    draggablePax.style.display = checkboxMenores.checked ? "inline-block" : "none";
                }

                const inputs = wrapperMenores.querySelectorAll("input, select");
                
                for (let input of inputs) {
                    input.required = checkboxMenores.checked;
                }

                if (checkboxMenores.checked) {
                    handleValueVuelos();
                }

                calcularPreciosFinales();
            }

            function handleChangeCheckboxInfantes() {
                const inputsInfantes = document.querySelectorAll(".input-infante");

                for (let input of inputsInfantes) {
                    input.parentElement.parentElement.style.display = (checkboxInfantes.checked) ? "block" : "none";
                    input.required = !checkboxInfantes.checked;
                }

                wrapperInfantes.parentElement.style.display = (checkboxInfantes.checked) ? "block" : "none";

                // Se ocultan los menores de las habitaciones
                const infantesContenedores = wrapperInfantes.querySelectorAll("[data-pax-id]");

                for (const menorContenedor of infantesContenedores) {
                    const infanteId = menorContenedor.getAttribute("data-pax-id");

                    const draggablePax = document.getElementById(`draggable-pax-${infanteId}`);
                    draggablePax.style.display = checkboxInfantes.checked ? "inline-block" : "none";
                }

                const inputs = wrapperInfantes.querySelectorAll("input, select");
                
                for (let input of inputs) {
                    input.required = checkboxInfantes.checked;
                }

                if (checkboxInfantes.checked) {
                    handleValueVuelos();
                }

                calcularPreciosFinales();
            }

            function handleValueVuelos() {
                const contenedoresInfoVuelos = document.querySelectorAll(".contenedor-info-vuelos, #wrapper-cliente-vuelos");

                for (let contenedorInfoVuelos of contenedoresInfoVuelos) {
                    contenedorInfoVuelos.style.display = (!checkboxVuelos.checked) ? "none" : "flex";

                    const inputsInfoVuelo = contenedorInfoVuelos.querySelectorAll("input, select");

                    for (let inputInfoVuelo of inputsInfoVuelo) {
                        if (inputInfoVuelo.type === "number") {
                            inputInfoVuelo.parentElement.parentElement.style.visibility = ((objExcursion.vuelos == 0) && (checkboxVuelos.checked)) ? "visible" : "hidden";
                            inputInfoVuelo.required = ((objExcursion.vuelos == 0) && (checkboxVuelos.checked));
                        } else {
                            inputInfoVuelo.required = checkboxVuelos.checked;
                        }
                    }
                }

                basicValidation();
                calcularPreciosFinales();
            }

            function addGeocoderToInput(selectorContainer, inputName, boolRequired) {
                const geocoder = new MapboxGeocoder({
                    accessToken: mapboxgl.accessToken,
                    types: 'place',
                    placeholder: 'Buscar...',
                    minLength: 5
                });

                geocoder.addTo(selectorContainer);
                const geocoderInput = geocoder.container.querySelector("input");
                geocoderInput.name = inputName;
                geocoderInput.className = "mapboxgl-ctrl-geocoder--input form-control pl-5";
                geocoderInput.parentElement.className = "mapboxgl-ctrl-geocoder mapboxgl-ctrl w-100 min-width-unset max-width-none shadow-none p-0";
                geocoderInput.autocomplete = 'nope';
                geocoderInput.required = boolRequired;

                // Default value
                geocoderInput.value = document.querySelector(selectorContainer).getAttribute("data-geocoder-default-value");

                // Add geocoder result to container.
                geocoder.on('result', (e) => {
                    geocoderInput.value = e.result.place_name;
                });

                // Clear results container when search is cleared.
                geocoder.on('clear', () => {
                    geocoder.container.parentElement.parentElement.querySelector(".results").innerText = '';
                });
            }
            
            function handleChangeExcursion() {
                selectTemporada.innerHTML   = '<option value="" selected disabled hidden> Primero seleccione una excursión </option>';
                selectClases.innerHTML      = '<option value="" selected disabled hidden> Primero seleccione una temporada </option>';
                selectFechas.innerHTML      = '<option value="" selected disabled hidden> Primero seleccione una clase </option>';
                
                resumenExcursionNombre.textContent = selectExcursion.options[selectExcursion.selectedIndex].textContent.trim();
                resumenTemporadaNombre.textContent = "";
                resumenClaseNombre.textContent = "";
                resumenFechaTexto.textContent = "";

                for (const input of contenedorHabitaciones.querySelectorAll("input[type='number']")) {
                    input.value = "";
                }

                basicValidation();
            }

            function validarPromocion () {
                promocionExcursion.validity = false;
                
                if (promocionExcursion.excursionPromocion.length === 0) {
                    return;
                }

                // Se comprueba la validez de la promoción
                if (promocionExcursion.excursionPromocion[0].booking_window_inicio !== null) {                                
                    const [anioBWI, mesBWI, diaBWI] = promocionExcursion.excursionPromocion[0].booking_window_inicio.split("-");
                    const dateBWI = new Date(anioBWI, mesBWI - 1, diaBWI);
                    
                    const [anioBWF, mesBWF, diaBWF] = promocionExcursion.excursionPromocion[0].booking_window_fin.split("-");
                    const dateBWF = new Date(anioBWF, mesBWF - 1, diaBWF);
                    dateBWF.setDate(dateBWF.getDate() + 1);
                    
                    if ( (Date.now() >= dateBWI.getTime()) && (Date.now() < dateBWF.getTime()) ) {
                        if (promocionExcursion.excursionPromocion[0].travel_window_inicio === null) {
                            promocionExcursion.validity = true;
                        }
                    }
                } else if (promocionExcursion.excursionPromocion[0].vigencia !== null) {
                    const [anioVigencia, mesVigencia, diaVigencia] = promocionExcursion.excursionPromocion[0].vigencia.split("-");
                    const dateVigencia = new Date(anioVigencia, mesVigencia - 1, diaVigencia);
                    dateVigencia.setDate(dateVigencia.getDate() + 1);

                    if ((Date.now() < dateVigencia.getTime())) {
                        promocionExcursion.validity = true;
                    }
                }
            }

            function validarPromocionFechas () {
                if (promocionExcursion.excursionPromocion.length === 0) {
                    return;
                }

                if (checkboxFechaPersonalizada.checked) {
                    resumenTemporadaNombre.textContent = "";
                    resumenClaseNombre.textContent = "";

                    if ((fechaPersonalizadaInicio.value === "") || (fechaPersonalizadaFin.value === "")) {
                        promocionExcursion.validity = false;
                        resumenFechaTexto.textContent = "";
                    } else {
                        const [anioFechaSeleccionada, mesFechaSeleccionada, diaFechaSeleccionada] = fechaPersonalizadaInicio.value.split("-");
                        const dateFechaSeleccionada = new Date(anioFechaSeleccionada, mesFechaSeleccionada - 1, diaFechaSeleccionada);

                        if (promocionExcursion.excursionPromocion.length > 0) {
                            if (promocionExcursion.excursionPromocion[0].travel_window_inicio !== null) {
                                const [anioTWI, mesTWI, diaTWI] = promocionExcursion.excursionPromocion[0].travel_window_inicio.split("-");
                                const dateTWI = new Date(anioTWI, mesTWI - 1, diaTWI);
            
                                const [anioTWF, mesTWF, diaTWF] = promocionExcursion.excursionPromocion[0].travel_window_fin.split("-");
                                const dateTWF = new Date(anioTWF, mesTWF - 1, diaTWF);
                                dateTWF.setDate(dateTWF.getDate() + 1);
                
                                if ( (dateFechaSeleccionada.getTime() >= dateTWI.getTime()) && (dateFechaSeleccionada.getTime() < dateTWF.getTime()) ) {
                                    promocionExcursion.validity = true;
                                } else {
                                    promocionExcursion.validity = false;
                                }
                            }
                        }

                        let fechaInicioFormat = moment(fechaPersonalizadaInicio.value, "YYYY-MM-DD").format("DD [de] MMMM [del] YYYY").split(" ");

                        fechaInicioFormat[2] = fechaInicioFormat[2][0].toUpperCase() + fechaInicioFormat[2].substr(1);
                        fechaInicioFormat = fechaInicioFormat.join(" ");

                        let fechaFinFormat = moment(fechaPersonalizadaFin.value, "YYYY-MM-DD").format("DD [de] MMMM [del] YYYY").split(" ");
                        fechaFinFormat[2] = fechaFinFormat[2][0].toUpperCase() + fechaFinFormat[2].substr(1);
                        fechaFinFormat = fechaFinFormat.join(" ");

                        resumenFechaTexto.textContent = fechaInicioFormat + " al " + fechaFinFormat;
                    }
                } else {
                    const [anioFechaSeleccionada, mesFechaSeleccionada, diaFechaSeleccionada] = selectFechas.value.split(",")[0].split("-");
                    const dateFechaSeleccionada = new Date(anioFechaSeleccionada, mesFechaSeleccionada - 1, diaFechaSeleccionada);

                    if (promocionExcursion.excursionPromocion.length > 0) {
                        if (promocionExcursion.excursionPromocion[0].travel_window_inicio !== null) {
                            const [anioTWI, mesTWI, diaTWI] = promocionExcursion.excursionPromocion[0].travel_window_inicio.split("-");
                            const dateTWI = new Date(anioTWI, mesTWI - 1, diaTWI);
        
                            const [anioTWF, mesTWF, diaTWF] = promocionExcursion.excursionPromocion[0].travel_window_fin.split("-");
                            const dateTWF = new Date(anioTWF, mesTWF - 1, diaTWF);
                            dateTWF.setDate(dateTWF.getDate() + 1);
            
                            if ( (dateFechaSeleccionada.getTime() >= dateTWI.getTime()) && (dateFechaSeleccionada.getTime() < dateTWF.getTime()) ) {
                                promocionExcursion.validity = true;
                            } else {
                                promocionExcursion.validity = false;
                            }
                        }
                    }

                    if (selectTemporada.value !== "") {
                        resumenTemporadaNombre.textContent = "Temporada " + selectTemporada.options[selectTemporada.selectedIndex].textContent.trim() + ",";
                    } else {
                        resumenTemporadaNombre.textContent = "";
                    }

                    if (selectClases.value !== "") {
                        resumenClaseNombre.textContent = selectClases.options[selectClases.selectedIndex].textContent.trim();
                    } else {
                        resumenClaseNombre.textContent = "";
                    }

                    if (selectFechas.value !== "") {
                        resumenFechaTexto.textContent = selectFechas.options[selectFechas.selectedIndex].textContent.replaceAll(String.fromCharCode(160), "").trim();
                    } else {
                        resumenFechaTexto.textContent = "";
                    }
                }
            }
            
            function handleChangeFechaPersonalizada () {
                if (checkboxFechaPersonalizada.checked) {
                    wrapperFechas.style.setProperty("display", "none", "important");
                    for (const select of wrapperFechas.querySelectorAll("select")) {
                        select.required = false;
                    }
                    
                    wrapperFechasPersonalizadas.style.setProperty("display", "flex", "important");
                    for (const input of wrapperFechasPersonalizadas.querySelectorAll("input")) {
                        input.required = true;
                    }
                } else {
                    wrapperFechas.style.setProperty("display", "flex", "important");
                    for (const select of wrapperFechas.querySelectorAll("select")) {
                        select.required = true;
                    }

                    wrapperFechasPersonalizadas.style.setProperty("display", "none", "important");
                    for (const input of wrapperFechasPersonalizadas.querySelectorAll("input")) {
                        input.required = false;
                    }
                }

                basicValidation();
                validarPromocionFechas();
                calcularPreciosFinales();
            }
            
            checkboxFechaPersonalizada.addEventListener("change", handleChangeFechaPersonalizada);

            fechaPersonalizadaInicio.addEventListener("change", () => {
                validarPromocionFechas();
                calcularPreciosFinales();
            });

            fechaPersonalizadaFin.addEventListener("change", () => {
                validarPromocionFechas();
                calcularPreciosFinales();
            });

            checkboxMenores.addEventListener("change", handleChangeCheckboxMenores);
            checkboxInfantes.addEventListener("change", handleChangeCheckboxInfantes);

            selectTipoVenta.addEventListener("change", handleChangeTipoVenta);
            checkboxHoteleria.addEventListener("change", () => {
                handleValueHoteleria();
                calcularPreciosFinales();
            });

            checkboxVuelos.addEventListener("change", handleValueVuelos);

            addGeocoderToInput(`#wrapper-cliente-vuelos div[data-vuelo-llegada-ciudad-origen]`, `cliente-vuelo-llegada-ciudad-origen[]`, checkboxVuelos.checked);
            addGeocoderToInput(`#wrapper-cliente-vuelos div[data-vuelo-llegada-ciudad-destino]`, `cliente-vuelo-llegada-ciudad-destino[]`, checkboxVuelos.checked);
            addGeocoderToInput(`#wrapper-cliente-vuelos div[data-vuelo-regreso-ciudad-origen]`, `cliente-vuelo-regreso-ciudad-origen[]`, checkboxVuelos.checked);
            addGeocoderToInput(`#wrapper-cliente-vuelos div[data-vuelo-regreso-ciudad-destino]`, `cliente-vuelo-regreso-ciudad-destino[]`, checkboxVuelos.checked);

            addSelect2Airlines(`#wrapper-cliente-vuelos select[data-vuelo-llegada-id-aerolinea]`);
            addSelect2Airlines(`#wrapper-cliente-vuelos select[data-vuelo-regreso-id-aerolinea]`);

            const inputsVuelosPrecios = document.querySelectorAll(`[data-input-vuelo-precio]`);
                
            for (const inputVueloPrecio of inputsVuelosPrecios) {
                inputVueloPrecio.addEventListener("change", calcularPreciosFinales);
            }

            selectExcursion.addEventListener("change", (event) => {
                handleChangeExcursion();

                const idExcursion = selectExcursion.value;

                fetch(`admin/excursiones/${idExcursion}`)
                    .then(res => res.json())
                    .then(data => {
                        const infoExcursion = data.body;
                        
                        const excursion = infoExcursion.excursion;
                        objExcursion = excursion;

                        checkboxMenores.checked = (Number(excursion.menores) === 1);
                        checkboxInfantes.checked = (Number(excursion.infantes) === 1);
                        checkboxHoteleria.checked = (Number(excursion.hoteleria) === 1);
                        checkboxVuelos.checked = (Number(excursion.vuelos) === 1);

                        const customEvent = new Event("change");

                        checkboxMenores.dispatchEvent(customEvent);
                        checkboxInfantes.dispatchEvent(customEvent);
                        checkboxHoteleria.dispatchEvent(customEvent);
                        checkboxVuelos.dispatchEvent(customEvent);

                        const infoMoneda = infoExcursion.moneda;
                        document.getElementById("id_moneda").value = infoMoneda.id;
                        document.getElementById("iso_moneda").value = infoMoneda.iso;
                        document.getElementById("moneda_nombre").value = `${infoMoneda.nombre} (${infoMoneda.iso})`;

                        for (let spanIso of document.querySelectorAll(".resumen-reserva__iso-moneda")) {
                            spanIso.textContent = infoMoneda.iso.toUpperCase();
                        }

                        const excursionPromocion = infoExcursion.promocion;
                        promocionExcursion.excursionPromocion = excursionPromocion;
                        promocionExcursion.promocion = {};
                        
                        if (excursionPromocion.length === 0) {
                            document.getElementById("info-excursion__promocion").value = "Esta excursion no tiene promociones";
                            document.getElementById("resumen_promocion").style.display = "none";

                            calcularPreciosFinales();
                        } else {
                            validarPromocion();

                            fetch("{{ route('promociones.index') }}" + "/" + excursionPromocion[0].id_promocion)
                                .then(res => res.json())
                                .then(data => {
                                    promocionExcursion.promocion = data;

                                    document.getElementById("info-excursion__promocion").value = data.nombre + " | " + data.descripcion;
                                    document.getElementById("id_promocion").value = data.id;
                                    document.getElementById("resumen_promocion").style.display = "block";

                                    const descuento = data.descuento; //0: No aplica 1: si aplica descuentos
                                    const tipo = data.tipo_descuento; //1: Porcentaje, 2: Monto.
                                    const monto = data.valor_promocion;

                                    let txtDescuento = "";
                                    let txtTipoDescuento = "";
                                    let txtMontoDescuento = "";

                                    if (Number(descuento) === 0) {
                                        txtDescuento = "No";
                                        txtTipoDescuento = "No aplica";
                                        txtMontoDescuento = "No aplica";
                                    } else {
                                        txtDescuento = "Si";
                                        if (Number(tipo) === 1) {
                                            txtTipoDescuento = "Por porcentaje";
                                        } else {
                                            txtTipoDescuento = "Por monto fijo";
                                        }
                                        if (Number(tipo) === 1) {
                                            txtMontoDescuento = monto + " %";
                                        } else {
                                            txtMontoDescuento = "$" + monto;
                                        }
                                    }

                                    let cadena = "¿Se aplica descuento?: " + txtDescuento + " (" + txtTipoDescuento +")";
                                    cadena += "<br>Monto del descuento: " + txtMontoDescuento;

                                    if (excursionPromocion[0].travel_window_inicio !== null) {
                                        cadena += `<br><br>Aplica viajando en las fechas:<br>`;

                                        let fechaInicioFormat = moment(excursionPromocion[0].travel_window_inicio, "YYYY-MM-DD").format("DD [de] MMMM [del] YYYY").split(" ");

                                        fechaInicioFormat[2] = fechaInicioFormat[2][0].toUpperCase() + fechaInicioFormat[2].substr(1);
                                        fechaInicioMes = fechaInicioFormat[2];
                                        fechaInicioFormat = fechaInicioFormat.join(" ");

                                        let fechaFinFormat = moment(excursionPromocion[0].travel_window_fin, "YYYY-MM-DD").format("DD [de] MMMM [del] YYYY").split(" ");
                                        fechaFinFormat[2] = fechaFinFormat[2][0].toUpperCase() + fechaFinFormat[2].substr(1);
                                        fechaFinFormat = fechaFinFormat.join(" ");

                                        cadena += `${fechaInicioFormat} y ${fechaFinFormat}<br>`;
                                    }

                                    cadena += "<br>Descripción: " + data.descripcion;
                                        
                                    $("#txtDescuento").html(cadena);

                                    calcularPreciosFinales();
                                });
                        }
                    });

                fetch(`admin/excursiones/${idExcursion}/temporadas`)
                    .then(res => res.json())
                    .then(data => {
                        const temporadasExcursion = data.body.temporadas;

                        selectTemporada.innerHTML = "";

                        const optionDefault = document.createElement("option");
                        optionDefault.selected = true;
                        optionDefault.disabled = true;
                        optionDefault.hidden = true;
                        optionDefault.value = "";
                        optionDefault.textContent = "Seleccione una temporada";

                        selectTemporada.appendChild(optionDefault);

                        for (let temporada of temporadasExcursion) {
                            const option = document.createElement("option");
                            option.value = temporada.id;
                            option.textContent = temporada.nombre;

                            selectTemporada.appendChild(option);
                        }
                    });
            });

            selectTemporada.addEventListener("change", (event) => {
                const idExcursion = selectExcursion.value;
                const idTemporada = selectTemporada.value;

                resumenTemporadaNombre.textContent = "Temporada " + selectTemporada.options[selectTemporada.selectedIndex].textContent.trim() + ",";
                resumenClaseNombre.textContent = "";
                resumenFechaTexto.textContent = "";

                promocionExcursion.validity = false;
                calcularPreciosFinales();

                fetch(`admin/excursiones/${idExcursion}/temporadas/${idTemporada}/clases`)
                    .then(res => res.json())
                    .then(data => {
                        const clasesTemporadaExcursion = data.body.clases;

                        selectClases.innerHTML = "";

                        const optionDefault = document.createElement("option");
                        optionDefault.selected = true;
                        optionDefault.disabled = true;
                        optionDefault.hidden = true;
                        optionDefault.value = "";
                        optionDefault.textContent = "Seleccione una clase";

                        selectClases.appendChild(optionDefault);

                        for (let clase of clasesTemporadaExcursion) {
                            const option = document.createElement("option");
                            option.value = clase.id;
                            option.textContent = clase.nombre;

                            selectClases.appendChild(option);
                        }
                    });
            });

            selectClases.addEventListener("change", (event) => {
                const idExcursion = selectExcursion.value;
                const idTemporada = selectTemporada.value;
                const idClase = selectClases.value;

                resumenClaseNombre.textContent = selectClases.options[selectClases.selectedIndex].textContent.trim();
                resumenFechaTexto.textContent = "";

                promocionExcursion.validity = false;
                calcularPreciosFinales();

                fetch( `admin/excursiones/${idExcursion}/fechas?temporadas=${idTemporada}&clases_servicios=${idClase}` )
                    .then(res => res.json())
                    .then(data => {
                        const fechas = data.body.fechas;

                        selectFechas.innerHTML = "";

                        const optionDefault = document.createElement("option");
                        optionDefault.selected = true;
                        optionDefault.disabled = true;
                        optionDefault.hidden = true;
                        optionDefault.value = "";
                        optionDefault.textContent = "Seleccione una fecha";

                        selectFechas.appendChild(optionDefault);

                        for (let fecha of fechas) {
                            const option = document.createElement("option");
                            option.value = fecha.fecha_inicio + "," + fecha.fecha_fin;
                            option.setAttribute("data-id-fecha", fecha.id);

                            let fechaInicioFormat = moment(fecha.fecha_inicio, "YYYY-MM-DD").format("DD [de] MMMM [del] YYYY").split(" ");

                            fechaInicioFormat[2] = fechaInicioFormat[2][0].toUpperCase() + fechaInicioFormat[2].substr(1);
                            fechaInicioMes = fechaInicioFormat[2];
                            fechaInicioFormat = fechaInicioFormat.join(" ");

                            let fechaFinFormat = moment(fecha.fecha_fin, "YYYY-MM-DD").format("DD [de] MMMM [del] YYYY").split(" ");
                            fechaFinFormat[2] = fechaFinFormat[2][0].toUpperCase() + fechaFinFormat[2].substr(1);
                            fechaFinFormat = fechaFinFormat.join(" ");

                            let spacesForAlignDates = "";
                            for (let index = fechaInicioMes.length; index < 10; index++) {
                                spacesForAlignDates += String.fromCharCode(160);
                            }

                            option.textContent = fechaInicioFormat + spacesForAlignDates + " al " + fechaFinFormat;

                            selectFechas.appendChild(option);
                        }
                    });
            });

            selectFechas.addEventListener("change", (event) => {
                validarPromocionFechas();

                document.getElementById("id_fecha").value = selectFechas.options[selectFechas.selectedIndex].getAttribute("data-id-fecha")
                resumenFechaTexto.textContent = selectFechas.options[selectFechas.selectedIndex].textContent.replaceAll(String.fromCharCode(160), "").trim();

                const idExcursion = selectExcursion.value;

                fetch(`admin/excursiones/${idExcursion}/precios?fechas=${selectFechas.value}`)
                    .then(res => res.json())
                    .then(data => {
                        const precios = data.body.precios;

                        const {
                            adulto_sencilla,
                            adulto_doble,
                            adulto_triple,
                            adulto_cuadruple,
                            menor_sencilla,
                            menor_doble,
                            menor_triple,
                            menor_cuadruple,
                            infante_sencilla,
                            infante_doble,
                            infante_triple,
                            infante_cuadruple
                        } = precios;
                        
                        inputAdultoSencilla.value       = adulto_sencilla;
                        inputAdultoDoble.value          = adulto_doble;
                        inputAdultoTriple.value         = adulto_triple;
                        inputAdultoCuadruple.value      = adulto_cuadruple;
                        inputMenorSencilla.value        = menor_sencilla;
                        inputMenorDoble.value           = menor_doble;
                        inputMenorTriple.value          = menor_triple;
                        inputMenorCuadruple.value       = menor_cuadruple;
                        inputInfanteSencilla.value      = infante_sencilla;
                        inputInfanteDoble.value         = infante_doble;
                        inputInfanteTriple.value        = infante_triple;
                        inputInfanteCuadruple.value     = infante_cuadruple;

                        calcularPreciosFinales();
                    });
            });

            for (let input of contenedorHabitaciones.querySelectorAll("input")) {
                input.addEventListener("change", (event) => {
                    calcularPreciosFinales();
                });
            }

            // Acompañantes
            function eliminarAcompanianteItem(event) {
                const item = event.currentTarget.parentElement.parentElement;
                const itemDraggable = document.getElementById(item.querySelector("input[data-draggable-pax-id]").getAttribute("data-draggable-pax-id"));

                item.parentElement.removeChild(item);
                itemDraggable.parentElement.removeChild(itemDraggable);

                calcularPreciosFinales();
            }

            function agregarAcompanianteItem(wrapperId, inputName) {
                const randomString =  generateRandomString(10);
                const customName = "draggable-pax-" + randomString;

                ////////////////////////////////////////////
                // Inserta el formulario de un acompañante
                ////////////////////////////////////////////
                const wrapper = document.getElementById(wrapperId);

                const visibilityInfoVuelos = checkboxVuelos.checked ? "" : "style='display: none'";
                const requiredInputInfoVuelos = checkboxVuelos.checked ? "required" : "";
                const visibilityVuelosPrecios = ((objExcursion.vuelos == 0) && (checkboxVuelos.checked)) ? "" : "style='visibility: hidden'";
                const requiredVuelosPrecios = ((objExcursion.vuelos == 0) && (checkboxVuelos.checked)) ? "required" : "";
                
                let template = `
                <div class="row item-list ml-0 mr-0" data-pax-id="${randomString}" data-pax-type="${inputName}">
                    <div class="col-md-1 col-sm-12 d-flex align-items-center justify-content-center text-danger pt-2 pb-2">
                        <button type="button" class="btn btn-outline-danger btn-sm item-list__btn-remove btn-eliminar-acompaniante">
                            <i title="Eliminar" class="fas fa-times-circle "></i>
                        </button>
                    </div>

                    <div class="col-md-2 col-sm-6">
                        <div class="form-group">
                            <label>Nombre (s)</label>
                            <input type="text" data-draggable-pax-id="${customName}" name="${inputName}-nombre[]" class="form-control" required />
                        </div>
                    </div>

                    <div class="col-md-2 col-sm-6">
                        <div class="form-group">
                            <label>Apellidos</label>
                            <input type="text" name="${inputName}-apellido[]" class="form-control" required />
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="form-group">
                            <label>Parentesco con el titular</label>
                            <select class="form-control" name="${inputName}-parentesco[]" required>
                                <option value="" selected disabled hidden> Seleccione una opción </option>
                                @foreach ($parentescos as $parentesco)
                                    <option value="{{ $parentesco->id }}">
                                        {{ $parentesco->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label>Fecha nacimiento</label>
                            <input type="date" name="${inputName}-fecha-nacimiento[]" class="form-control" required />
                        </div>
                    </div>

                    <div class="contenedor-info-vuelos col-md-12 col-sm-12 row p-0 m-0 mt-4 pl-1-custom" ${visibilityInfoVuelos}>
                        <div class="col-md-12 col-sm-12">
                            <label class="w-100 text-info">Vuelo de llegada</label>
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <div class="form-group" data-vuelo-llegada-ciudad-origen>
                                <label>Origen:</label>
                            </div>
                            <pre class="results m-0 p-0"></pre>
                        </div>
                        
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group" data-vuelo-llegada-ciudad-destino>
                                <label>Destino:</label>
                            </div>
                            <pre class="results m-0 p-0"></pre>
                        </div>
                        
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label>Aerolínea:</label>
                                <select name="${inputName}-vuelo-llegada-id-aerolinea[]" data-vuelo-llegada-id-aerolinea class="form-control" ${requiredInputInfoVuelos} >
                                </select> 
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label>No. de vuelo:</label>
                                <input type="text" name="${inputName}-vuelo-llegada-no-vuelo[]" class="form-control" ${requiredInputInfoVuelos} />
                            </div>
                        </div>
                        
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label>Fecha y hora:</label>
                                <input type="datetime-local" name="${inputName}-vuelo-llegada-fecha-y-hora[]" class="form-control" ${requiredInputInfoVuelos} />
                            </div>
                        </div>
                        
                        <div class="col-md-4 col-sm-6" ${visibilityVuelosPrecios} >
                            <div class="form-group">
                                <label>Precio:</label>
                                <input type="number" name="${inputName}-vuelo-llegada-precio[]" class="form-control" data-input-vuelo-precio ${requiredVuelosPrecios} />
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12">
                            <label class="w-100 text-info">Vuelo de regreso</label>
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <div class="form-group" data-vuelo-regreso-ciudad-origen>
                                <label>Origen:</label>
                            </div>
                            <pre class="results m-0 p-0"></pre>
                        </div>
                        
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group" data-vuelo-regreso-ciudad-destino>
                                <label>Destino:</label>
                            </div>
                            <pre class="results m-0 p-0"></pre>
                        </div>
                        
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label>Aerolínea:</label>
                                <select name="${inputName}-vuelo-regreso-id-aerolinea[]" data-vuelo-regreso-id-aerolinea class="form-control" ${requiredInputInfoVuelos} >
                                </select> 
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label>No. de vuelo:</label>
                                <input type="text" name="${inputName}-vuelo-regreso-no-vuelo[]" class="form-control" ${requiredInputInfoVuelos} />
                            </div>
                        </div>
                        
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label>Fecha y hora:</label>
                                <input type="datetime-local" name="${inputName}-vuelo-regreso-fecha-y-hora[]" class="form-control" ${requiredInputInfoVuelos} />
                            </div>
                        </div>
                        
                        <div class="col-md-4 col-sm-6" ${visibilityVuelosPrecios}>
                            <div class="form-group">
                                <label>Precio:</label>
                                <input type="number" name="${inputName}-vuelo-regreso-precio[]" class="form-control" data-input-vuelo-precio ${requiredVuelosPrecios} />
                            </div>
                        </div>
                    </div>
                </div>
                `;

                wrapper.insertAdjacentHTML('beforeend', template);

                addGeocoderToInput(`[data-pax-id="${randomString}"] div[data-vuelo-llegada-ciudad-origen]`, `${inputName}-vuelo-llegada-ciudad-origen[]`, checkboxVuelos.checked);
                addGeocoderToInput(`[data-pax-id="${randomString}"] div[data-vuelo-llegada-ciudad-destino]`, `${inputName}-vuelo-llegada-ciudad-destino[]`, checkboxVuelos.checked);
                addGeocoderToInput(`[data-pax-id="${randomString}"] div[data-vuelo-regreso-ciudad-origen]`, `${inputName}-vuelo-regreso-ciudad-origen[]`, checkboxVuelos.checked);
                addGeocoderToInput(`[data-pax-id="${randomString}"] div[data-vuelo-regreso-ciudad-destino]`, `${inputName}-vuelo-regreso-ciudad-destino[]`, checkboxVuelos.checked);

                addSelect2Airlines(`[data-pax-id="${randomString}"] select[data-vuelo-llegada-id-aerolinea]`);
                addSelect2Airlines(`[data-pax-id="${randomString}"] select[data-vuelo-regreso-id-aerolinea]`);

                basicValidation();

                wrapper.lastElementChild.querySelector(".btn-eliminar-acompaniante").addEventListener("click", eliminarAcompanianteItem);
                wrapper.lastElementChild.querySelector(`input[data-draggable-pax-id]`).addEventListener("input", (event) => {
                    document.getElementById(event.target.getAttribute("data-draggable-pax-id")).textContent = event.target.value;
                });
                
                const inputsVuelosPrecios = wrapper.lastElementChild.querySelectorAll(`[data-input-vuelo-precio]`);
                
                for (const inputVueloPrecio of inputsVuelosPrecios) {
                    inputVueloPrecio.addEventListener("change", calcularPreciosFinales);
                }
               
                ///////////////////////////////////////////////////////////////////////////////////////////////
                // Inserta el elemento que se podrá arrastrar para saber en que habitación ira el pasajero
                ///////////////////////////////////////////////////////////////////////////////////////////////
                let templateLi = `<li id="${customName}" data-pax-id=${randomString} class="dist-rooms__client"></li>`;

                wrapperClientesDraggable.insertAdjacentHTML('beforeend', templateLi);
                
                dragAndDropClientsRooms();
                calcularPreciosFinales();
            }

            for (const buttonAgregarAcompaniante of buttonsAgregarAcompaniante) {
                buttonAgregarAcompaniante.addEventListener("click", (event) => {
                    const target = event.currentTarget.getAttribute("data-target");
                    const inputName = event.currentTarget.getAttribute("data-input-name");

                    agregarAcompanianteItem(target, inputName);
                });
            }
            
            // Habitaciones
            function eliminarHabitacionItem(event) {
                const item = event.currentTarget.parentElement.parentElement;
                const itemDroppable = document.getElementById(item.querySelector("input[data-droppable-room-id]").getAttribute("data-droppable-room-id"));
                
                const firstItemDraggable = itemDroppable.querySelector(".dist-rooms__client");

                if (firstItemDraggable !== null) {
                    wrapperClientesDraggable.insertAdjacentHTML('beforeend', firstItemDraggable.parentElement.innerHTML);
                    dragAndDropClientsRooms();
                }

                item.parentElement.removeChild(item);
                itemDroppable.parentElement.removeChild(itemDroppable);

                calcularPreciosFinales();
            }

            function agregarHabitacionItem(wrapperId) {
                const randomString = generateRandomString(10)
                const customName = "droppable-room-" + randomString;

                const wrapper = document.getElementById(wrapperId);

                let template = `
                <div class="row item-list ml-0 mr-0">
                    <input type="hidden" name="habitacion-id[]" value="${randomString}">
                    <div class="col-md-1 col-sm-12 d-flex align-items-center justify-content-center text-danger pt-2 pb-2">
                        <button type="button" class="btn btn-outline-danger btn-sm item-list__btn-remove btn-eliminar-acompaniante btn-eliminar-habitacion">
                            <i title="Eliminar" class="fas fa-times-circle" ></i>
                        </button>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label>Tipo de habitación</label>
                            <select class="form-control" name="habitacion-tipo[]" required>
                                <option value="" selected disabled hidden> Seleccione una opción</option>
                                <option value="sencilla">Sencilla</option>
                                <option value="doble">Doble</option>
                                <option value="triple">Triple</option>
                                <option value="cuadruple">Cuádruple</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="form-group">
                            <label>Nombre del titular</label>
                            <input type="text" data-droppable-room-id=${customName} name="habitacion-titular[]" class="form-control" required />
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label>No. Reserva</label>
                            <input type="text" name="habitacion-no-reserva[]" class="form-control" required />
                        </div>
                    </div>

                    <div class="col-md-1 col-sm-12 d-flex align-items-center justify-content-center text-danger">
                    </div>

                    <div class="col-md-1 col-sm-12 d-flex align-items-center justify-content-center text-danger">
                    </div>

                    <div class="col-md-10 col-sm-12">
                        <div class="form-group">
                            <label>Observaciones</label>
                            <textarea class="form-control" name="habitacion-observaciones[]" placeholder="Consideraciones de la habitación..." ></textarea>
                        </div>
                    </div>
                </div>
                `;

                wrapper.insertAdjacentHTML('beforeend', template);
                basicValidation();
                
                wrapper.lastElementChild.querySelector(".btn-eliminar-habitacion").addEventListener("click", eliminarHabitacionItem);
                wrapper.lastElementChild.querySelector("select[name='habitacion-tipo[]']").addEventListener("click", calcularPreciosFinales);
                wrapper.lastElementChild.querySelector(`input[data-droppable-room-id]`).addEventListener("input", (event) => {
                    document.getElementById(event.target.getAttribute("data-droppable-room-id")).querySelector("span.dist-rooms__room-titular").textContent = event.target.value;
                });

                ///////////////////////////////////////////////////////////////////////////////
                // Inserta el elemento de la habitacion al que se podrán arrastrar los clientes
                ////////////////////////////////////////////////////////////////////////////////
                let templateLi = `<li class="dist-rooms__room" id="${customName}">
                                        <h4>
                                            <i class="fas fa-hotel mr-2"></i> Habitación (Titular: <span class="dist-rooms__room-titular"></span>)
                                        </h4>

                                        <div class="dist-rooms__room-droppable" data-habitacion-id="${randomString}">
                                        
                                        </div>
                                    </li>`;

                wrapperRoomsDroppable.insertAdjacentHTML('beforeend', templateLi);
                
                dragAndDropClientsRooms();
            }

            for (const buttonAgregarHabitacion of buttonsAgregarHabitacion) {
                buttonAgregarHabitacion.addEventListener("click", (event) => {
                    const target = event.currentTarget.getAttribute("data-target");

                    agregarHabitacionItem(target);
                });
            }
           
            formulario.addEventListener("submit", (event) => {
                document.querySelector("button[form='form-agregar-reservacion']").disabled = true;


                if (checkboxHoteleria.checked) {
                    const wrapperHabitaciones = document.getElementById("wrapper__habitaciones"); 
                    for (let habitacion of wrapperHabitaciones.children) {

                        const idRoom = habitacion.querySelector("input[name='habitacion-id[]']").value;
                        const droppableRooms = document.getElementById(`droppable-room-${idRoom}`).querySelectorAll(".dist-rooms__room-droppable");

                        for (const droppableRoom of droppableRooms) {
                            const draggablePaxes = droppableRoom.querySelectorAll(".dist-rooms__client");

                            for (const draggablePax of draggablePaxes) {
                                if (draggablePax.id === "draggable-pax-client") {
                                    let inputHiddenClient = document.createElement("input");
                                    inputHiddenClient.type = "hidden";
                                    inputHiddenClient.name = `habitacion-${idRoom}-is-client`;
                                    inputHiddenClient.value = "1";

                                    formulario.appendChild(inputHiddenClient);
                                    
                                    let inputHiddenClientFullName = document.createElement("input");
                                    inputHiddenClientFullName.type = "hidden";
                                    inputHiddenClientFullName.name = `habitacion-${idRoom}-client-full-name`;
                                    inputHiddenClientFullName.value = draggablePax.textContent.trim();

                                    formulario.appendChild(inputHiddenClientFullName);

                                    continue;
                                }

                                const paxId = draggablePax.getAttribute("data-pax-id");
                                const contenedorInputsPax = document.querySelector(`.item-list[data-pax-id='${paxId}']`);
                                const paxType = contenedorInputsPax.getAttribute("data-pax-type");

                                const datosPax = [
                                    "nombre",
                                    "apellido",
                                    "parentesco",
                                    "fecha-nacimiento",
                                    "vuelo-llegada-ciudad-origen",
                                    "vuelo-llegada-ciudad-destino",
                                    "vuelo-llegada-id-aerolinea",
                                    "vuelo-llegada-no-vuelo",
                                    "vuelo-llegada-fecha-y-hora",
                                    "vuelo-llegada-precio",
                                    "vuelo-regreso-ciudad-origen",
                                    "vuelo-regreso-ciudad-destino",
                                    "vuelo-regreso-id-aerolinea",
                                    "vuelo-regreso-no-vuelo",
                                    "vuelo-regreso-fecha-y-hora",
                                    "vuelo-regreso-precio",
                                ];

                                for (let datoPax of datosPax) {
                                    const newInputHidden = document.createElement("input");
                                    newInputHidden.type = "hidden";
                                    newInputHidden.name = `habitacion-${idRoom}-${paxType}-${datoPax}[]`;
                                    newInputHidden.value = contenedorInputsPax.querySelector(`[name="${paxType}-${datoPax}[]"]`).value;
    
                                    formulario.appendChild(newInputHidden);
                                }
                            }
                        }
                    }
                }
            })
        });
    </script>
@stop
