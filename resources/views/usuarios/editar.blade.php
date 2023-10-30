@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Editar usuario')

@section('content_header')
<h1><span class="font-weight-bold">CloudTravel</span> | Editar usuario</h1>
@stop

@section('content')
<div class="row mb-2">
    <div class="col-md-6 col-sm-6">
        <div class="form-group">
            <label class="col-form-label">
                <i class="fas fa-info-circle"></i>&nbsp;
                Fecha de creación
            </label>
            <input type="datetime-local" class="form-control form-control-sm" value="{{ $usuario->created_at }}" disabled>
        </div>
    </div>

    <div class="col-md-6 col-sm-6">
        <div class="form-group">
            <label class="col-form-label">
                <i class="fas fa-info-circle"></i>&nbsp;
                Ultima actualización
            </label>
            <input type="datetime-local" class="form-control form-control-sm" value="{{ $usuario->updated_at }}" disabled>
        </div>
    </div>
</div>

    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
        </div>

        <div class="card-body">
            <form id="form-agregar-usuario" @can('update', $usuario) action="{{route('usuarios.update', $usuario->id)}}" method="POST" @endcan>
                @can('update', $usuario)
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                @endcan

                <input id="telefono_celular_codigo_pais" type="hidden" name="telefono_celular_codigo_pais" value="{{$usuario->telefono_celular_codigo_pais}}">

                <div class="row border-bottom mb-2">
                    <h6>Información general</h6>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="usuario_nombre">Nombre</label>
                            <input id="usuario_nombre" type="text" name="usuario_nombre" maxlength="63" class="form-control" placeholder="Ingresar nombre..." value="{{$usuario->usuario_nombre}}" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="usuario_apellido">Apellido</label>
                            <input id="usuario_apellido" type="text" name="usuario_apellido" maxlength="63" class="form-control" placeholder="Ingresar apellido..." value="{{$usuario->usuario_apellido}}" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <label for="telefono_celular">Teléfono celular <small>(Opcional)</small></label>
                        <div class="input-group mb-3">
                            <input id="telefono_celular" type="tel" name="telefono_celular" maxlength="63" class="form-control" placeholder="(132) 456 78 90" value="+{{$usuario->telefono_celular_codigo_pais}}{{$usuario->telefono_celular}}">
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" name="email" maxlength="63" class="form-control" placeholder="Ingresar email..." value="{{$usuario->email}}" required>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 mt-4 mb-4"></div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-group position-relative">
                            <label for="password">Cambiar contraseña <small>(Opcional)</small></label>

                            <style>
                                #password[type="text"] {
                                    letter-spacing: 2px
                                }
                            </style>

                            <input id="password" type="password" name="password" maxlength="63" class="form-control">

                            <div class="contenedor-switch-ver-contrasena">
                                <i class="fas fa-eye icono-mostrar" onclick="mostrarContrasena(event, 'icono-mostrar')" style="display: inline-block;"></i>
                                <i class="fas fa-eye-slash icono-ocultar" onclick="mostrarContrasena(event, 'icono-ocultar')" style="display: none;"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Sección Super Administrador --}}
                    <div class="col-md-12 col-sm-12 mt-4 mb-4"></div>

                    @if (Auth::user()->id_rol === 0)
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="section">Seleccionar empresa</label>
                            <select id="id_empresa" class="form-control" name="id_empresa" required >
                                <option value="" selected disabled hidden> Seleccionar empresa </option>
                                @foreach ($empresas as $empresa)
                                    <option value="{{ $empresa['id'] }}" {{ ($usuario->id_empresa === $empresa->id) ? "selected" : "" }}>
                                        {{ $empresa['nombre_comercial'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label for="section">Seleccionar rol</label>
                            <select id="id_rol" class="form-control" name="id_rol" required>
                                @if (Auth::user()->id_rol === 0)
                                <option value="0" selected >Super Admin</option>
                                @endif

                                @foreach ($rolesEmpresa as $rolEmpresa)
                                    <option value="{{$rolEmpresa->id}}" {{ ($usuario->id_rol === $rolEmpresa->id) ? "selected" : "" }} >{{$rolEmpresa->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        @can('update', $usuario)
        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button form="form-agregar-usuario" class="btn btn-primary mx-3" type="submit">
                <i class="fas fa-pencil-alt"></i>
                Actualizar usuario
            </button>

            <a href="{{ route('usuarios.index') }}" class="btn btn-danger" type="button">
                <i class="fas fa-times-circle"></i> Cancelar
            </a>
        </div>
        @endcan
    </div>
@stop

@section('css')
    <link rel="stylesheet" href={{ asset("/assets/css/admin_custom.css") }}>
@stop

@section('plugins.IntTelInput', true)
@section('plugins.Select2', true)

@section('js')
    <script>
        function mostrarContrasena(event, accion) {
            const target = event.target;
            const contenedor = event.target.parentElement;

            const iconoMostrar = contenedor.querySelector(".icono-mostrar");
            const iconoOcultar = contenedor.querySelector(".icono-ocultar");

            const inputContrasena = document.getElementById("password");
            if (inputContrasena.type == "password") {
                inputContrasena.type = "text";
                iconoMostrar.style.display = "none";
                iconoOcultar.style.display = "inline-block";
            } else {
                inputContrasena.type = "password";
                iconoMostrar.style.display = "inline-block";
                iconoOcultar.style.display = "none";
            }
        }

        (function() {
            document.addEventListener("DOMContentLoaded", function() {
                /* Código que se ejecutará una vez se haya cargado todo el HTML */
                const formulario = document.getElementById("form-agregar-usuario")
                const inputTelefonoCelular = document.querySelector("#telefono_celular");
                const selectEmpresas = document.getElementById("id_empresa");
                const selectRoles = document.getElementById("id_rol");

                if (selectEmpresas !== null) {
                    // Inicializamos el select2
                    const $select2empresas = $('#id_empresa');
                    $select2empresas.select2();

                    $select2empresas.on("change", (event) => {
                        const idEmpresa = $select2empresas.select2('data')[0].element.value;

                        fetch("{{route('empresas.index')}}" + "/" + idEmpresa + "/roles")
                        .then(res => res.json())
                        .then(data => {
                            const rolesEmpresa = data;

                            selectRoles.innerHTML = "";

                            const optionDefault = document.createElement("option");
                            optionDefault.selected = true;
                            optionDefault.disabled = true;
                            optionDefault.hidden = true;
                            optionDefault.value = "";
                            optionDefault.textContent = "Seleccione un rol";

                            selectRoles.appendChild(optionDefault);

                            for (let rol of rolesEmpresa) {
                                const option = document.createElement("option");
                                option.value = rol.id;
                                option.textContent = rol.nombre;

                                selectRoles.appendChild(option);
                            }
                        });
                    });
                }

                ///////////////////////////////////
                // International Telephone Input //
                ///////////////////////////////////
                let itiTelefonoCelular = intlTelInput(inputTelefonoCelular, {
                    initialCountry: "auto",
                    separateDialCode: true
                });

                ///////////////////////////
                // SUBIDA DEL FORMULARIO //
                ///////////////////////////
                formulario.addEventListener("submit", (event) => {
                    document.getElementById("telefono_celular_codigo_pais").value = itiTelefonoCelular.getSelectedCountryData().dialCode;
                });
            });
        })();
    </script>
@stop
