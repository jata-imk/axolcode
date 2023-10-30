@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Mi Perfil')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Mi perfil</h1>
@stop

@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-info card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center" style="position: relative; width: fit-content; margin: 0 auto;">
                                @if ($misDatos->imagen_perfil == '')
                                    <img class="profile-user-img img-fluid img-circle" src="{{ asset('/assets/img/usuario.png') }}" alt="Imagen de perfil">
                                @else
                                    <img class="profile-user-img img-fluid img-circle" src="storage/{{ $misDatos->imagen_perfil }}" alt="Imagen de perfil" style="width: 100px; height: 100px; object-fit: cover;">
                                @endif

                                <label for="profile-photo-input" class="user-panel__upload-photo-icon">
                                    <i class="fas fa-camera "></i>
                                </label>               
                                <input type="file" name="profile-photo-input" id="profile-photo-input" style="display: none;" onchange="uploadProfilePhoto(event)" data-nombre-bdd="logo_url" accept="image/*">
                            </div>
                            <h3 class="profile-username text-center">{{ $misDatos->name }}</h3>
                            <p class="text-muted text-center">{{ $misDatos->nombre_comercial }}</p>
                        </div>
                    </div>

                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Sobre mi</h3>
                        </div>

                        <div class="card-body">
                            <strong><i class="fas fa-user-tag mr-1"></i> Rol</strong>
                            @if (Auth::user()->id_rol === 0)
                            <p class="text-muted">SuperAdmin</p>
                            @else
                            <p class="text-muted">{{ $misDatos->nombreRol }}</p>
                            @endif
                            <hr>
                            <strong><i class="fas fa-phone mr-1"></i></i></i> Teléfono</strong>
                            <p class="text-muted">{{ $misDatos->telefono_celular == '' ? 'No capturado' : $misDatos->telefono_celular }}</p>
                            <hr>
                            <strong><i class="far fa-envelope-open mr-1"></i> Mail</strong>
                            <p class="text-muted">{{ $misDatos->email }}</p>
                            <hr>
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Editar información</h3>
                        </div>

                        <div class="card-body">
                            <form id="frm_password" action="{{ route('mi_perfil.update', $misDatos->id) }}" method="post">
                                <input type="hidden" id="compara_pass" value="0" />
                                @csrf
                                @method('put')

                                @if (session('message'))
                                    <div id="mensajepersonalizado" class="alert alert-default-success mt-2 alert-dismissible fade show" role="alert">{{ session('message') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <div class="row form-title-section mb-5">
                                    <i class="fas fa-user"></i>
                                    <h6>Datos de usuario</h6>
                                </div>

                                    <div class="mb-4 row">
                                        <label for="usuario_nombre" class="col-sm-2 col-form-label">Nombre (s)</label>
                                        <div class="col-sm-10">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-user-alt"></i>
                                                    </span>
                                                </div>
                                                <input type="text" id="usuario_nombre" name="usuario_nombre" class="form-control" value="{{ $misDatos->usuario_nombre }}" placeholder="Nombre(s)">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4 row">
                                        <label for="usuario_apellido" class="col-sm-2 col-form-label">Apellidos</label>
                                        <div class="col-sm-10">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-user-alt"></i>
                                                    </span>
                                                </div>
                                                <input type="text" id="usuario_apellido" name="usuario_apellido" class="form-control" value="{{ $misDatos->usuario_apellido }}" placeholder="Apellido(s)">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4 row">
                                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-envelope"></i>
                                                    </span>
                                                </div>
                                                <input type="email" id="email" name="email" class="form-control" value="{{ $misDatos->email }}" placeholder="Escriba su email" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4 row">
                                        <label for="telefono_celular" class="col-sm-2 col-form-label">Teléfono</label>
                                        <div class="col-sm-10">
                                            <div class="input-group mb-3">
                                                <input type="hidden" name="telefono_celular_codigo_pais" id="telefono_celular_codigo_pais" />
                                                <input type="telefono" id="telefono_celular" name="telefono_celular" id="telefono_celular" class="form-control" value="+{{ $misDatos->telefono_celular_codigo_pais . $misDatos->telefono_celular }}" placeholder="Ingrese su número de teléfono" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                <hr>
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                        <input role="button" onchange="formPassword(this)" type="checkbox" class="custom-control-input" id="passwordSwitch">
                                        <label role="button" class="custom-control-label" for="passwordSwitch">Cambiar contraseña</label>
                                    </div>
                                </div>

                                <div class="row" id="passwordForm" style="display: none;">
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group position-relative">
                                            <label for="password">Cambiar contraseña </label>
                                            <style>
                                                #password[type="text"] {
                                                    letter-spacing: 2px
                                                }
                                            </style>
                                            <input type="password" name="password" id="password" onkeyup="$(this).removeClass('is-invalid')" disabled required maxlength="63" class="form-control" autocomplete="off">

                                            <div class="contenedor-switch-ver-contrasena">
                                                <i class="fas fa-eye icono-mostrar" onclick="mostrarContrasena(event, 'icono-mostrar', 'password')" style="display: inline-block;"></i>
                                                <i class="fas fa-eye-slash icono-ocultar" onclick="mostrarContrasena(event, 'icono-ocultar', 'password')" style="display: none;"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group position-relative">
                                            <label for="re_password">Confirmar nueva contraseña</label>
                                            <style>
                                                #password[type="text"] {
                                                    letter-spacing: 2px
                                                }
                                            </style>
                                            <input type="password" name="re_password" onkeyup="comparaPassword()" id="re_password" disabled required maxlength="63" class="form-control" autocomplete="off">
                                            <div class="contenedor-switch-ver-contrasena">
                                                <i class="fas fa-eye icono-mostrar" onclick="mostrarContrasena(event, 'icono-mostrar', 're_password')" style="display: inline-block;"></i>
                                                <i class="fas fa-eye-slash icono-ocultar" onclick="mostrarContrasena(event, 'icono-ocultar', 're_password')" style="display: none;"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="card-footer d-grid gap-2 text-right">
                            <button class="btn btn-primary mx-3" type="button" onclick="submitForm()">
                                <i class="fas fa-save"></i>
                                &nbsp;Guardar cambios
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('css')
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
@stop

