<?php

namespace App\Http\Controllers\Excursiones\Reservaciones;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Clientes\Cliente;

use App\Models\Excursiones\Excursion;
use App\Http\Controllers\Excursiones\ExcursionController;

use App\Http\Controllers\Promociones\PromocionController;

use App\Models\Excursiones\Fechas\ExcursionFecha;
use App\Models\Excursiones\TemporadasCostos\ExcursionTemporadaCosto;
use App\Models\Excursiones\Reservaciones\ExcursionReservacion;
use App\Models\Excursiones\Reservaciones\ExcursionReservacionCosto;
use App\Models\Excursiones\Reservaciones\ExcursionReservacionHabitacion;
use App\Models\Excursiones\Reservaciones\ExcursionReservacionPax;
use App\Models\Excursiones\Reservaciones\ExcursionReservacionVuelo;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ExcursionReservacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $reservaciones = ExcursionReservacion::leftJoin('excursiones', 'excursiones_reservaciones.id_excursion', '=', 'excursiones.id')
            ->leftJoin('tipos', 'excursiones.id_tipo', '=', 'tipos.id')
            ->leftJoin('clientes', 'excursiones_reservaciones.id_cliente', '=', 'clientes.id')
            ->leftJoin('excursiones_fechas', 'excursiones_reservaciones.id_fecha', '=', 'excursiones_fechas.id')
            ->where('excursiones_reservaciones.id_empresa', '=', Auth::user()->id_empresa)
            ->select([
                'excursiones.nombre as excursion_nombre',
                DB::raw('(SELECT path FROM excursiones_imagenes WHERE id_excursion = excursiones.id AND principal_tarjetas = 1) AS excursion_path_imagen'),
                'tipos.nombre as tipo_nombre',
                'clientes.nombre as cliente_nombre',
                'clientes.apellido as cliente_apellido',
                'clientes.telefono_celular as cliente_telefono_celular',
                'clientes.telefono_celular_iso_pais as cliente_telefono_celular_iso_pais',
                'excursiones_reservaciones.*',
                'excursiones_fechas.fecha_inicio',
                'excursiones_fechas.fecha_fin',
                'excursiones_reservaciones.fecha_inicio as fecha_inicio_personalizada',
                'excursiones_reservaciones.fecha_fin as fecha_fin_personalizada',
            ])
            ->get();

        return view('excursiones.reservaciones.index', compact(
            'reservaciones'
        ));
    }
    
    public function create()
    {
        $excursiones = Excursion::leftJoin("tipos", "excursiones.id_tipo", "=", "tipos.id")
            ->where("excursiones.id_empresa", "=", Auth::user()->id_empresa)
            ->select([  "excursiones.id",
                        "excursiones.nombre",
                    ])
            ->get();

        $parentescos = DB::table('parentescos')->select()->get();
        $formasPago = DB::table('formas_pago')->select()->get();

        return view('excursiones.reservaciones.agregar', compact(
            'excursiones',
            'parentescos',
            'formasPago',
        ));
    }

    public function store(Request $request)
    {
        $formReserva = $request->all();

        // TODO: Validar promoción

        $formReserva["id_empresa"]   = Auth::user()->id_empresa;
        $formReserva["id_usuario"]   = Auth::user()->id;

        if (($request->has("fecha-personalizada")) && ($request->input("fecha-personalizada") === 1)) {
            $formReserva["id_fecha"]     = 0;
            $formReserva["fecha_inicio"] = $request->input("fecha_inicio")  ?? "0001-01-01";
            $formReserva["fecha_fin"]    = $request->input("fecha_fin")     ?? "0001-01-01";
        } else {
            $formReserva["id_fecha"]     = $request->input("id_fecha")      ?? 0;
            $formReserva["fecha_inicio"] = "0001-01-01";
            $formReserva["fecha_fin"]    = "0001-01-01";
        }
        
        $formReserva["id_afiliado"]  = $request->input("id_afiliado") ?? 0;
        
        $formReserva["hoteleria"]    = (
            ($request->has("hoteleria"))
            && ($request->input("hoteleria") == 1)
        )
        ? 1
        : 0;

        $formReserva["vuelos"]       = (
            ($request->has("vuelos"))
            && ($request->input("vuelos") == 1)
        ) 
        ? 1
        : 0;

        $formReserva["cantidad_adultos"]    = $request->has("adulto-nombre") ? 1 + count($request->input("adulto-nombre")) : 1;
        $formReserva["cantidad_menores"]    = (
            ($request->has("menores"))
            && ($request->input("menores") == 1)
            && ($request->has("menor-nombre"))
        )
        ? count($request->input("menor-nombre"))
        : 0;
        
        $formReserva["cantidad_infantes"]    = (
            ($request->has("infantes"))
            && ($request->input("infantes") == 1)
            && ($request->has("infante-nombre"))
        )
        ? count($request->input("infante-nombre"))
        : 0;
        
        $formReserva["contrato"] = "";

        $reserva = ExcursionReservacion::create($formReserva);

        ////////////////////////////
        // Se guardan los precios
        ////////////////////////////
        $this->storeReservacionPrecios($request, $reserva->id);

        ////////////////////////////
        // Se guardan los pasajeros
        ////////////////////////////
        //  Primero el cliente titular de la reservación
        $this->storeReservacionCliente($request, $reserva->id);

        // Ahora todos los acompañantes (Si aplica)
        if (!$request->has("hoteleria")) {
            // Si la reservación no incluye hotelería se guarda la información de
            // los acompañantes directamente, de lo contrario primero hay que guardar las habitaciones
            $this->storeReservacionPaxes($request, $reserva->id);
        } else {
            // Se guardan las habitaciones dentro de las cuales vienen los pasajeros
            $this->storeReservacionHabitaciones($request, $reserva->id);
        }

        return redirect()->route('reservacion-excursiones.index')->with('message', "La reserva se ha creado con éxito, bien hecho!");
    }

    public function edit(Request $request, $idReservacion) {
        DB::statement("SET SQL_MODE=''");

        $reservacion = ExcursionReservacion::leftJoin('excursiones', 'excursiones_reservaciones.id_excursion', '=', 'excursiones.id')
            ->leftJoin('tipos', 'excursiones.id_tipo', '=', 'tipos.id')
            ->leftJoin('clientes', 'excursiones_reservaciones.id_cliente', '=', 'clientes.id')
            ->leftJoin('monedas', 'excursiones_reservaciones.id_moneda', '=', 'monedas.id')
            ->leftJoin('excursiones_fechas', 'excursiones_reservaciones.id_fecha', '=', 'excursiones_fechas.id')
            ->leftJoin('excursiones_temporadas_costos', 'excursiones_fechas.id_temporada_costo', '=', 'excursiones_temporadas_costos.id')
            ->where('excursiones_reservaciones.id_empresa', '=', Auth::user()->id_empresa)
            ->where('excursiones_reservaciones.id', '=', $idReservacion)
            ->select([
                'excursiones.nombre as excursion_nombre',
                'excursiones.vuelos as excursion_vuelos',
                DB::raw('(SELECT path FROM excursiones_imagenes WHERE id_excursion = excursiones.id AND principal_tarjetas = 1) AS excursion_path_imagen'),
                'tipos.nombre as tipo_nombre',
                'clientes.nombre as cliente_nombre',
                'clientes.apellido as cliente_apellido',
                'monedas.nombre as moneda_nombre',
                'monedas.iso as moneda_iso',
                'excursiones_reservaciones.*',
                'excursiones_fechas.fecha_inicio',
                'excursiones_fechas.fecha_fin',
                'excursiones_reservaciones.fecha_inicio as fecha_inicio_personalizada',
                'excursiones_reservaciones.fecha_fin as fecha_fin_personalizada',
                'excursiones_temporadas_costos.id_temporada as excursion_fecha_temporada_id',
                'excursiones_temporadas_costos.id_clase_servicio as excursion_fecha_clase_id',
            ])
            ->first();
            
        list(
            $excursionTemporadas,
            $excursionTemporadasClases,
            $excursionTemporadasClasesFechas,
        ) = $this->getInfoExcursion($reservacion);

        $reservacionPrecios = ExcursionReservacionCosto::where('id_excursion_reservacion', '=', $reservacion->id)
            ->select()
            ->first();

        $reservacionHabitaciones = ExcursionReservacionHabitacion::where('id_excursion_reservacion', '=', $reservacion->id)
            ->select()
            ->get();

        $reservacionPaxes = ExcursionReservacionPax::where('id_excursion_reservacion', '=', $reservacion->id)
            ->select()
            ->get();
        
        $reservacionVuelos = ExcursionReservacionVuelo::leftJoin('aerolineas', 'excursiones_reservaciones_vuelos.id_aerolinea', '=', 'aerolineas.id')
            ->where('id_excursion_reservacion', '=', $reservacion->id)
            ->select([
                'excursiones_reservaciones_vuelos.*',
                'aerolineas.name as aerolinea_nombre'
            ])
            ->get();

        // Este objecto sirve parea el JS de el formulario de edición de reservaciones
        $excursion = json_decode((new ExcursionController())->obtenerExcursion($reservacion->id_excursion)->getContent());
        $objExcursion = json_encode($excursion->body->excursion, JSON_INVALID_UTF8_IGNORE);
        
        // Este otro objeto se usará para validar la promoción en el JS del formulario de edición de reserva

        $promocionExcursion = [
            "excursionPromocion" => [],
            "promocion" => (object) [],
            "validity" => false
        ];

        if ($reservacion->id_promocion !== 0) { 
            $promocionId = $reservacion->id_promocion;
            $promocion = (new PromocionController())->show($promocionId);
    
            $promocionExcursion = [
                "excursionPromocion" => $excursion->body->promocion,
                "promocion" => $promocion,
                "validity" => false
            ];
        }
                    
        $excursiones = Excursion::leftJoin("tipos", "excursiones.id_tipo", "=", "tipos.id")
            ->where("excursiones.id_empresa", "=", Auth::user()->id_empresa)
            ->select([  "excursiones.id",
                        "excursiones.nombre",
                    ])
            ->get();
        $parentescos = DB::table('parentescos')->select()->get();
        $formasPago = DB::table('formas_pago')->select()->get();

        return view('excursiones.reservaciones.editar', compact(
            'reservacion',
            'excursionTemporadas',
            'excursionTemporadasClases',
            'excursionTemporadasClasesFechas',
            'reservacionPrecios',
            'reservacionHabitaciones',
            'reservacionPaxes',
            'reservacionVuelos',
            'objExcursion',
            'promocionExcursion',
            'excursiones',
            'parentescos',
            'formasPago',
        ));
    }

    public function update(Request $request, $idReservacion)
    {
        // echo "<pre>";
        // var_dump($request->all());
        // echo "</pre>";
        // die;
        $reservacion = ExcursionReservacion::find($idReservacion);

        $formReserva = $request->all();

        if (($request->has("fecha-personalizada")) && ($request->input("fecha-personalizada") === 1)) {
            $formReserva["id_fecha"]     = 0;
            $formReserva["fecha_inicio"] = $request->input("fecha_inicio")  ?? "0001-01-01";
            $formReserva["fecha_fin"]    = $request->input("fecha_fin")     ?? "0001-01-01";
        } else {
            $formReserva["id_fecha"]     = $request->input("id_fecha")      ?? 0;
            $formReserva["fecha_inicio"] = "0001-01-01";
            $formReserva["fecha_fin"]    = "0001-01-01";
        }

        $formReserva["id_afiliado"]  = $request->input("id_afiliado") ?? 0;
        
        $formReserva["hoteleria"]    = (
            ($request->has("hoteleria"))
            && ($request->input("hoteleria") == 1)
        )
        ? 1
        : 0;

        $formReserva["vuelos"]       = (
            ($request->has("vuelos"))
            && ($request->input("vuelos") == 1)
        ) 
        ? 1
        : 0;

        $formReserva["cantidad_adultos"]    = $request->has("adulto-nombre") ? 1 + count($request->input("adulto-nombre")) : 1;
        $formReserva["cantidad_menores"]    = (
            ($request->has("menores"))
            && ($request->input("menores") == 1)
            && ($request->has("menor-nombre"))
        )
        ? count($request->input("menor-nombre"))
        : 0;
        
        $formReserva["cantidad_infantes"]    = (
            ($request->has("infantes"))
            && ($request->input("infantes") == 1)
            && ($request->has("infante-nombre"))
        )
        ? count($request->input("infante-nombre"))
        : 0;

        $reservacion->update($formReserva);

        return redirect()->route('reservacion-excursiones.index')->with('message', "La reserva con folio $idReservacion se ha actualizado correctamente");
    }

    public function storeReservacionPrecios(Request $request, $idReservacion)
    {
        // Formulario de precios
        $formPrecios = [];
        
        $formPrecios["id_excursion_reservacion"]    = $idReservacion;
        $formPrecios['adulto_sencilla']             = $request->input('adulto_sencilla')    ?? 0;
        $formPrecios['adulto_doble']                = $request->input('adulto_doble')       ?? 0;
        $formPrecios['adulto_triple']               = $request->input('adulto_triple')      ?? 0;
        $formPrecios['adulto_cuadruple']            = $request->input('adulto_cuadruple')   ?? 0;
        $formPrecios['menor_sencilla']              = $request->input('menor_sencilla')     ?? 0;
        $formPrecios['menor_doble']                 = $request->input('menor_doble')        ?? 0;
        $formPrecios['menor_triple']                = $request->input('menor_triple')       ?? 0;
        $formPrecios['menor_cuadruple']             = $request->input('menor_cuadruple')    ?? 0;
        $formPrecios['infante_sencilla']            = $request->input('infante_sencilla')   ?? 0;
        $formPrecios['infante_doble']               = $request->input('infante_doble')      ?? 0;
        $formPrecios['infante_triple']              = $request->input('infante_triple')     ?? 0;
        $formPrecios['infante_cuadruple']           = $request->input('infante_cuadruple')  ?? 0;

        ExcursionReservacionCosto::create($formPrecios);
    }

    public function storeReservacionHabitaciones(Request $request, $idReservacion)
    {
        for ($i = 0, $l = count($request->input("habitacion-tipo")); $i < $l; $i++) {
            $formHabitacion = [];

            $idHabitacion = $request->input("habitacion-id")[$i];
            $formHabitacion["id_excursion_reservacion"] = $idReservacion;

            $formHabitacion["hotel"]            = $request->input("hotel-nombre");
            $formHabitacion["tipo_habitacion"]  = $request->input("habitacion-tipo")[$i];
            $formHabitacion["no_reservacion"]   = $request->input("habitacion-no-reserva")[$i];
            $formHabitacion["titular"]          = $request->input("habitacion-titular")[$i];

            $habitacionCantidadAdultos = count($request->input("habitacion-$idHabitacion-adulto-nombre") ?? []);
            $habitacionCantidadMenores = $request->has("menores") ?
                count($request->input("habitacion-$idHabitacion-menor-nombre") ?? [])
                : 0;
            $habitacionCantidadInfantes = $request->has("infantes") ?
                count($request->input("habitacion-$idHabitacion-infante-nombre") ?? [])
                : 0;

            if ($request->has("habitacion-$idHabitacion-is-client")) {
                $formHabitacion["paxes"] = $habitacionCantidadAdultos + $habitacionCantidadMenores + $habitacionCantidadInfantes + 1;
            } else {                          
                $formHabitacion["paxes"] = $habitacionCantidadAdultos + $habitacionCantidadMenores + $habitacionCantidadInfantes;
            }
            
            $formHabitacion["observaciones"] = $request->input("habitacion-observaciones")[$i] ?? "";

            $reservacionHabitacion = ExcursionReservacionHabitacion::create($formHabitacion);

            $this->storeReservacionPaxes($request, $idReservacion, $idHabitacion, $reservacionHabitacion->id);

            if ($request->has("habitacion-$idHabitacion-is-client")) {
                $paxClient = ExcursionReservacionPax::where("id_excursion_reservacion", "=", $idReservacion)
                    ->where(DB::raw('CONCAT_WS(" ", nombre, apellido)'), "=", $request->input("habitacion-$idHabitacion-client-full-name"))
                    ->select()
                    ->first();

                $paxClient->id_excursion_reservacion_habitacion = $reservacionHabitacion->id;
                $paxClient->save();
            }
        }
    }

    public function storeReservacionCliente(Request $request, $idReservacion)
    {
        $cliente = Cliente::find($request->input("id_cliente"));

        $formCliente = [];
    
        $formCliente["id_excursion_reservacion"] = $idReservacion;

        $formCliente["nombre"]                                = $cliente->nombre;
        $formCliente["apellido"]                              = $cliente->apellido;
        $formCliente["id_parentesco"]                         = 0;
        $formCliente["fecha_nacimiento"]                      = "0001-01-01";
        $formCliente["adulto"]                                = 1;
        $formCliente["menor"]                                 = 0;
        $formCliente["infante"]                               = 0;
        $formCliente["id_excursion_reservacion_habitacion"]   = 0;

        // Se guarda la identificación del cliente la cual debe ser obligatoria en el formulario para agregar una nueva reserva,
        // pero en caso de ser un proceso automatizado (E.g. Compra online) puede que no se le pida por lo tanto será un string vació
        if ($request->hasFile("identificacion")) {
            $idExcursion = $request->input("id_excursion");

            $extension = $request->file("identificacion")->extension();
            $nombreBase = Str::random(10) . "-" . time();
            $nombreIdentificacion = $nombreBase . ".$extension";

            $path = $request->file("identificacion")->storeAs(
                "empresas/" . Auth::user()->id_empresa . "/excursiones/$idExcursion/reservaciones",
                $nombreIdentificacion,
                'public'
            );

            $formCliente["identificacion"] = $path;
        } else {
            $formCliente["identificacion"] = "";
        }

        $cliente = ExcursionReservacionPax::create($formCliente);

        // Ahora se guarda la información de los vuelos del cliente titular de la reserva (Si aplica)
        if (($request->has("vuelos")) && ($request->input("vuelos") == 1)) {
            $this->storeReservacionPaxVuelos($request, $idReservacion, $cliente->id);
        }
    }

    public function storeReservacionPaxes(Request $request, $idReservacion, $idHabitacion = 0, $idReservacionHabitacion = 0)
    {
        $prefixPaxes = [];

        if ($idHabitacion !== 0) {
            $prefixPaxes[] = "habitacion-$idHabitacion-adulto";

            if (($request->has("menores"))  && ($request->input("menores") == 1))   { $prefixPaxes[] = "habitacion-$idHabitacion-menor";    }
            if (($request->has("infantes")) && ($request->input("infantes") == 1))  { $prefixPaxes[] = "habitacion-$idHabitacion-infante";  }
        } else {
            $prefixPaxes[] = "adulto";
        
            if (($request->has("menores"))  && ($request->input("menores") == 1))   { $prefixPaxes[] = "menor";     }
            if (($request->has("infantes")) && ($request->input("infantes") == 1))  { $prefixPaxes[] = "infante";   }
        }

        foreach ($prefixPaxes as $prefix) {
            if ($request->has("$prefix-nombre")) {
                for ($i = 0, $l = count($request->input("$prefix-nombre")); $i < $l; $i++) {
                    $formPaxes = [];
    
                    $formPaxes["nombre"]            = $request->input("$prefix-nombre")[$i];
                    $formPaxes["apellido"]          = $request->input("$prefix-apellido")[$i];
                    $formPaxes["id_parentesco"]     = $request->input("$prefix-parentesco")[$i];
                    $formPaxes["fecha_nacimiento"]  = $request->input("$prefix-fecha-nacimiento")[$i];
                    $formPaxes["adulto"]            = (str_contains($prefix, "adulto"))    ? 1 : 0;
                    $formPaxes["menor"]             = (str_contains($prefix, "menor"))     ? 1 : 0;
                    $formPaxes["infante"]           = (str_contains($prefix, "infante"))   ? 1 : 0;
                    $formPaxes["identificacion"]    = "";
                    
                    $formPaxes["id_excursion_reservacion"] = $idReservacion;
                    $formPaxes["id_excursion_reservacion_habitacion"] = $idReservacionHabitacion;
    
                    $pax = ExcursionReservacionPax::create($formPaxes);

                    if (($request->has("vuelos")) && ($request->input("vuelos") == 1)) {
                        $this->storeReservacionPaxVuelos($request, $idReservacion, $pax->id, $prefix, $i);
                    }
                }
            } 
        }
    }

    public function storeReservacionPaxVuelos(Request $request, $idReservacion, $paxId, $prefix = "cliente", $index = 0)
    {
        //Info de vuelo de llegada    
        $formVueloLlegada = [];
    
        $formVueloLlegada["id_excursion_reservacion"] = $idReservacion;
        $formVueloLlegada["id_excursion_reservacion_pax"] = $paxId;
        $formVueloLlegada["llegada"] = 1;
        $formVueloLlegada["regreso"] = 0;
        $formVueloLlegada["lugar_origen"] = $request->input("$prefix-vuelo-llegada-ciudad-origen")[$index];
        $formVueloLlegada["lugar_destino"] = $request->input("$prefix-vuelo-llegada-ciudad-destino")[$index];
        $formVueloLlegada["id_aerolinea"] = $request->input("$prefix-vuelo-llegada-id-aerolinea")[$index];
        $formVueloLlegada["no_vuelo"] = $request->input("$prefix-vuelo-llegada-no-vuelo")[$index];
        $formVueloLlegada["fecha_y_hora"] = str_replace("T", " ", $request->input("$prefix-vuelo-llegada-fecha-y-hora")[$index]);
        $formVueloLlegada["precio"] = $request->input("$prefix-vuelo-llegada-precio")[$index] ?? 0;    
        
        ExcursionReservacionVuelo::create($formVueloLlegada);

        //Info de vuelo de regreso
        $formVueloRegreso = [];

        $formVueloRegreso["id_excursion_reservacion"] = $idReservacion;
        $formVueloRegreso["id_excursion_reservacion_pax"] = $paxId;
        $formVueloRegreso["llegada"] = 0;
        $formVueloRegreso["regreso"] = 1;
        $formVueloRegreso["lugar_origen"] = $request->input("$prefix-vuelo-regreso-ciudad-origen")[$index];
        $formVueloRegreso["lugar_destino"] = $request->input("$prefix-vuelo-regreso-ciudad-destino")[$index];
        $formVueloRegreso["id_aerolinea"] = $request->input("$prefix-vuelo-regreso-id-aerolinea")[$index];
        $formVueloRegreso["no_vuelo"] = $request->input("$prefix-vuelo-regreso-no-vuelo")[$index];
        $formVueloRegreso["fecha_y_hora"] = str_replace("T", " ", $request->input("$prefix-vuelo-regreso-fecha-y-hora")[$index]);
        $formVueloRegreso["precio"] = $request->input("$prefix-vuelo-regreso-precio")[$index] ?? 0;

        ExcursionReservacionVuelo::create($formVueloRegreso);
    }

    public function getInfoExcursion($reservacion)
    {
        $reservacionExcursionTemporadas = ExcursionTemporadaCosto::leftJoin('temporadas', 'excursiones_temporadas_costos.id_temporada', '=', 'temporadas.id')
            ->leftJoin('clases_servicios', 'excursiones_temporadas_costos.id_clase_servicio', '=', 'clases_servicios.id')
            ->where('excursiones_temporadas_costos.id_excursion', '=', $reservacion->id_excursion)
            ->select([
                'excursiones_temporadas_costos.id_temporada as temporada_id',
                'temporadas.nombre as temporada_nombre',
                DB::raw('GROUP_CONCAT(excursiones_temporadas_costos.id_clase_servicio) as clase_servicio_id'),
                DB::raw('GROUP_CONCAT(clases_servicios.nombre) as clase_servicio_nombre')
            ])
            ->groupBy('excursiones_temporadas_costos.id_temporada')
            ->get();

        $reservacionExcursionTemporadasArr = $reservacionExcursionTemporadas->toArray();
        $searchId = array_search($reservacion->excursion_fecha_temporada_id, array_column($reservacionExcursionTemporadasArr, "temporada_id"));
        $reservacionExcursionTemporadasClases = [];
        $reservacionExcursionTemporadasClases["id"] = explode(",", $reservacionExcursionTemporadasArr[$searchId]["clase_servicio_id"]);
        $reservacionExcursionTemporadasClases["nombre"] = explode(",", $reservacionExcursionTemporadasArr[$searchId]["clase_servicio_nombre"]);

        $reservacionExcursionFechas = ExcursionFecha::leftJoin("excursiones_temporadas_costos", "excursiones_fechas.id_temporada_costo", "=", "excursiones_temporadas_costos.id")
            ->leftJoin("temporadas", "excursiones_temporadas_costos.id_temporada", "=", "temporadas.id")
            ->leftJoin("clases_servicios", "excursiones_temporadas_costos.id_clase_servicio", "=", "clases_servicios.id")
            ->where("excursiones_temporadas_costos.id_excursion", "=", $reservacion->id_excursion)
            ->whereIn("temporadas.id", [$reservacion->excursion_fecha_temporada_id])
            ->whereIn("clases_servicios.id", [$reservacion->excursion_fecha_clase_id])
            ->where("excursiones_fechas.fecha_inicio", ">=", date("Y-m-d"))
            ->orWhere('excursiones_fechas.id', '=', $reservacion->id_fecha)
            ->select("excursiones_fechas.*")
            ->get();

        return [$reservacionExcursionTemporadas, $reservacionExcursionTemporadasClases, $reservacionExcursionFechas];
    }
}
