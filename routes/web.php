<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

use App\Http\Controllers\Clientes\ClienteController;
use App\Http\Controllers\Afiliados\AfiliadoController;
use App\Http\Controllers\Excursiones\ExcursionController;
use App\Http\Controllers\Excursiones\Imagenes\ExcursionImagenController;
use App\Http\Controllers\Excursiones\Reservaciones\ExcursionReservacionController;
use App\Http\Controllers\Excursiones\Fechas\ExcursionFechaController;
use App\Http\Controllers\Costeos\CosteoController;
use App\Http\Controllers\Promociones\PromocionController;

// use App\Http\Controllers\Terminales\BanregioController;
use App\Http\Controllers\BanregioLinks\BanregioLinkController;
use App\Http\Controllers\Terminales\NetpayController;

use App\Http\Controllers\MiPerfil\MiPerfilController;
use App\Http\Controllers\Salas\SalaController;
use App\Http\Controllers\Usuarios\UsuarioController;
use App\Http\Controllers\Roles\RolController;

use App\Http\Controllers\PaginasWeb\PaginaWebController;
use App\Http\Controllers\Distintivos\DistintivoController;
use App\Http\Controllers\Monedas\MonedaController;

use App\Http\Controllers\NivelesAfiliacion\NivelAfiliacionController;
use App\Http\Controllers\Status\StatusController;
use App\Http\Controllers\Temporadas\TemporadaController;
use App\Http\Controllers\Servicios\ServicioController;
use App\Http\Controllers\Recomendaciones\RecomendacionController;
use App\Http\Controllers\Tipos\TipoController;
use App\Http\Controllers\Categorias\CategoriaController;
use App\Http\Controllers\Categorias\Imagenes\CategoriaImagenController;
use App\Http\Controllers\ClasesServicios\ClaseServicioController;
use App\Http\Controllers\MisTerminales\MiTerminalController;

use App\Http\Controllers\Empresas\EmpresaController;
use App\Http\Controllers\Menu\MenuController;
use App\Http\Controllers\FormasdePago\FormaPagoController;
use App\Http\Controllers\PaginasWeb\RedesSociales\PaginaWebRedSocialController;
use App\Http\Controllers\SitiosTuristicos\Imagenes\SitioTuristicoImagenController;
use App\Http\Controllers\SitiosTuristicos\SitioTuristicoController;
use App\Http\Controllers\Terminales\TerminalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/pruebas', [HomeController::class, 'paginaPruebas'])->name('pagina-pruebas');

////////////////
// Operaciones
////////////////
Route::resource('/admin/clientes',                                              ClienteController::class                            )->names('clientes');
Route::resource('/admin/afiliados',                                             AfiliadoController::class                           )->names('afiliados');
Route::resource('/admin/pipelines',                                             PipelineController::class                           )->names('pipelines');
Route::resource('/admin/excursiones',                                           ExcursionController::class                          )->names('excursiones');
Route::resource('/admin/excursiones/{idExcursion}/imagenes',                    ExcursionImagenController::class                    )->names('excursiones-imagenes');


Route::resource('/admin/fechas',                                                ExcursionFechaController::class                     )->names('excursiones-fechas');
Route::resource('/admin/reservacion-excursiones',                               ExcursionReservacionController::class               )->names('reservacion-excursiones');


Route::get('/admin/excursiones/{idExcursion}',                                  [ExcursionController::class,        'obtenerExcursion']                     )->name('excursion');
Route::get( '/admin/excursiones/{idExcursion}/precios',                         [ExcursionController::class,        'obtenerPreciosExcursion']              )->name('excursion-precios');
Route::get( '/admin/excursiones/{idExcursion}/temporadas',                      [ExcursionController::class,        'obtenerTemporadasExcursion']           )->name('excursion-temporadas');
Route::get( '/admin/excursiones/{idExcursion}/temporadas/{idTemporada}/clases', [ExcursionController::class,        'obtenerClasesExcursionTemporada']      )->name('excursion-temporada-clases');

