<?php
$cp =e($_GET["cp"]);
$apiKey='1c227a86c4d15a26fe3c467899055618';
$data="https://api.openweathermap.org/data/2.5/forecast?q=barcelona&appid=$apiKey&units=metric&lang=es";
$climaDato=json_decode(file_get_contents($data),true);
// var_dump($climaDato);
$date = "";
$ciudadNom = $climaDato["city"]["name"];
echo $ciudadNom;
echo "</br>";
echo "</br>";
foreach($climaDato['list'] as $day) {
    if($date != substr($day["dt_txt"],0,10)){
        $date = substr($day["dt_txt"],0,10);
        echo($day["main"]["temp"]);
        foreach($day["weather"] as $clima){
            echo $clima["description"];  
        }
        echo "</br>";
        echo "</br>";
        echo "</br>";
        echo "</br>";
    }
  }
?>