<?php

namespace App\Http\Controllers\RedesSociales;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\RedesSociales\RedSocial;

class APIRedSocialController extends Controller
{
    public static function index(Request $request)
    {
        $redesSociales = RedSocial::all(
            [
                "id",
                "nombre",
                "icon",
                "icon_color",
            ]
        );

        if ((isset($request["json"]) && $request["json"] === false) || (isset($request["controller"]) && $request["controller"] === true)) {
            return $redesSociales;
        }

        return response()->json([
            'code' => '200',
            'body' => [
                "redesSociales" => $redesSociales,
            ]
        ]);
    }
}
