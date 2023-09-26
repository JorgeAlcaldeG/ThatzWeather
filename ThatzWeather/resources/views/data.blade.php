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
    $cp =e($_GET["cp"]);
    $apiKey='1c227a86c4d15a26fe3c467899055618';
    $data="https://api.openweathermap.org/data/2.5/forecast?q=$cp&appid=$apiKey&units=metric&lang=es";
    $climaDato=json_decode(file_get_contents($data),true);
    // var_dump($climaDato);
    $climaAhora = $climaDato['list'][0];
    $climaAhoraIcon = strtolower($climaAhora["weather"][0]["main"]).".svg";
    function CalcularClima($climaDato){
        $first = true;
        for ($i=0; $i < 4; $i++) { 
            echo"<div class='horasCol'>";
                if ($first) {
                    echo "<p class='datosHoraText'>hoy</p>";
                    $first = false;
                }else{
                    echo "<p class='datosHoraText'>".substr($climaDato['list'][$i]["dt_txt"],10,6)."</p>";
                    // echo substr($climaDato['list'][$i]["dt_txt"],10,6);
                }
                $horaIcon = strtolower($climaDato['list'][$i]["weather"]["0"]["main"]).".svg";
                echo'<img class ="datosHoraIcon" src='.asset("img/icons/clima/$horaIcon").' alt="">';
                // echo strtolower($climaDato['list'][$i]["weather"]["0"]["main"]);
                switch ($climaDato['list'][$i]["weather"]["0"]["description"]) {
                    case 'algo de nubes':
                        echo "<p class='datosHoraText'>Nubes</p>";
                        break;
                    
                    default:
                        echo "<p class='datosHoraText'>".ucfirst($climaDato['list'][$i]["weather"]["0"]["description"])."</p>";
                        break;
                }
                echo "<p class='datosHoraTemp'>".round($climaDato['list'][$i]["main"]["temp"])."º</p>";
            echo"</div>";
        }
    }
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
    function calcularDias($climaDato){
        $fechaHoy= substr($climaDato['list'][0]["dt_txt"],0,10);
        $date = "";
        echo"<div class='row'>";
            foreach($climaDato['list'] as $day) {
                if($date != substr($day["dt_txt"],0,10) && $fechaHoy != substr($day["dt_txt"],0,10)){
                    echo'<div class="column5 top5Row">';
                        $date = substr($day["dt_txt"],0,10);
                        echo "<p class='datosHoraText'>".traducirDia($day['dt_txt'])."</p>";
                        // echo date('l', strtotime(substr($day["dt_txt"],0,10)));
                        // echo "</br>";
                        foreach($day["weather"] as $clima){
                            $climaImg = strtolower($clima["main"]).".svg";
                            echo'<img class ="datos5diasIcon" src='.asset("img/icons/clima/$climaImg").' alt="">';
                            echo '<p class="datosHoraText">'.$clima['description']." </p>";
                            if(strlen($clima['description']) < 6 ){
                                echo"<div class='divStrCorta'></div>";
                            }
                        }
                        echo '<p class="datosHoraTemp">'. round($day["main"]["temp"])."º </p>";
                    echo"</div>";
                }
            }
        echo'</div>';
    }
    // calcularDias($climaDato);
    $date = "";
    $ciudadNom = $climaDato["city"]["name"];
    ?>
    <img src="{{ asset('img/home/logo.png') }}" class="centerImg" id="logo">
    <p class="centerText" id="txtLogo">¡Que la lluvia no te pare!</p>
    <div class="row">
        <div class="column-main recuadros">
            <div class="row mainInfoRow">
                <div class="column2 colum2-60">
                    <p class="ciudadInfo">Código postal: <b>{{$cp}}</b></p>
                    <p class="ciudadInfo">Ciudad: <b>{{$ciudadNom}}</b></p>
                </div>
                <div class="column2 colum2-40">
                    <form action=/data method="get" class="FormResultado" onsubmit="return validarHome()">
                        <button type="submit" class="btnBuscar"><img src="{{ asset('img/home/searchIcon.png') }}" id="searchIcon"></button>
                        <input type="number" name="cp" id="homeInput" class="buscadorDatos" placeholder="Buscar otra zona">
                        <span class="errorSearch" id="errorText">¡El código postal indicado no es correcto!</span>
                    </form>
                </div>
            </div>
            <!-- Información del clima -->
            <div class="row heightRow">
                <div class="vl vlPos1">
                </div>
                <div class="vl vlPos2"></div>
                <div class="mainClimaCol">
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
                    <p class="centerText tituloSec">Próximas horas</p>
                    <div class="row">
                        <div class="vl vlPosHoras1"></div>
                        <div class="vl vlPosHoras2"></div>
                        <div class="vl vlPosHoras3"></div>
                        <?php CalcularClima($climaDato);?>
                    </div>
                </div>
                <div class="nextClimaCol">
                    <p class="centerText tituloSec">Próximos 5 días</p>
                    {{calcularDias($climaDato);}}
                </div>
            </div>
        </div>
        <div class="column-top5 recuadros">
            <h1 class="top5Titulo">Top 5 de las zonas más frías según tus búsquedas</h1>
            <hr class="lVertical">
        </div>
    </div>
    <script src="js/home.js"></script>
</body>
</html>