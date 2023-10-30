<form id="form-agregar-recomendacion" class="{{ $className }}" action="{{ route('recomendaciones.store') }}" method="post">
    @csrf

    <div class="row">
        <div class="@if ($layout === "original") col-md-6 col-sm-6 @else col-12 @endif">
            <div class="form-group">
                <label for="form-agregar-recomendacion__nombre">Nombre</label>
                <input type="text" id="form-agregar-recomendacion__nombre" name="nombre" class="form-control" placeholder="Ingresar nombre" required>
            </div>
        </div>

        <div class="@if ($layout === "original") col-md-6 col-sm-6 @else col-12 @endif">
            <div class="form-group">
                <label for="form-agregar-recomendacion__descripcion">Descripción <small class="text-muted">(Opcional)</small></label>
                <textarea type="text" id="form-agregar-recomendacion__descripcion" name="descripcion" class="form-control" placeholder="Ingresar descripción..." style="height: 100px"></textarea>
            </div>
        </div>

        @if (filter_var($btnSubmit ?? true, FILTER_VALIDATE_BOOLEAN) === true)
        <div class="col-12">
            <button type="submit" class="btn btn-sm btn-primary d-block ml-auto">Agregar elemento</button>
        </div>
        @endif
    </div>
</form>