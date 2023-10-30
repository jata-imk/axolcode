<?php

namespace App\Http\Controllers\Terminales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BanregioController extends Controller
{
    public function index(){
        //$servicios = Servicio::where('id_empresa', '=', Auth::user()->id_empresa)->select('*')->get();
        //$cservicio = Servicio::where('id_empresa', '=', Auth::user()->id_empresa)->select('*')->get()->count();
        //return view('servicios.index', compact('servicios', 'cservicio'));
    }
}
