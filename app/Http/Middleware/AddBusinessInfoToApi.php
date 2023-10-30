<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Empresas\Empresa;

class AddBusinessInfoToApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->is('api/v1/*')) {
            $apiKey = explode($request->schemeAndHttpHost() . "/api/v1/", $request->url());
            $apiKey = explode("/", $apiKey[1])[0];

            $apiKey = [
                "length" => strlen($apiKey),
                "value" => $apiKey
            ];
    
            if ($apiKey["length"] === 20) {
                $apiKey["type"] = "public";
                $apiKey["business"] = Empresa::where("public_key", "=", $apiKey["value"])
                    ->select()
                    ->first();
            } else if ($apiKey["length"] === 35) {
                $apiKey["type"] = "private";
                $apiKey["business"] = Empresa::where("private_key", "=", $apiKey["value"])
                    ->select()
                    ->first();
            } else {
                return response()->json([
                    'code' => '400',
                    'body' => [
                        "msg" => "La longitud de la llave publica o privada es incorrecta"
                    ]
                ], 400);
            }
         
            $request->merge(['apiKey' => $apiKey]);
        }

        return $next($request);
    }
}
