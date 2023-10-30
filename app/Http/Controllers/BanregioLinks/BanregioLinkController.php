<?php

namespace App\Http\Controllers\BanregioLinks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BanregioLinks\BanregioLink;
use App\Models\Terminales\Terminal;
use App\Models\PaginasWeb\PaginaWeb;


class BanregioLinkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $web = PaginaWeb::
        where('id_empresa', '=', Auth::user()->id_empresa)
        ->select('pagina_web')
        ->get();

        $links = BanregioLink::where('id_empresa', '=', Auth::user()->id_empresa)
            ->select()
            ->get();

        return view('banregio_links.index', compact('links', 'web'));
    }

    public function create() {
        return view('banregio_links.agregar');
    }

    public function store(Request $request) {
        $idterminal = $request->id_terminal;
        $terminal = Terminal::find($idterminal);

        $form = $request->all();
        $form["id_empresa"] = Auth::user()->id_empresa;
        $form["id_usuario"] = Auth::user()->id;
        $form["comision_base"] = $terminal->comision_base;
        $form["link"] = $this->generateRandomString(10);

        switch ($request->meses) {
            case 1:
                $form["sobre_tasa"] = 0;
                break;
            case 3:
                $form["sobre_tasa"] = $terminal->tres_meses;
                break;
            case 6:
                $form["sobre_tasa"] = $terminal->seis_meses;
                break;
            case 9:
                $form["sobre_tasa"] = $terminal->nueve_meses;
                break;
            case 12:
                $form["sobre_tasa"] = $terminal->doce_meses;
                break;
        }

        BanregioLink::create($form);
        return redirect()->route('banregiolinks.index')->with('message', 'Link creado correctamente');
    }

    public function edit($id){
        $link = BanregioLink::find($id);

        return view('banregio_links.editar', compact(
            'link'
        ));
    }

    public function update(Request $request, BanregioLink $link){
        $form = $request->all();
        $idlink = $request->id;
        $elLink = BanregioLink::find($idlink);

        $idterminal = $request->id_terminal;
        $terminal = Terminal::find($idterminal);

        $form["comision_base"] = $terminal->comision_base;
        switch ($request->meses) {
            case 1:
                $form["sobre_tasa"] = 0;
                break;
            case 3:
                $form["sobre_tasa"] = $terminal->tres_meses;
                break;
            case 6:
                $form["sobre_tasa"] = $terminal->seis_meses;
                break;
            case 9:
                $form["sobre_tasa"] = $terminal->nueve_meses;
                break;
            case 12:
                $form["sobre_tasa"] = $terminal->doce_meses;
                break;
        }

        $elLink->update($form);

        return redirect()->route('banregiolinks.index')->with('message', 'Link actualizado con éxito');
    }

    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
}
