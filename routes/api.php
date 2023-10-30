<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Aerolineas\AerolineaController;
use App\Http\Controllers\Empresas\APIEmpresaController;
use App\Http\Controllers\Excursiones\APIExcursionController;
use App\Http\Controllers\Excursiones\Fechas\APIExcursionFechaController;
use App\Http\Controllers\Costeos\APICosteoController;
use App\Http\Controllers\RedesSociales\APIRedSocialController;
use App\Http\Controllers\SitiosTuristicos\APISitioTuristicoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get("v1/aerolineas", [AerolineaController::class,'index'])
    ->name("api-v1-aerolineas");
    
Route::get("v1/redes-sociales", [APIRedSocialController::class, 'index'])
    ->name("api-v1-redes-sociales");

Route::get("v1/{key}/empresa", [APIEmpresaController::class, 'index'])
    ->name("api-v1-empresa")
    ->middleware('api.add-credentials');

Route::get("v1/{key}/empresa/snippets/{nombre?}", [APIEmpresaController::class, 'snippets'])
    ->name("api-v1-empresa-snippets")
    ->middleware('api.add-credentials');

Route::resource("v1/{key}/excursiones", APIExcursionController::class)
    ->names("api-v1-excursiones")
    ->middleware('api.add-credentials');

Route::resource("v1/{key}/excursiones/{idExcursion}/fechas", APIExcursionFechaController::class)
    ->names("api-v1-excursiones-fechas")
    ->middleware('api.add-credentials');

Route::resource("v1/{key}/excursiones/{idExcursion}/costeos", APICosteoController::class)
    ->names("api-v1-excursiones-costeos")
    ->middleware('api.add-credentials');

Route::resource("v1/{key}/sitios-turisticos", APISitioTuristicoController::class)
    ->names("api-v1-sitios-turisticos")
    ->middleware('api.add-credentials');

Route::resource("v1/{key}/costeos", APICosteoController::class)
    ->names("api-v1-costeos")
    ->middleware('api.add-credentials');

