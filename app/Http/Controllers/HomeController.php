<?php

namespace App\Http\Controllers;

use App\Models\Servicios\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    function paginaPruebas() {
        $idEmpresa = Auth::user()->id_empresa;

        // Ahora pasamos a obtener la información de los servicios, recomendaciones y categorías
        $servicios = Servicio::where('id_empresa', '=', $idEmpresa)
            ->select()
            ->get();

        return view("pruebas", compact(
            'servicios'
        ));
    }
}