@section('plugins.Sweetalert2', true)
@section('plugins.Datatables_Buttons', true)
@section('plugins.IntTelInput', true)

@section('js')
    <script>
        function uploadProfilePhoto(event) {
            const input = event.target;
            const file = input.files[0];
            const formData = new FormData();

            formData.append("_method", "patch");
            formData.append("_token", "{{  csrf_token() }}");
            formData.append("imagen_perfil", file);

            fetch("{{ route('mi_perfil.update', $misDatos->id) }}", {
                    method: "POST",
                    body: formData
                })
                .then(res => res.json())
                .then((data) => {
                    if (data.code !== "200") {
                        return;
                    }

                    const contenedor = input.parentElement;
                    const imgPerfil = contenedor.querySelector(".profile-user-img");

                    imgPerfil.src = "storage/" + data.body.imagen_perfil;

                })
                .catch(err => console.log("Algo ocurrió: ", err));
        };

        $(document).ready(function() {
            if ($("#mensajepersonalizado").length > 0) {
                setTimeout(function() {
                    esconderAlerta("mensajepersonalizado");
                }, 3000);
            }
        });

        const inputTelefonoCelular = document.querySelector("#telefono_celular");
        ///////////////////////////////////
        // International Telephone Input //
        ///////////////////////////////////
        let itiTelefonoCelular = intlTelInput(inputTelefonoCelular, {
            initialCountry: "auto",
            separateDialCode: true,
            geoIpLookup: function(callback) {
                fetch('https://ipinfo.io/?token=7c0ae29766d659', {
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => callback(data.country));
            }
        });

        function mostrarContrasena(event, accion, input) {
            const target = event.target;
            const contenedor = event.target.parentElement;

            const iconoMostrar = contenedor.querySelector(".icono-mostrar");
            const iconoOcultar = contenedor.querySelector(".icono-ocultar");

            const inputContrasena = document.getElementById(input);
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

        function formPassword(elem) {
            if ($(elem).is(':checked')) {
                $("#passwordForm").show();
                $("#password").prop("disabled", false);
                $("#re_password").prop("disabled", false);
            } else {
                $("#passwordForm").hide();
                $("#password").prop("disabled", true);
                $("#re_password").prop("disabled", true);
            }
        }

        function submitForm() {
            if ($("#passwordSwitch").is(':checked')) {
                if ($("#password").val() != '') {
                    if ($("#re_password").val() != '') {
                        if (comparaPassword() === 1) {
                            $("#telefono_celular_codigo_pais").val(itiTelefonoCelular.getSelectedCountryData().dialCode);
                            $("#frm_password").submit();
                        } else {
                            alert("no pasa");
                        }
                    } else {
                        $("#re_password").focus().addClass("is-invalid");
                        alert("Confirme su password");
                    }
                } else {
                    $("#password").focus().addClass("is-invalid");
                    alert("Escriba su password");
                }
            } else {
                $("#telefono_celular_codigo_pais").val(itiTelefonoCelular.getSelectedCountryData().dialCode);
                $("#frm_password").submit();
            }
        }

        function comparaPassword() {
            var password = $("#password").val();
            var re_password = $("#re_password").val();

            if (password !== re_password) {
                $("#re_password").focus().addClass("is-invalid");
                return 0;
            } else {
                $("#re_password").focus().removeClass("is-invalid");
                return 1;
            }
        }
    </script>
@stop
