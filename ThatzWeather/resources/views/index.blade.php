<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>ThatzWeather</title>
</head>
<body>
    <img src="{{ asset('img/home/logo.png') }}" class="centerImg" id="logo">
    <p id="homeText" class="centerText">Entérate del tiempo en la zona exacta que te interesa buscando por código postal.</p>
    <form action="/data" method="get" class="center" onsubmit="return validarHome()">
        <input type="number" name="cp" id="homeInput" class="center homeInput" placeholder="Introduce el código postal">
        <p class="centerText" id="errorText">¡El código postal indicado no es correcto!</p>
        <button type="submit" class="center" id="homeButton">Buscar <img src="{{ asset('img/home/searchIcon.png') }}" id="searchIcon"></button>
    </form>
    <p class="centerText" id="bottomText">¡Que la lluvia no te pare!</p>
    <script src="js/home.js"></script>
</body>
</html>