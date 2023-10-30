<?php

namespace App\Http\Controllers\PaginasWeb;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\PaginasWeb\PaginaWeb;
use App\Models\PaginasWeb\RedesSociales\PaginaWebRedSocial;

use Illuminate\Support\Facades\DB;

class PaginaWebController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function update(Request $request, PaginaWeb $paginaweb) {
        $web = $paginaweb::find($request->id);
        $ruta = $request->ruta;

        $web->update($request->all());
        $this->sincronizarRedesSociales($request, $web->id);

        return redirect()->route($ruta)->with('message', "La información se ha guardado con éxito!");
    }

    private function agregarPaginaWebRedSocial(Request $request, $idEmpresa,  $idUsuario, $idPaginaWeb, $idRedSocial) {
        $formularioAgregarRedSocial = [];

        $formularioAgregarRedSocial["id_empresa"] = $idEmpresa;
        $formularioAgregarRedSocial["id_usuario"] = $idUsuario;
        $formularioAgregarRedSocial["id_pagina_web"] = $idPaginaWeb;
        $formularioAgregarRedSocial["id_red_social"] = $idRedSocial;
        $formularioAgregarRedSocial["url"] = $request->input("pagina-web-red-social-" . $idRedSocial) ?? "0";

        PaginaWebRedSocial::create($formularioAgregarRedSocial);
    }

    private function sincronizarRedesSociales(Request $request, $idPaginaWeb)
    {
        $idEmpresa = Auth::user()->id_empresa;
        $idUsuario = Auth::user()->id;

        // Primero obtenemos las redes sociales actuales de la excursión
        $paginaWebRedesSociales = PaginaWebRedSocial::where('id_empresa', '=', $idEmpresa)
            ->where('id_pagina_web', '=', $idPaginaWeb)
            ->select()
            ->get();

        $redesSocialesOriginales = array_column($paginaWebRedesSociales->toArray(), "id_red_social");
        $redesSocialesActualizadas = $request->input("pagina-web-redes-sociales") ?? [];

        $redesSocialesActualizar = [];
        $redesSocialesAgregar = [];
        $redesSocialesEliminar = [];

        foreach ($redesSocialesActualizadas as $idRedSocialActualizada) {
            if (array_search($idRedSocialActualizada, $redesSocialesOriginales) !== false) {
                $redesSocialesActualizar[] = (int) $idRedSocialActualizada;
            } else {
                $redesSocialesAgregar[] = (int) $idRedSocialActualizada;
            }
        }

        foreach ($redesSocialesOriginales as $redSocialOriginalId) {
            if (!(array_search($redSocialOriginalId, $redesSocialesActualizadas) !== false)) {
                $redesSocialesEliminar[] = (int) $redSocialOriginalId;
            }
        }

        if (count($redesSocialesEliminar) > 0) {
            DB::table('paginas_web_redes_sociales')
                ->where('id_pagina_web', '=', $idPaginaWeb)
                ->whereIn('id_red_social', $redesSocialesEliminar)
                ->delete();
        }

        foreach ($redesSocialesAgregar as $idRedSocial) {
            $redSocialAgregar = $request->input("pagina-web-red-social-$idRedSocial") ?? [];

            foreach ($redSocialAgregar as $idRedSocialAgregar) {
                $this->agregarPaginaWebRedSocial($request, $idEmpresa, $idUsuario, $idPaginaWeb, $idRedSocial, $idRedSocialAgregar);
            }
        }

        foreach ($redesSocialesActualizar as $idRedSocial) {
            $paginaWebRedSocial = $paginaWebRedesSociales->firstWhere("id_red_social", "=", $idRedSocial);

            $paginaWebRedSocial->url = $request->input("pagina-web-red-social-" . $idRedSocial);

            if ($paginaWebRedSocial->isDirty()) {
                $paginaWebRedSocial->save();
            }
        }
    }

    public function redessociales()
    {
        $paginasWeb = PaginaWeb::where('id_empresa', '=', Auth::user()->id_empresa)
            ->select()
            ->get();

        foreach ($paginasWeb as $paginaWeb) {
            # code...
            $paginaWeb->redes_sociales = PaginaWebRedSocial::leftJoin("redes_sociales", "paginas_web_redes_sociales.id_red_social", "=", "redes_sociales.id")
                ->where("paginas_web_redes_sociales.id_pagina_web", "=", $paginaWeb->id)
                ->select([
                    "paginas_web_redes_sociales.id",
                    "redes_sociales.id as id_red_social",
                    "redes_sociales.nombre",
                    "redes_sociales.icon",
                    "redes_sociales.icon_color",
                    "paginas_web_redes_sociales.url",
                    "paginas_web_redes_sociales.created_at",
                    "paginas_web_redes_sociales.updated_at",
                ])
                ->get();
        }

        // echo "<pre>";
        // var_dump($paginasWeb[0]->redes_sociales->toArray());
        // echo "</pre>";die;

        return view('paginaweb.redessociales', compact('paginasWeb'));
    }

    public function avisoprivacidad()
    {
        $paginaweb = $this->myWebPage();
        return view('paginaweb.avisoprivacidad', compact('paginaweb'));
    }

    public function politicacancelacion(){
        $paginaweb = $this->myWebPage();
        return view('paginaweb.politicas', compact('paginaweb'));
    }

    public function resenas()
    {
        $paginaweb = $this->myWebPage();
        return view('paginaweb.resenas', compact('paginaweb'));
    }

    public function codigoexterno()
    {
        $paginaweb = $this->myWebPage();
        return view('paginaweb.codigos', compact('paginaweb'));
    }

    private function myWebPage(){
        $paginaweb = PaginaWeb::
                    where('id_empresa', '=', Auth::user()->id_empresa)
                    ->select('*')
                    ->get();
        return $paginaweb;
    }
}
