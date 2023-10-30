<?php

namespace App\Http\Controllers\Terminales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Terminales\Terminal;

class TerminalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $terminales = Terminal::select('*')->get();
        return view('terminales.index', compact('terminales'));
    }

    public function create(){
        return view('terminales.agregar');
    }

    public function store(Request $request){
        $form = $request->all();

        Terminal::create($form);
        return redirect()->route('terminales.index')->with('message', 'Terminal guardada exitósamente');
    }

    public function edit($idterminal){
        $terminal = Terminal::find($idterminal);
        return view('terminales.editar', compact('terminal'));
    }

    public function update(Request $request, Terminal $terminal){
        $idterminal = $request->idterminal;
        $laterminal = Terminal::find($idterminal);
        $laterminal->update($request->all());
        return redirect()->route('terminales.index')->with('message', 'Terminal actualizada con éxito');
    }

    public function destroy(Request $request, Terminal $terminal){
        $terminal = Terminal::find($request->idterminal);
        $form["estatus"] = 0;
        $terminal->update($form);
    }
}
