@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Redes sociales')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Sitio Web y Redes Sociales</h1>
@stop

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
        </div>

        <div class="card-body">
            <form id="form-redes-sociales" action="{{ route('paginas-web.update', $paginasWeb[0]->id) }}" method="post">
                @csrf
                @method('put')

                <input type="hidden" value="{{ $paginasWeb[0]->id }}" name="id" />
                <input type="hidden" value="redessociales" name="ruta" />

                @if (session('message'))
                    <div id="mensajepersonalizado" class="alert alert-default-success mt-2 alert-dismissible fade show" role="alert">{{ session('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="row form-title-section mb-2">
                    <i class="fas fa-link"></i>
                    <h6>Ingrese los links que correspondan</span></h6>
                </div>

                <div class="row redes-sociales">
                    <div class="red-social">
                        <div class="form-group" style="background: linear-gradient(15deg, rgba(237,237,237,1) 0%, #17a2b875 100%);">
                            <label>
                                <i class="fas fa-globe" style="font-size: 20px; color: #17a2b8;"></i>
                                &nbsp;Pagina web
                            </label>

                            <input type="text" name="pagina-web" class="form-control" placeholder="Ingrese la URL de su pagina web" value="{{ $paginasWeb[0]->pagina_web }}">
                        </div>

                        <div class="red-social__preview">
                            <button class="red-social__preview-btn" data-url="{{ $paginasWeb[0]->pagina_web }}">
                                <i class="fas fa-eye"></i>
                                Ver tarjeta de formato enriquecido
                            </button>
                        </div>
                    </div>

                    @foreach ($paginasWeb[0]->redes_sociales as $redSocial)
                        <div class="red-social">
                            <div class="form-group" style="background: linear-gradient(15deg, rgba(237,237,237,1) 0%, {{ $redSocial['icon_color'] }}75 100%);">
                                <label>
                                    <i class="{{ $redSocial['icon'] }}" style="font-size: 20px; color: {{ $redSocial['icon_color'] }};"></i>
                                    &nbsp;{{ $redSocial['nombre'] }}
                                </label>

                                <input type="hidden" name="pagina-web-redes-sociales[]" value="{{ $redSocial['id_red_social'] }}">
                                <input type="text" name="pagina-web-red-social-{{ $redSocial['id_red_social'] }}" class="form-control" placeholder="Ingrese el {{ $redSocial['nombre'] }} de su pagina web" value="{{ $redSocial['url'] }}">
                            </div>

                            <div class="red-social__preview">
                                @if (!($redSocial['nombre'] === 'WhatsApp'))
                                    <button class="red-social__preview-btn" data-url="{{ $redSocial['url'] }}">
                                        <i class="fas fa-eye"></i>
                                        Ver tarjeta de formato enriquecido
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    <div id="btn-agregar-red" class="red-social" data-bs-toggle="modal" data-bs-target="#modalAgregarRedSocial">
                        <div id="red-social__add" class="red-social__add" title="Agregar red social">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button form="form-redes-sociales" class="btn btn-primary mx-3" type="submit">
                <i class="fas fa-pencil-alt"></i>
                &nbsp;Guardar
            </button>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalAgregarRedSocial" tabindex="-1" aria-labelledby="modalAgregarRedSocialLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarRedSocialLabel">Agregar red social</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" form class="btn btn-primary">Agregar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast -->
    <div class="position-fixed top-0 right-0 p-3" style="z-index: 5000; right: 0; bottom: 0;">
        <div id="toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="10000">
            <div class="toast-header">
                <svg class="bd-placeholder-img rounded mr-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" role="img" aria-label=" :  " preserveAspectRatio="xMidYMid slice" focusable="false">
                    <title> </title>
                    <rect width="100%" height="100%" fill="#007aff"></rect><text x="50%" y="50%" fill="##ff0000" dy=".3em"> </text>
                </svg>
                <strong class="mr-auto">No se pudo agregar</strong>
                <small class="text-muted">Justo ahora</small>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                Ocurrió un error, por favor, intente nuevamente, si el error persiste contacte a un administrador.
            </div>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            if ($("#mensajepersonalizado").length > 0) {
                setTimeout(function() {
                    esconderAlerta("mensajepersonalizado");
                }, 3000);
            }

            const btnAgregarRed = document.getElementById("btn-agregar-red");
            const modalAgregarRed = document.getElementById("modalAgregarRedSocial");
            const redesSocialesPreviewBtn = document.getElementsByClassName("red-social__preview-btn");

            let redesSociales = [];

            for (let redSocial of redesSocialesPreviewBtn) {
                redSocial.addEventListener("click", (event) => {
                    const btn = event.currentTarget;
                    btn.disabled = true;

                    const url = btn.getAttribute("data-url");

                    const parentElement = btn.parentElement;

                    parentElement.innerHTML = `<div class="lds-ripple"><div></div><div></div></div>`;

                    fetch('https://api.linkpreview.net', {
                            method: 'POST',
                            mode: 'cors',
                            body: JSON.stringify({
                                key: "402413a9a7b0495d11f85bae23c2b297",
                                q: url
                            }),
                        })
                        .then(res => {
                            if (res.status != 200) {
                                console.log(res.status)
                                throw new Error('something went wrong');
                            }

                            return res.json()
                        })
                        .then(response => {
                            console.log(response)
                            parentElement.classList.add("red-social__preview-rendered");

                            parentElement.innerHTML = `
                        <div class="red-social__preview-img">
                            <img src="${response.image}" alt="Imagen ${response.title}">
                        </div>
                        <div class="red-social__preview-title">
                            ${response.title}
                        </div>

                        <div class="red-social__preview-description">
                            ${response.description}
                        </div>

                        <div class="red-social__preview-url">
                            <a href="${response.url}" target="_blank">${response.url}</a>
                        </div>
                        `;
                        })
                        .catch(error => {
                            console.log(error)
                        })
                })
            }

            // Se agrega el evento para mostrar el modal de agregar red social
            btnAgregarRed.addEventListener("click", (event) => {
                if (redesSociales.length === 0) {
                    modalAgregarRed.querySelector(".modal-body").innerHTML = `<div class="lds-ripple"><div></div><div></div></div>`;
                    modalAgregarRed.querySelector(".modal-body").classList.add("text-center", "mt-3");

                    fetch("{{ route('api-v1-redes-sociales') }}")
                        .then(res => res.json())
                        .then((data) => {
                            let redesOptionsHTML = "";
                            for (let red of data.body.redesSociales) {
                                redesOptionsHTML += `<option value="${red.id}">${red.nombre}</option>`;
                            }

                            modalAgregarRed.querySelector(".modal-body").innerHTML = `
                            <form id="formulario-modal-agregar-red" action="{{ route('paginas-web.index') }}/{{ $paginasWeb[0]->id }}/redes-sociales" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Red social a agregar</label>
                                            <select name="id_red_social" class="form-control" required>
                                                <option value="" selected disabled hidden>Seleccione una red social del listado</option>
                                                ${redesOptionsHTML}
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>URL</label>
                                            <input type="text" name="url" class="form-control" placeholder="Ingresar dirección" required>
                                        </div>
                                    </div>
                                </div>

                            </form>
                            `;

                            modalAgregarRed.querySelector("button[form]").setAttribute("form", "formulario-modal-agregar-red");
                            modalAgregarRed.querySelector(".modal-body").querySelector("form").addEventListener("submit", (event) => {
                                event.preventDefault();
                                modalAgregarRed.querySelector("button[form]").disabled = true;

                                const formData = new FormData(modalAgregarRed.querySelector(".modal-body").querySelector("form"));

                                fetch(modalAgregarRed.querySelector(".modal-body").querySelector("form").action + "?api=true", {
                                        method: "POST",
                                        body: formData,
                                    })
                                    .then(res => res.json())
                                    .then(data => {
                                        if (data.code == 200) {
                                            window.location.reload();
                                        }
                                    })
                                    .catch(e => {
                                        $('#toast').toast('show')

                                        modalAgregarRed.querySelector("button[form]").disabled = false;
                                    });
                            });

                            modalAgregarRed.querySelector(".modal-body").classList.remove("text-center", "mt-3");
                        })
                }

                $('#modalAgregarRedSocial').modal('show');
            });
        });
    </script>
@stop
