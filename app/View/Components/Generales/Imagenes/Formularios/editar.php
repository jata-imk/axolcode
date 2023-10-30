<?php

namespace App\View\Components\Generales\Imagenes\Formularios;

use Illuminate\View\Component;

class editar extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $path,
        public string $action,
        public string $imagenId,
        public string $titulo = "",
        public string $descripcion = "",
        public string $leyenda = "",
        public string $textoAlternativo = "",
        public string $className = "",
        public string $btnSubmit = "true",
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.generales.imagenes.formularios.editar');
    }
}
