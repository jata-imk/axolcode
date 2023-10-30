<?php

namespace App\View\Components\Recomendaciones\Formularios;

use Illuminate\View\Component;

class agregar extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $className = "",
        public string $btnSubmit = "true",
        public string $layout = "original",
    )
    { }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.recomendaciones.formularios.agregar');
    }
}
