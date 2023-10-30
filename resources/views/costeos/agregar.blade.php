@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Agregar costeo')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Agregar costeo</h1>
@stop

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
        </div>

        <div class="card-body">
            <form id="form-agregar-costeo" action="{{ route('costeos.store') }}" method="post">
                @csrf

                <div class="row form-title-section mb-2">
                    <i class="fas fa-cash-register"></i>
                    <h6>Datos del costeo</h6>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ingresar nombre" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea id="descripcion" name="descripcion" class="form-control" placeholder="Agregar una descripción para que los demás puedan identificar donde usar este costeo" style="height: 100px" required></textarea>
                        </div>
                    </div>
                </div>

                <div id="form-costeo__campos" class="form-costeo__campos">
                    <div>
                        <label class="w-100">Campos asociados</label>

                        <div class="alert alert-info" role="alert" style="font-size: 95%">
                            <label>Campos especiales <span class="badge badge-danger">Importante</span></label>
                            <p>
                                Existen campos especiales (No se les puede asignar un valor general), en cambio, su valor es propio de cada excursion o bien
                                es definido por el usuario final (e.g. La cantidad de pasajeros).
                                <span class="font-weight-bold">Si desea agregar un campo especial tome en cuenta la siguiente tabla</span>
                            </p>

                            <div style="overflow-x: scroll">
                                <table class="table table-bordered table-striped table-dark" style="max-width: 1200px">
                                    <caption class="text-light font-italic">*Tabla de campos especiales</caption>
    
                                    <thead class="font-weight-bold">
                                        <tr>
                                            <th>
                                                Nombre
                                            </th>
                                            <th>
                                                Identificador
                                            </th>
                                            <th style="min-width: 315px">
                                                Descripción
                                            </th>
                                        </tr>
                                    </thead>
    
                                    <tbody class="bg-secondary">
                                        <tr>
                                            <td>
                                                CANTIDAD_PASAJEROS
                                            </td>
                                            <td>
                                                cantidad_pasajeros
                                            </td>
                                            <td>
                                                Campo controlado por el usuario. Se puede asignar su valor inicial.
                                                <br>
                                                <br>
                                                Representa la cantidad de pasajeros que van a realizar la reservación de una excursión.
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                CANTIDAD_PASAJEROS_GRUPO
                                            </td>
                                            <td>
                                                cantidad_pasajeros_grupo
                                            </td>
                                            <td>
                                                Campo controlado por la excursión. No se puede asignar su valor inicial ya que este es determinado por el valor del campo "Tamaño del grupo" de cada excursión.
                                                <br>
                                                <br>
                                                Solo se toma en cuenta cuando el tipo de tarifa de una excursion es 'Grupal' y el método para el calculo de precios es mediante formula.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <button type="button" class="btn btn-outline-secondary btn-sm mb-2 btn-agregar-campo">
                            <i class="fas fa-keyboard mr-2"></i>
                            Agregar campo
                        </button>
                    </div>


                    <div class="form-costeo__campo" style="margin-left: 42px">
                        <div class="form-group m-0">
                            <label class="m-0">Nombre</label>
                            <input type="text" name="costeo-campos-nombres[]" class="form-control" required>
                        </div>

                        <div class="form-group m-0">
                            <label class="m-0">Valor inicial</label>
                            <input type="number" name="costeo-campos-valores-por-defecto[]" class="form-control" min="0" value="0" step="any" required>
                        </div>

                        <div class="form-group m-0">
                            <label class="m-0">Identificador</label>
                            <input type="text" name="costeo-campos-identificadores[]" class="form-control" disabled>
                        </div>

                        <div class="form-group m-0 ">
                            <label class="m-0">DPU <small>Definido por usuario</small></label>
                            
                            <select name="costeo-campos-dpu[]" class="form-control">
                                <option value="0" selected>No</option>
                                <option value="1" >Si</option>
                            </select>

                        </div>
                    </div>

                    <div class="form-costeo__campo">
                        <button type="button" class="btn btn-outline-danger btn-sm align-self-end btn-eliminar-campo">
                            <i title="Eliminar" class="fas fa-times-circle "></i>
                        </button>

                        <div class="form-group m-0">
                            <label class="m-0">Nombre</label>
                            <input type="text" name="costeo-campos-nombres[]" class="form-control" required>
                        </div>

                        <div class="form-group m-0">
                            <label class="m-0">Valor inicial</label>
                            <input type="number" name="costeo-campos-valores-por-defecto[]" class="form-control" min="0" value="0" step="any" required>
                        </div>

                        <div class="form-group m-0">
                            <label class="m-0">Identificador</label>
                            <input type="text" name="costeo-campos-identificadores[]" class="form-control" disabled>
                        </div>

                        <div class="form-group m-0 ">
                            <label class="m-0">DPU <small>Definido por usuario</small></label>
                            
                            <select name="costeo-campos-dpu[]" class="form-control">
                                <option value="0" selected>No</option>
                                <option value="1" >Si</option>
                            </select>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group form-costeo__campo--mb-custom">
                            <label for="formula_precio">Formula para calcular el precio de la excursión</label>

                            <div class="alert alert-info" role="alert" style="font-size: 95%">
                                <label>Operadores y funciones permitidas <span class="badge badge-danger">Importante</span></label>
                                <p>
                                    Para los campos de las formulas estan permitidas todas las operaciones basicas, las cuales son:
                                    
                                    <ul>
                                        <li>suma(+)</li>
                                        <li>resta(-)</li>
                                        <li>multiplicacion(*)</li>
                                        <li>division(/)</li>
                                        <li>exponenciación (^)</li>
                                    </ul>

                                    Asi como dos funciones para redondear hacia arriba o hacia abajo:
                                    <ul>
                                        <li>redondear hacia arriba( ceil() )</li>
                                        <li>redondear hacia abajo( floor() )</li>
                                    </ul>
                                </p>
                            </div>
                            
                            <div class="form-costeo__campo-contenedor-formula">
                                <input type="text" name="formula_precio" class="form-control" data-input-formula required>
                                <input type="text" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="form-costeo__condiciones" class="form-costeo__condiciones">
                    <div>
                        <label class="w-100">Condiciones del costeo</label>

                        <button type="button" class="btn btn-outline-secondary btn-sm mb-2 btn-agregar-condicion">
                            <i class="fas fa-keyboard mr-2"></i>
                            Agregar condición
                        </button>
                    </div>

                    {{-- <div class="form-costeo__condicion form-costeo__condicion--mb-custom" style="margin-left: 42px">
                        <div class="form-group m-0">
                            <label class="m-0">Condición a cumplir</label>
                            <input type="text" name="costeo-condiciones[]" class="form-control">
                        </div>

                        <div class="form-group m-0">
                            <label class="m-0">Nueva formula</label>
                            <div class="form-costeo__campo-contenedor-formula">
                                <input type="text" name="costeo-condiciones-formulas[]" class="form-control" data-input-formula required>
                                <input type="text" class="form-control" disabled>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </form>
        </div>

        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button form="form-agregar-costeo" class="btn btn-primary mx-3" type="submit">
                <i class="fas fa-pencil-alt"></i>
                &nbsp;Agregar costeo
            </button>

            <a href="{{ route('excursiones-fechas.index') }}" class="btn btn-danger">
                <i class="fas fa-times-circle"></i>
                &nbsp;Cancelar
            </a>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
@stop

@section('js')
    <script>
        $(function() {
            basicValidation();

            const formCosteoCampos = document.getElementById("form-costeo__campos");
            const costeoCampos = formCosteoCampos.querySelectorAll(".form-costeo__campo");
            const btnEliminarCosteoCampo = formCosteoCampos.querySelectorAll(".form-costeo__campo .btn-eliminar-campo");
            const btnAgregarCosteoCampo = formCosteoCampos.querySelector("button.btn-agregar-campo");

            const inputsFormulas = document.querySelectorAll("input[data-input-formula]");

            // Se agregan eventos a los botones de agregar y eliminar campos
            btnAgregarCosteoCampo.addEventListener("click", (event) => {
                const contenedor = event.currentTarget.parentElement.parentElement;

                agregarCosteoCampo(contenedor);
            });

            for (const btnEliminar of btnEliminarCosteoCampo) {
                btnEliminar.addEventListener("click", eliminarCosteoCampo);
            }

            // Se agrega el evento para normalizar el texto del nombre del campo
            for (const costeoCampo of costeoCampos) {
                const costeoCampoNombre = costeoCampo.querySelector("input[name='costeo-campos-nombres[]']");
                
                costeoCampoNombre.addEventListener("input", () => {
                    crearIdentificadorDeCampo(costeoCampo);
                });
            }

            // Se crea el evento para sanitizar los input de las formulas
            for (const inputFormula of inputsFormulas) {
                inputFormula.addEventListener("input", () => {
                    sanitizarInputFormula(inputFormula);
                });
            }

            function crearIdentificadorDeCampo(costeoCampo) {
                const costeoCampoNombre = costeoCampo.querySelector("input[name='costeo-campos-nombres[]']");
                const costeoCampoValorInicial = costeoCampo.querySelector("input[name='costeo-campos-valores-por-defecto[]']");
                const costeoCampoIdentificador = costeoCampo.querySelector("input[name='costeo-campos-identificadores[]']");
                const costeoCampDPU = costeoCampo.querySelector("select[name='costeo-campos-dpu[]']");
                
                switch (costeoCampoNombre.value) {
                    case "CANTIDAD_PASAJEROS":
                        costeoCampoIdentificador.value = "cantidad_pasajeros";

                        costeoCampDPU.value = 1; // Definido por usuario
                        costeoCampDPU.disabled = true;
                        break;

                    case "CANTIDAD_PASAJEROS_GRUPO":
                        costeoCampoIdentificador.value = "cantidad_pasajeros_grupo";

                        costeoCampDPU.value = 0; // Definido por excursion
                        costeoCampDPU.disabled = true;

                        costeoCampoValorInicial.value = "";
                        costeoCampoValorInicial.placeholder = "Se asigna en cada excursión";
                        costeoCampoValorInicial.readOnly = true;

                        break;
                
                    default:
                        costeoCampoIdentificador.value = normalizarTexto(costeoCampoNombre.value);

                        if (costeoCampDPU.disabled === true) {
                            costeoCampDPU.disabled = false;
                        }

                        if (costeoCampoValorInicial.readOnly === true) {
                            costeoCampoValorInicial.readOnly = false;
                        }
                        
                        break;
                }
            }

            function sanitizarInputFormula(inputFormula) {
                let arrIdentificadores = [];

                for (const costeoCampo of formCosteoCampos.querySelectorAll(".form-costeo__campo")) {
                    const costeoCampoNombre = costeoCampo.querySelector("input[name='costeo-campos-nombres[]']");

                    switch (costeoCampoNombre.value) {
                        case "CANTIDAD_PASAJEROS":
                            arrIdentificadores.push("cantidad_pasajeros");

                            break;

                        case "CANTIDAD_PASAJEROS_GRUPO":
                            arrIdentificadores.push("cantidad_pasajeros_grupo");

                            break;
                    
                        default:
                            arrIdentificadores.push(normalizarTexto(costeoCampoNombre.value));

                            break;
                    }
                }

                // Se tienen como identificadores a todos los campos añadidos por el usuario ademas de dos funciones especial (ceil y floor)
                const regexFormula = new RegExp(`(${arrIdentificadores.join("|")}|ceil|floor)?[0-9+\\-*\\/^() ]`, "g");

                inputFormula.parentElement.lastElementChild.value = `${inputFormula.value} `.match(regexFormula).join("");
            }

            function generarStringCosteoCampo(btnEliminar = false) {
                let txtBtnEliminar = "";

                if (btnEliminar === true) {
                    txtBtnEliminar = `
                    <button type="button" class="btn btn-outline-danger btn-sm align-self-end btn-eliminar-campo">
                        <i title="Eliminar" class="fas fa-times-circle "></i>
                    </button>
                    `;
                }

                let costeoCampoNuevoHTML = "";

                costeoCampoNuevoHTML += `
                <div class="form-costeo__campo">
                    <button type="button" class="btn btn-outline-danger btn-sm align-self-end btn-eliminar-campo">
                        <i title="Eliminar" class="fas fa-times-circle "></i>
                    </button>

                    <div class="form-group m-0">
                        <label class="m-0">Nombre</label>
                        <input type="text" name="costeo-campos-nombres[]" class="form-control" required>
                    </div>

                    <div class="form-group m-0">
                        <label class="m-0">Valor inicial</label>
                        <input type="number" name="costeo-campos-valores-por-defecto[]" class="form-control" min="0" value="0" step="any" required>
                    </div>

                    <div class="form-group m-0">
                        <label class="m-0">Identificador</label>
                        <input type="text" name="costeo-campos-identificadores[]" class="form-control" disabled>
                    </div>

                    <div class="form-group m-0 ">
                        <label class="m-0">DPU <small>Definido por usuario</small></label>
                        
                        <select name="costeo-campos-dpu[]" class="form-control">
                            <option value="0" selected>No</option>
                            <option value="1" >Si</option>
                        </select>

                    </div>
                </div>
                `;

                return costeoCampoNuevoHTML;
            }

            function eliminarCosteoCampo(event) {
                const contenedorCampo = event.currentTarget.parentElement;
                contenedorCampo.parentElement.removeChild(contenedorCampo);
            }

            function agregarCosteoCampo(contenedor) {
                contenedor.insertAdjacentHTML("beforeend", generarStringCosteoCampo(btnEliminar = true));

                const costeoCampoNuevoElement = contenedor.lastElementChild;
                costeoCampoNuevoElement.querySelector("button.btn-eliminar-campo").addEventListener("click", eliminarCosteoCampo);

                const costeoCampoNuevoNombre = costeoCampoNuevoElement.querySelector("input[name='costeo-campos-nombres[]']");

                costeoCampoNuevoNombre.addEventListener("input", () => {
                    crearIdentificadorDeCampo(costeoCampoNuevoElement);
                });

                basicValidation();
            }

            // Código para las condiciones
            const costeoCondicionesContenedor = document.getElementById("form-costeo__condiciones");
            const costeoCondiciones = costeoCondicionesContenedor.querySelectorAll(".form-costeo__condicion");
            const btnEliminarCosteoCondicion = costeoCondicionesContenedor.querySelectorAll(".form-costeo__condicion .btn-eliminar-condicion");
            const btnAgregarCosteoCondicion = costeoCondicionesContenedor.querySelector("button.btn-agregar-condicion");

            btnAgregarCosteoCondicion.addEventListener("click", (event) => {
                const contenedor = event.currentTarget.parentElement.parentElement;

                agregarCosteoCondicion(contenedor);
            });

            for (let btnEliminar of btnEliminarCosteoCondicion) {
                btnEliminar.addEventListener("click", eliminarCosteoCondicion);
            }

            function generarStringCosteoCondicion(btnEliminar = false) {
                let txtBtnEliminar = "";

                if (btnEliminar === true) {
                    txtBtnEliminar = `
                    <button type="button" class="btn btn-outline-danger btn-sm align-self-end btn-eliminar-campo">
                        <i title="Eliminar" class="fas fa-times-circle "></i>
                    </button>
                    `;
                }

                let costeoCondicionNuevaHTML = "";

                costeoCondicionNuevaHTML += `
                <div class="form-costeo__condicion form-costeo__condicion--mb-custom">
                    <button type="button" class="btn btn-outline-danger btn-sm align-self-end btn-eliminar-condicion">
                        <i title="Eliminar" class="fas fa-times-circle "></i>
                    </button>

                    <div class="form-group m-0">
                        <label class="m-0">Condición a cumplir</label>
                        <input type="text" name="costeo-condiciones[]" class="form-control" required>
                    </div>

                    <div class="form-group m-0">
                        <label class="m-0">Nueva formula</label>
                        <div class="form-costeo__campo-contenedor-formula">
                            <input type="text" name="costeo-condiciones-formulas[]" class="form-control"  data-input-formula required>
                            <input type="text" class="form-control" disabled>
                        </div>
                    </div>
                </div>
                `;

                return costeoCondicionNuevaHTML;
            }

            function eliminarCosteoCondicion(event) {
                const contenedorCondicion = event.currentTarget.parentElement;
                contenedorCondicion.parentElement.removeChild(contenedorCondicion);
            }

            function agregarCosteoCondicion(contenedor) {
                let costeoCondicionNuevaHTML = "";

                costeoCondicionNuevaHTML += generarStringCosteoCondicion(btnEliminar = true);


                contenedor.insertAdjacentHTML("beforeend", costeoCondicionNuevaHTML);

                const costeoCondicionNuevaElement = contenedor.lastElementChild;
                costeoCondicionNuevaElement.querySelector("button.btn-eliminar-condicion").addEventListener("click", eliminarCosteoCondicion);

                const costeoCondicionNuevaInputFormula = costeoCondicionNuevaElement.querySelector("input[data-input-formula]");
                costeoCondicionNuevaInputFormula.addEventListener("input", () => {
                    sanitizarInputFormula(costeoCondicionNuevaInputFormula);
                });

                basicValidation();
            }

            document.getElementById("form-agregar-costeo").addEventListener("submit", (event) => {
                const costeoCamposFinales = formCosteoCampos.querySelectorAll(".form-costeo__campo");

                for (const costeoCampoFinal of costeoCamposFinales) {
                    const costeoCampoValorInicial = costeoCampoFinal.querySelector("input[name='costeo-campos-valores-por-defecto[]']");
                    const costeoCampDPU = costeoCampoFinal.querySelector("select[name='costeo-campos-dpu[]']");
                    
                    if (costeoCampoValorInicial.value === "") {
                        costeoCampoValorInicial.value = 0; 
                    }

                    if (costeoCampDPU.disabled === true) {
                        costeoCampDPU.disabled = false;
                    }
                }
            })
        });
    </script>
@stop
