<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>ThatzWeather</title>
</head>
<body>
    <?php
    // Comprobamos si se envían datos
    if(empty($_GET) || $_GET["cp"]==""){
        header("Location: /");
        exit();
    }
    use App\Models\Top5Climas;
    // Variables para la conexión de la base de datos y la API
    $TopClima = Top5Climas::orderBy('temp', 'ASC')->get();
    $cp =e($_GET["cp"]);
    $apiKey='1c227a86c4d15a26fe3c467899055618';
    $data="https://api.openweathermap.org/data/2.5/forecast?q=$cp&appid=$apiKey&units=metric&lang=es";
    $climaDato=json_decode(file_get_contents($data),true);
    // Datos de hoy
    $climaAhora = $climaDato['list'][0];
    $climaAhoraIcon = strtolower($climaAhora["weather"][0]["main"]).".svg";
    // Esta función  muestra los datos del clima de las próximas horas
    function CalcularClima($climaDato){
        $first = true;
        for ($i=0; $i < 4; $i++) { 
            echo"<div class='horasCol'>";
                if ($first) {
                    echo "<p class='datosHoraText'>hoy</p>";
                    $first = false;
                }else{
                    echo "<p class='datosHoraText'>".substr($climaDato['list'][$i]["dt_txt"],10,6)."</p>";
                }
                $horaIcon = strtolower($climaDato['list'][$i]["weather"]["0"]["main"]).".svg";
                echo'<img class ="datosHoraIcon" src='.asset("img/icons/clima/$horaIcon").' alt="">';
                echo "<p class='datosHoraText'>".ucfirst($climaDato['list'][$i]["weather"]["0"]["description"])."</p>";
                if($climaDato['list'][$i]["weather"]["0"]["description"] == 'cielo claro' ){
                    echo"<div class='divStrCorta'></div>";
                }
                echo "<p class='datosHoraTemp'>".round($climaDato['list'][$i]["main"]["temp"])."º</p>";
            echo"</div>";
        }
    }
    // Esta función es necesaria para traducir las fechas que devuelve la API en dia de la semana
    function traducirDia($fecha){
        $fecha = date('l', strtotime(substr($fecha,0,10))); 
        switch ($fecha) {
            case 'Monday':
                return 'Lunes';
                break;
            case 'Tuesday':
                return 'Martes';
                break;
            case 'Wednesday':
                return 'Miércoles';
                break;
            case 'Thursday':
                return 'Jueves';
                break;
            case 'Friday':
                return 'Viernes';
                break;
            case 'Saturday':
                return 'Sábado';
                break;   
            case 'Sunday':
                return 'Domingo';
                break;                      
            default:

                break;
        }
    }
    // Esta función muestra los datos de los proximos dias
    function calcularDias($climaDato,$cp,$ciudadNom){
        $fechaHoy= substr($climaDato['list'][0]["dt_txt"],0,10);
        $date = "";
        echo"<div class='row'>";
            foreach($climaDato['list'] as $day) {
                if($date != substr($day["dt_txt"],0,10) && $fechaHoy != substr($day["dt_txt"],0,10)){
                    echo'<div class="column5 top5Row">';
                        $date = substr($day["dt_txt"],0,10);
                        echo "<p class='datosHoraText'>".traducirDia($day['dt_txt'])."</p>";
                        foreach($day["weather"] as $clima){
                            $climaImg = strtolower($clima["main"]).".svg";
                            echo'<img class ="datos5diasIcon" src='.asset("img/icons/clima/$climaImg").' alt="">';
                            echo '<p class="datosHoraText">'.ucfirst($clima['description'])." </p>";
                            if(strlen($clima['description']) < 6 ){
                                echo"<div class='divStrCorta'></div>";
                            }
                        }
                        echo '<p class="datosHoraTemp">'. round($day["main"]["temp"])."º </p>";
                        // Array con los datos que subiremos a la BD
                        $input = ['temp' => round($day["main"]["temp"]),'cp' => $cp,'ciudad' => $ciudadNom];
                        // Subimos los datos a la BD
                        Top5Climas::create($input);
                    echo"</div>";
                }
            }
        echo'</div>';
    }
    $date = "";
    $ciudadNom = $climaDato["city"]["name"];
    // Array con los datos que subiremos a la BD
    $input = ['temp' => round($climaAhora["main"]["temp"]),'cp' => $cp,'ciudad' => $ciudadNom];
    // Subimos los datos a la BD
    Top5Climas::create($input);
    ?>
    <img src="{{ asset('img/home/logo.png') }}" class="centerImg" id="logoDatos">
    <p class="centerText" id="txtLogo">¡Que la lluvia no te pare!</p>
    <div class="row">
        <!-- Recuadro principa con los datos del CP indicado -->
        <div class="column-main recuadros1">
            <div class="row mainInfoRow">
                <div class="column2 colum2-60">
                    <!-- Datos generales de la ciudad -->
                    <p class="ciudadInfo">Código postal: <b>{{$cp}}</b></p>
                    <p class="ciudadInfo">Ciudad: <b>{{$ciudadNom}}</b></p>
                </div>
                <div class="column2 colum2-40">
                    <!-- Buscador -->
                    <form action=/data method="get" class="FormResultado" onsubmit="return validarHome()">
                        <button type="submit" class="btnBuscar"><img src="{{ asset('img/home/searchIcon.png') }}" id="searchIcon"></button>
                        <input type="number" name="cp" id="homeInput" class="buscadorDatos" placeholder="Buscar otra zona">
                        <span class="errorSearch" id="errorText">¡El código postal indicado no es correcto!</span>
                    </form>
                </div>
            </div>
            <!-- Información del clima -->
            <div class="row heightRow">
                <div class="vl vlPos1 movilHidden">
                </div>
                <div class="vl vlPos2 movilHidden"></div>
                <div class="mainClimaCol">
                    <!-- Datos de hoy -->
                    <p class="centerText tituloSec">Ahora</p>
                    <div class="row">
                        <div class="hoyCol">
                            <img class ="iconHoy" src='{{ asset("img/icons/clima/$climaAhoraIcon") }}' alt=''>
                        </div>
                        <div class="hoyCol">
                            <p class="descHoy">{{ucfirst($climaAhora["weather"][0]["description"])}}</p>
                            <p class="tempHoy">{{round($climaAhora["main"]["temp"])}}º</p>
                        </div>
                    </div>
                </div>
                <div class="hoyClimaCol">
                    <!-- Datos de las proximas horas -->
                    <hr class='lVertical deskHidden'>
                    <p class="centerText tituloSec">Próximas horas</p>
                    <div class="row">
                        <div class="vl vlPosHoras1"></div>
                        <div class="vl vlPosHoras2"></div>
                        <div class="vl vlPosHoras3"></div>
                        <?php CalcularClima($climaDato);?>
                    </div>
                    <hr class='lVertical deskHidden'>
                </div>
                <div class="nextClimaCol">
                    <!-- Datos de los proximos 5 dias -->
                    <p class="centerText tituloSec">Próximos 5 días</p>
                    {{calcularDias($climaDato,$cp,$ciudadNom);}}
                    <div class="vlNext vlPosHoras4 deskHidden"></div>
                    <div class="vlNext vlPosHoras5 deskHidden"></div>
                    <div class="vlNext vlPosHoras6 deskHidden"></div>
                    <div class="vlNext vlPosHoras7 deskHidden"></div>
                </div>
            </div>
        </div>
        <div class="column-top5 recuadros2">
            <!-- Top5 -->
            <h1 class="top5Titulo">Top 5 de las zonas más frías según tus búsquedas</h1>
            <?php
                    for ($i=0; $i < 5; $i++) { 
                        echo'<div class="row">';
                            $ciudad = $TopClima->pluck('ciudad')[$i];
                            $temp = $TopClima->pluck('temp')[$i];
                            $codCP= $TopClima->pluck('cp')[$i];
                            $topPos = $i;
                            $topPos++;
                            echo'<div class="columnTop1">';
                                echo "<p class='top5Pos'>".$topPos.". </p>";
                            echo"</div>";
                            echo'<div class="columnTop2">';
                                if ($temp == "99") {
                                    echo "<p class='top5Temp'>--</p>";
                                }else{
                                    echo "<p class='top5Temp'>".$temp."º</p>";
                                }
                            echo"</div>";
                            echo'<div class="columnTop3">';
                                echo "<p class='ciudadInfoTop5'>CP: <b>".$codCP."</b></p>";
                                echo "<p class='ciudadInfoTop5'>Ciudad: <b>".$ciudad."</b></p>";
                            echo"</div>
                        </div>";
                        if($i!=4){
                            echo"<hr class='lVertical'>";
                        }
                    }
                ?>
        </div>
    </div>
    <!-- Validación JavaScript del buscador -->
    <script src="js/home.js"></script>
</body>
</html>