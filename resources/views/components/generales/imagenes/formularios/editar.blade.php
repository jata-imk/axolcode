<form id="formulario-modal-editar-imagen" class="{{ $className }}" action="{{ $action }}" method="post">
    @csrf
    @method('patch')

    <div class="row">
        <div class="col-md-6 col-sm-12">
            <img src="{{ $path }}" alt="{{ $textoAlternativo }}" class="mw-100">
        </div>

        <div class="col-md-6 col-sm-12">
            <div class="row">
                {{ $imagenInfo}}

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="texto_alternativo">Texto alternativo</label>
                        <textarea name="texto_alternativo" class="form-control" id="" style="height: 100px">{{ $textoAlternativo }}</textarea>

                        <small class="form-text text-muted">
                            <a href="https://www.w3.org/QA/Tips/altAttribute.html.es" target="_blank">Aprende cómo describir el propósito de la imagen.</a> Déjalo vacío si la imagen es puramente decorativa.
                        </small>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Titulo</label>
                        <input type="text" name="titulo" class="form-control" value="{{ $titulo }}">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Leyenda</label>
                        <input type="text" name="leyenda" class="form-control" value="{{ $leyenda }}">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <input type="text" name="descripcion" class="form-control" value="{{ $descripcion }}">
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>URL del archivo</label>
                        <input type="text" name="url" class="form-control" value="{{ $path }}" disabled>
                    </div>
                </div>
            </div>
        </div>

        @if (filter_var($btnSubmit ?? true, FILTER_VALIDATE_BOOLEAN) === true)
        <div class="col-12">
            <button type="submit" class="btn btn-sm btn-primary d-block ml-auto">Guardar cambios</button>
        </div>
        @endif
    </div>
</form>