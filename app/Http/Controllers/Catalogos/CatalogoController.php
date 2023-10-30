<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CatalogoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('afiliados.index');
    }

    public function nivelafiliados(){
        return view('afiliados.index');
    }
}
