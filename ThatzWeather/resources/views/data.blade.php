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
    // echo "<p>Ciudad: $ciudadNom</p>";
    // echo "<p>Código postal: $cp</p>";
    ?>
    <img src="{{ asset('img/home/logo.png') }}" class="centerImg" id="logo">
    <p class="centerText" id="txtLogo">¡Que la lluvia no te pare!</p>
    <div class="row">
        <div class="column-main recuadros">
            <p>Código postal: <b>{{$cp}}</b></p>
            <p>Ciudad: <b>{{$ciudadNom}}</b></p>
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