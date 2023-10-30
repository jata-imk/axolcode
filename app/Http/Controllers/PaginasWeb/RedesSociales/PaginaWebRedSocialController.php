<?php

namespace App\Http\Controllers\PaginasWeb\RedesSociales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\PaginasWeb\RedesSociales\PaginaWebRedSocial;

class PaginaWebRedSocialController extends Controller
{
    public static function store(Request $request, $idPaginaWeb)
    {
        $paginaWebRedSocial = new PaginaWebRedSocial();

        $paginaWebRedSocial->id_empresa = Auth::user()->id_empresa;
        $paginaWebRedSocial->id_usuario = Auth::user()->id;
        $paginaWebRedSocial->id_pagina_web = $idPaginaWeb;
        $paginaWebRedSocial->id_red_social = $request->input("id_red_social");
        $paginaWebRedSocial->url = $request->input("url");

        $paginaWebRedSocial->save();

        if ($request->query("api")) {
            if ($request->query("api") == "true") {
                return response()->json([
                    'code' => '200',
                    'body' => [
                        "paginaWeb" => [
                            "id" => $idPaginaWeb,
                            "redSocial" => $paginaWebRedSocial
                        ]
                    ]
                ], 200);
            }
        }
    }
}