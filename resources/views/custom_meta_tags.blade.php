@section('meta_tags')
    @php
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $servidor = "https://" . $_SERVER["SERVER_NAME"];
        } else {
            //Primero obtenemos el host y el puerto (Si existe)
            $serverName = $_SERVER["SERVER_NAME"] ?? "localhost";
            $serverPort = $_SERVER["SERVER_PORT"] ?? "";
            $httpHost = ($serverPort !== "") ? "$serverName:$serverPort" : "$serverName";

            // Ahora obtenemos el nombre de la carpeta que estamos usando en nuestra PC
            $scriptName = ($_SERVER["SCRIPT_NAME"][0] === '/') ? substr($_SERVER["SCRIPT_NAME"], 1) : $_SERVER["SCRIPT_NAME"];
            $scriptName = explode("/", $scriptName);
                        
            $nombreCarpeta = $scriptName[0];

            $servidor = "http://$httpHost/$nombreCarpeta/";
            $servidor = "http://$httpHost/";
        }
    @endphp

    <base href="{{$servidor}}">

    {{-- Se incluye como primer script el JS personalizado --}}
    <script src="{{ asset('/assets/js/funciones.js') }}"></script>
@stop