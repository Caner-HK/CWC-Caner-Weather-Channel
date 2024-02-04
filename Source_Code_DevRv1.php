<?php
//Hint 
//Enter your API key before using
//get Google Maps api key on https://console.cloud.google.com/google/maps-apis/start
//get The Weather Company api key on https://www.wunderground.com/member/api-keys
//online demo on https://weather.caner.hk/research/v1
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
    $googleApiKey = "Your Google Maps API Key"; //Enter your Google Maps API key before using
    $result = getCoordinates($_GET['location'], $googleApiKey);
    if ($result) {
        list($latitude, $longitude, $locationName) = $result;

        $weatherApiKey = "Your Weather API Key"; //Enter your The Weather Company API key before using
        $language = "en"; // set language en
        $units = "m"; // set units metric
        $format = "json"; // set format json

        $url = "https://api.weather.com/v3/wx/forecast/daily/5day?geocode=$latitude,$longitude&format=$format&units=$units&language=$language&apiKey=$weatherApiKey";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
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
    <title>CWC Dev Research Source Code V1</title>
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
            font-size: 12px;
            margin-top: -20px;
        }
    </style>
</head>
<body>
    <header>
        <h2>Caner Weather Channel</h2>
        <div class="tip">Designed exclusively by Caner HK for developer research on GitHub.</div>
    </header>
    <hr>
    <main>
    <form method="get">
        <input type="text" name="location" placeholder="Enter a location">
        <button type="submit">Search</button>
    </form>

    <?php if ($weatherData && $locationName): ?>
        <h3>The weather for <?php echo htmlspecialchars($locationName); ?> has been quired</h3>
        <div id="weather-content">
                <?php
                foreach ($weatherData['dayOfWeek'] as $index => $day) {
                    $dayData = $weatherData['daypart'][0];
                    echo '<div class="weather-day">';
                    echo '<h3>' . $day . '</h3>';
                    echo '<h4>' . $weatherData['narrative'][$index] . '</h4>';
                    echo '<p>Max Temperature: ' . $weatherData['temperatureMax'][$index] . '°C</p>';
                    echo '<p>Min Temperature: ' . $weatherData['temperatureMin'][$index] . '°C</p>';
                    echo '<p>UV Index: ' . $dayData['uvIndex'][$index] . '</p>';
                    echo '<p>Sunset: ' . $weatherData['sunriseTimeLocal'][$index] . '</p>';
                    echo '<p>Sunrise: ' . $weatherData['sunsetTimeLocal'][$index] . '</p>';
                    echo '<p>Moon Phase: ' . $weatherData['moonPhase'][$index] . '</p>';
                    echo '<p>Wind Speed: ' . $dayData['windSpeed'][$index] . ' km/h</p>';
                    echo '<p>Wind Direction: ' . $dayData['windDirectionCardinal'][$index] . '</p>';
                    echo '<p>Humidity: ' . $dayData['relativeHumidity'][$index] . '%</p>';
                    echo '<p>Precipitation Probability: ' . $dayData['precipChance'][$index] . '%</p>';
                    echo '</div>';
                }
                ?>
        </div>
    <?php else: ?>
        <h3>No weather data found in <?php $location = isset($_GET['location']) ? htmlspecialchars($_GET['location']) : 'this area'; echo $location; ?></h3>
    <?php endif; ?>
    </main>
</body>
</html>
