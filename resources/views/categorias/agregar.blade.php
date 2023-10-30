@extends('adminlte::page')

@include('custom_meta_tags')

@section('title', 'Agregar categoría de excursión')

@section('content_header')
    <h1><span class="font-weight-bold">CloudTravel</span> | Agregar categoría de excursión</h1>
@stop

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
        </div>

        <div class="card-body">
            <form id="form-agregar-categoria" action="{{ route('categorias.store') }}" method="post">
                @csrf

                <div class="row form-title-section mb-2">
                    <i class="fas fa-umbrella-beach"></i>
                    <h6>Datos de la categoría de la excursión</h6>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" class="form-control" placeholder="Ingresar nombre" required>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="form-floating">
                            <label>Descripción de la categoría</label>
                            <textarea name="descripcion" class="form-control" placeholder="Agregar una descripción de la categoría de la excursión" style="height: 100px" required></textarea>
                        </div>
                    </div>
                </div>

                <div class="row form-title-section mt-4 mb-2">
                    <i class="fas fa-images"></i>
                    <h6>Galería de <span class="text-info">imágenes</span></h6>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div id="agregar-categoria-dropzone" class="dropzone">
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end p-3">
            <button form="form-agregar-categoria-tour" class="btn btn-primary mx-3" type="submit">
                <i class="fas fa-pencil-alt"></i>
                &nbsp;Agregar categoría
            </button>

            <a href="{{ route('categorias.index') }}" class="btn btn-danger" type="button">
                <i class="fas fa-times-circle"></i>
                &nbsp;Cancelar
            </a>
        </div>
    </div>
@stop

@section('plugins.Dropzone', true)

@section('css')
    <link rel="stylesheet" href={{ asset('/assets/css/admin_custom.css') }}>
@stop

@section('js')
<script>
    Dropzone.autoDiscover = false;
</script>

<script>
    $(function() {
        const formularioAgregarCategoria = document.getElementById("form-agregar-categoria");

        // Dropzone
        let newDropZone = new Dropzone(`#agregar-categoria-dropzone`, {
            url: "./admin/categorias/",
            paramName: 'file[]',
            autoProcessQueue: false,
            addRemoveLinks: true,
            dictDefaultMessage: "Arrastre o de click para agregar las imágenes",
            dictCancelUpload: "Cancelar subida",
            dictCancelUploadConfirmation: "¿Está seguro que desea cancelar la subida de la imagen?",
            dictRemoveFile: "Eliminar imagen",
            acceptedFiles: "image/*",
            previewTemplate: `
                <div class="dz-preview dz-image-preview">
                    <div class="dz-image">
                        <img data-dz-thumbnail="">
                    </div>
                    <div class="dz-error-message">
                        <span data-dz-errormessage></span>
                    </div>
                </div>
            `
        });

        formularioAgregarCategoria.addEventListener("submit", (event) => {
            event.preventDefault();

            const formData = new FormData(formularioAgregarCategoria);

            for (let file of Dropzone.instances[0].files) {
                formData.append("file[]", file);
            }

            fetch(`./admin/categorias?api=true`, {
                method: "POST",
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.code == 201) {
                    document.location.href = "{{ route('categorias.index') }}";
                }
            })
            .catch(e => {
                console.log(e)
            });
        });
    });
</script>
@stop