Route::get( '/admin/excursiones/{idExcursion}/fechas',                          [ExcursionFechaController::class,   'obtenerFechasExcursion']               )->name('excursion-fechas');
Route::get( '/admin/excursiones/{idExcursion}/fechas/{fechas}/edit',            [ExcursionFechaController::class,   'editarExcursionFecha']                 )->name('excursion-fechas-editar');
Route::put( '/admin/excursiones/{idExcursion}/fechas/{fechas}',                 [ExcursionFechaController::class,   'actualizarExcursionFecha']             )->name('excursion-fechas-actualizar');

Route::resource('/admin/costeos',                                               CosteoController::class                             )->names('costeos');
Route::resource('/admin/promociones',                                           PromocionController::class                          )->names('promociones');

////////////////
// Terminal online
////////////////
Route::resource('/admin/banregio',                                              BanregioLinkController::class                       )->names('banregiolinks');
Route::get('/admin/netpay',                                                     [NetpayController::class,       'index']            )->name('netpay');

////////////////
// Configuración
////////////////
Route::resource('/admin/mi_perfil',                                             MiPerfilController::class                           )->names('mi_perfil');
Route::resource('/admin/salas',                                                 SalaController::class                               )->names('salas');
Route::resource('/admin/usuarios',                                              UsuarioController::class                            )->names('usuarios');
Route::resource('/admin/roles',                                                 RolController::class                                )->names('roles');

Route::get(
    '/admin/empresas/{idEmpresa}/roles',
    [EmpresaController::class, 'obtenerRolesEmpresa']
)->name('empresas-roles');

////////////////
// Mi pagina web
////////////////
Route::resource('/admin/paginas-web',                                           PaginaWebController::class                          )->names('paginas-web');

Route::get('/admin/redes-sociales',                                             [PaginaWebController::class, 'redessociales']       )->name('redessociales');
Route::resource(
    '/admin/paginas-web/{paginaWebId}/redes-sociales',
    PaginaWebRedSocialController::class
)->names('pagina-web-redes');

Route::get('/admin/aviso-privacidad',                                           [PaginaWebController::class, 'avisoprivacidad']     )->name('avisoprivacidad');
Route::get('/admin/politicas',                                                  [PaginaWebController::class, 'politicacancelacion'] )->name('politicacancelacion');
Route::resource('/admin/distintivos',                                           DistintivoController::class                         )->names('distintivos');
Route::get('/admin/codigo-externo',                                             [PaginaWebController::class, 'codigoexterno']       )->name('codigoexterno');
Route::get('/admin/resenas',                                                    [PaginaWebController::class, 'resenas']             )->name('resenas');
Route::resource('/admin/monedas',                                               MonedaController::class                             )->names('monedas');

////////////////
// Mi sistema
////////////////
Route::resource('/admin/nivelafiliacion',                                       NivelAfiliacionController::class                    )->names('nivelafiliacion');
Route::resource('/admin/status',                                                StatusController::class                             )->names('status');
Route::resource('/admin/temporadas',                                            TemporadaController::class                          )->names('temporadas');
Route::resource('/admin/servicios',                                             ServicioController::class                           )->names('servicios');
Route::resource('/admin/recomendaciones',                                       RecomendacionController::class                      )->names('recomendaciones');
Route::resource('/admin/categorias',                                            CategoriaController::class                          )->names('categorias');
Route::resource('/admin/categorias/{idCategoria}/imagenes',                     CategoriaImagenController::class               )->names('categorias-imagenes');
Route::resource('/admin/clases-servicios',                                      ClaseServicioController::class                      )->names('clases-servicios');
Route::resource('/admin/tipos',                                                 TipoController::class                               )->names('tipos');
Route::resource('/admin/mis-terminales',                                        MiTerminalController::class                         )->names('mis-terminales');
Route::resource('/admin/sitios-turisticos',                                     SitioTuristicoController::class                     )->names('sitios-turisticos');
Route::resource('/admin/sitios-turisticos/{idSitioTuristico}/imagenes',         SitioTuristicoImagenController::class               )->names('sitios-turisticos-imagenes');


Route::resource('/admin/empresas',                                              EmpresaController::class                            )->names('empresas');
Route::resource('/admin/modulos',                                               MenuController::class                               )->names('modulos');
Route::resource('/admin/formaspago',                                            FormaPagoController::class                          )->names('formaspago');
Route::resource('/admin/terminales',                                            TerminalController::class                           )->names('terminales');
