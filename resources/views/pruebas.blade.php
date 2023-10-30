@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Pagina de pruebas')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Pagina de pruebas</h1>
@stop

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
        </div>

        <div class="card-body">
            <form id="form-pruebas" class="form-pruebas" action="./pruebas" method="post">
                <div class="row form-title-section mb-2">
                    <i class="fas fa-umbrella-beach"></i>
                    <h6>Información de la<span class="text-info">página de pruebas</span></h6>

                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-floating">
                            <label>Incluye</label>
                            <select id="incluye" name="incluye[]" multiple class="form-control">
                                @foreach ($servicios as $servicio)
                                    <option value="{{ $servicio->id }}" selected>{{ $servicio->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-floating">
                            <label>No incluye</label>
                            <select id="no_incluye" name="no_incluye[]" multiple class="form-control">
                                @foreach ($servicios as $servicio)
                                    <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

            </form>
        </div>

        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button form="form-pruebas" class="btn btn-primary mx-3" type="submit">
                <i class="fas fa-pencil-alt"></i>
                &nbsp;Editar
            </button>
            <a href="./" class="btn btn-danger">
                <i class="fas fa-times-circle"></i>
                &nbsp;Ir al inicio
            </a>
        </div>

        <div id="exampleModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detalles de la imagen</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Cuerpo del modal.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
    <link rel="stylesheet" href="{{ asset('/assets/css/filter_multi_select.css') }}" />
@stop

@section('js')
    <script src="{{ asset('/assets/js/filter-multi-select-prueba.js') }}"></script>

    <script>
        $(function() {
            const incluye = $('#incluye').filterMultiSelect({
                placeholderText: " -- Seleccione de la lista",
                filterText: "Escriba para buscar",
                selectAllText: "Seleccionar todos",
                labelText: "",
                addElementFormHTML: `<x-servicios.formularios.agregar className="form-modal" layout="vertical" />`,
                addElementFormSubmitHandler: (event, instance) => {
                    event.stopImmediatePropagation();
                    event.preventDefault();

                    const target = event.target;
                    const btnSubmit = target.querySelector("button[type='submit']");
                    btnSubmit.disabled = true;

                    const formData = new FormData(target);
                    formData.append("api", "true");

                    fetch(target.action, {
                        method: "POST",
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        btnSubmit.disabled = false;

                        if (data.code < 200 || data.code > 299) {
                            throw new Object(data);
                        }

                        const servicio = data.body.servicio;

                        const newOption = document.createElement("option");
                        newOption.label = servicio.nombre;
                        newOption.value = servicio.id;
                        newOption.selected = true;

                        const newOptionInstance = instance.createOption(instance, instance.name, newOption);
                    }).catch( (e) => {
                        const btnSubmitCOntainer = 
                        btnSubmit.disabled = false;

                        btnSubmit.parentElement.insertAdjacentHTML("afterbegin", `<x-alerta title="" description="${e?.body?.msg || e}"/>`);
                    })
                }
            });

            const noIncluye = $('#no_incluye').filterMultiSelect({
                placeholderText: " -- Seleccione de la lista",
                filterText: "Escriba para buscar",
                selectAllText: "Seleccionar todos"
            });

            $('#incluye').on('optionselected', function(e) {
                noIncluye.disableOption(e.detail.value);
            });

            $('#incluye').on('optiondeselected', function(e) {
                noIncluye.enableOption(e.detail.value);
            });

            $('#incluye').on('optioncreated', function(e) {
                const optionClass = e.detail.option;

                if (!noIncluye.hasOption(optionClass.checkbox.value)) {
                    const newOption = document.createElement("option");
                    newOption.label = optionClass.labelFor.textContent;
                    newOption.value = optionClass.checkbox.value;
                    newOption.selected = false;
                    newOption.disabled = true;

                    noIncluye.filterMultiSelect.createOption(noIncluye.filterMultiSelect, noIncluye.filterMultiSelect.name, newOption)
                }
            });

            $('#no_incluye').on('optionselected', function(e) {
                incluye.disableOption(e.detail.value);
            });

            $('#no_incluye').on('optiondeselected', function(e) {
                incluye.enableOption(e.detail.value);
            });

            $('#noIncluye').on('optioncreated', function(e) {
                const optionClass = e.detail.option;

                if (!incluye.hasOption(optionClass.checkbox.value)) {
                    const newOption = document.createElement("option");
                    newOption.label = optionClass.labelFor.textContent;
                    newOption.value = optionClass.checkbox.value;
                    newOption.selected = false;
                    newOption.disabled = true;

                    incluye.filterMultiSelect.createOption(incluye.filterMultiSelect, incluye.filterMultiSelect.name, newOption)
                }
            });
        });

        $(document).ready(function() {
            const formularioEditarExcursion = document.getElementById("form-pruebas");

            formularioEditarExcursion.addEventListener("submit", (event) => {
                event.preventDefault();
            });
        });
    </script>
@stop
