<?php

namespace App\View\Components\Excursiones;

use Illuminate\View\Component;

class TarjetaPrecio extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public $tipoHabitacion,
        public $excursion,
        public $temporada,
        public $claseServicio,
        public $excursionTemporadaClaseCosto,
        public $costeos,
        public $excursionCosteos,
    ) { }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.excursiones.tarjeta-precio');
    }
}
