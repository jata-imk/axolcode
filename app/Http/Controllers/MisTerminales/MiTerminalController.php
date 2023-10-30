<?php

namespace App\Http\Controllers\MisTerminales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\MisTerminales\MiTerminal;
use App\Models\Terminales\Terminal;

class MiTerminalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $idempresa = Auth::user()->id_empresa;
        $terminales = Terminal::
        where('terminales.estatus', '=', 1)
        ->select('terminales.id as idTerminal', 'terminales.nombre', 'terminales_empresas.*')
        ->leftJoin('terminales_empresas', function($join) use ($idempresa)
        {
            $join->on('terminales_empresas.id_terminal', '=', 'terminales.id')
                  ->where('terminales_empresas.id_empresa', '=', $idempresa);

        })
        ->get();
        return view('mis_terminales.index', compact('terminales'));
    }

    public function create(Request $request){
        $terminal = $request->id;
        $nombre = $request->nombre;
        return view('mis_terminales.agregar', compact('terminal', 'nombre'));
    }

    public function store(Request $request){
        $form = $request->all();
        $form["id_empresa"] = Auth::user()->id_empresa;
        MiTerminal::create($form);
        return redirect()->route('mis-terminales.index')->with('message', 'Terminal configurada exitósamente');
    }

    public function edit($idterminal){
        $terminal = MiTerminal::find($idterminal);
        return view('mis_terminales.editar', compact('terminal'));
    }

    public function update(Request $request, Terminal $terminal){
        $idterminal = $request->id_terminal;
        $laterminal = MiTerminal::find($idterminal);
        $laterminal->update($request->all());
        return redirect()->route('mis-terminales.index')->with('message', 'Terminal actualizada con éxito');
    }
}
