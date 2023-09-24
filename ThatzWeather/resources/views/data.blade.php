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
                    <form action=/data method="get" class="FormResultado">
                        <button type="submit" class="btnBuscar"><img src="{{ asset('img/home/searchIcon.png') }}" id="searchIcon"></button>
                        <input type="number" name="cp" id="homeInput" class="buscadorDatos" placeholder="Buscar otra zona">
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
                </div>
                <div class="hoyClimaCol">
                    <p class="centerText tituloSec">Próximas horas</p>
                </div>
                <div class="nextClimaCol">
                    <p class="centerText tituloSec">Próximas 5 días</p>
                </div>
            </div>
        </div>
        <div class="column-top5 recuadros">
            <h1>Top 5 de las zonas más frías según tus búsquedas</h1>
        </div>
    </div>
    <?php
    // foreach($climaDato['list'] as $day) {
    //     if($date != substr($day["dt_txt"],0,10)){
    //         $date = substr($day["dt_txt"],0,10);
    //         echo($day["main"]["temp"]);
    //         foreach($day["weather"] as $clima){
    //             echo $clima["description"];  
    //         }
    //         echo "</br>";
    //         echo "</br>";
    //         echo "</br>";
    //         echo "</br>";
    //     }
    //   }
    ?>
</body>
</html>