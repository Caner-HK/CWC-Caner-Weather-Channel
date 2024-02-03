<?php
//Hint 
//Enter your API key before using
//get Google Maps api key on https://console.cloud.google.com/google/maps-apis/start
//Generate jwt before use
//online demo on https://weather.caner.hk/research/awk/v1
//© Caner HK 2024 - All Rights Reserved.
function getCoordinates($address, $apiKey) {
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($address) . "&key=" . $apiKey;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    $responseData = json_decode($response, true);
    if ($responseData['status'] == 'OK') {
        $latitude = $responseData['results'][0]['geometry']['location']['lat'];
        $longitude = $responseData['results'][0]['geometry']['location']['lng'];
        $formattedAddress = $responseData['results'][0]['formatted_address'];
        return array($latitude, $longitude, $formattedAddress);
    } else {
        return false;
    }
}

$weatherData = "";
$locationName = "";
if (isset($_GET['location'])) {
    $googleApiKey = "Google Maps API Key"; // Enter your Google Maps API key before using
    $result = getCoordinates($_GET['location'], $googleApiKey);
    if ($result) {
        list($latitude, $longitude, $locationName) = $result;

        // Use the Apple WeatherKit API
        $accessToken = "JSON WEB TOKEN"; // Enter your Apple WeatherKit access token before using
        $url = "https://weatherkit.apple.com/api/v1/weather/language/$latitude/$longitude?countryCode=example&timezone=example&dataSets=WeatherType";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer $accessToken"));
        $response = curl_exec($ch);
        curl_close($ch);

        $weatherData = json_decode($response, true);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">
    <title>CWC WeatherKit Dev</title>
    <style>
        body {
            font-family: sans-serif;
        }
        html, body {
            margin: 0;
            padding: 0;
        }
        header {
            padding-left: 10px;
        }
        main {
            margin: 10px;
        }
        hr {
            border-top: 1px;
            border-color: black;
        }
        button {
            height: 36px;
            border: 1px solid black;
            border-radius: 0px;
            background-color: white;
            color: black;
            box-sizing: border-box;
        }
        button:hover {
            background-color: black;
            color: white;
        }
        input {
            height: 36px;
            width: 200px;
            border: 1px solid black;
            border-radius: 0px !important;
            background-color: white;
            color: black;
            box-sizing: border-box;
            padding-left: 10px;
        }
        input:focus {
            outline: none;
            border: 2px solid black;
            width: 200px;
            padding-left: 9px;
        }
        ::selection {
            background-color: black;
            color: white;
        }
        .weather-day {
            border: 1px solid black;
            padding: 10px;
            margin-bottom: 10px;
        }
        .tip {
            font-size: 14px;
            margin-top: -20px;
        }
    </style>
</head>
<body>
    <header>
        <h2>CWC WeatherKit Dev</h2>
        <div class="tip">V1.0-Dev This version is used for research with the WeatherKit data provider.</div>
    </header>
    <hr>
    <main>
        
    <form method="get">
        <input type="text" name="location" placeholder="Enter a location">
        <button type="submit">Search</button>
    </form>

    <?php if (!empty($weatherData) && isset($weatherData['WeatherType']['Type'])): ?>
        <h2 style="color: red;">Happy Chinese Loong New Year !!!</h2>
        <h3>Weather Forecast</h3>
        <?php foreach ($weatherData['WeatherType']['Type'] as $day): ?>
            <div class="weather-day">
                <h4>Date: <?= date("Y-m-d", strtotime($day['forecastStart'])) ?></h4>
                <p>Condition: <?= $day['conditionCode'] ?></p>
                <p>Max Temperature: <?= $day['temperatureMax'] ?>°C</p>
                <p>Min Temperature: <?= $day['temperatureMin'] ?>°C</p>
                <p>Max Wind Speed: <?= $day['windSpeedMax'] ?> km/h</p>
                <p>Precipitation Chance: <?= $day['precipitationChance'] * 100 ?>%</p>
                <p>Sunrise: <?= date("H:i:s", strtotime($day['sunrise'])) ?></p>
                <p>Sunset: <?= date("H:i:s", strtotime($day['sunset'])) ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
    <h3>Sorry!</h3>
        <p>Unfortunately, there is no weather data available now. Please check whether you have input the location.</p>
    <?php endif; ?>
    
    <footer style="text-align: left; margin-top: 21px;">
        <p>Data provided by Weather.<br>&copy; Caner HK 2024 - All Rights  Reserved.</p>
    </footer>
    </main>
</body>
</html>
