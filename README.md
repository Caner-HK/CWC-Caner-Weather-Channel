# CWC-Caner-Weather-Channel
   <img style="height: 42px;" src="https://resource.caner.hk/get/logo/caner-logo-white.png">
Caner Weather Channel (CWC) is a weather website and application designed and developed by Caner HK. You can visit cwc on https://weather.caner.hk/

>Please read LICENSE before using release and pre-release files

## CWC Overview
__Core logic:__

1. Request the PHP file of the API key, request the function file.

   `example: require './path/to/apikey.php';
    include './path/to/functions.php';`
2. then use [ipinfo.io](https://ipinfo.io/) to obtain the user IP through the back-end PHP code, use [Google Maps Platform](https://mapsplatform.google.com/) to convert the IP into latitude and longitude.
  
   `example:
   function getLocationByIP() {
        $ip = $_SERVER['REMOTE_ADDR'];
        $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
        return $details->city;
    }`
 
   (_After the dom is loaded, the longitude and latitude are obtained through JavaScript location information. If agreed, the location information obtained by JavaScript will be changed to re-request._
        `example: var currentLocation = window.location.search;
        if (!currentLocation.includes("location=")) {
            if (navigator.geolocation) {
                var options = {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                };
                navigator.geolocation.getCurrentPosition(showPosition, showError, options);
            }
        }
    };`)
 
3. Then confirm the request by judging the JSON data in the cookies  unit & language ,etc.
4. Then build the request URL (using curl_request) and store the requested data in various variables.

   `example: $TheUrlOfGetWeatherJson = "https://api.example.com/wearher/3.0/get?lat=40.4573&lon=-0.3425&lang=en&apikey=123456789&units=imperial";`
6.After requesting the data, you can add an if isset to confirm whether the weather data has been obtained and prepare error information for the error page.
7. Then determine the description text of various weather conditions through functions.Here you can convert the returned weather data into more understandable text to help users read.
8. Through `<?php echo ?>` in html.  Show corresponding weather data.Also you need write some css classes and make some components to beautify the page.

__The above describes how to obtain weather data and how to display weather data, which is the core logic of CWC (the displayed code is modified from the source code).__

__html&css:__

We use flat and minimalist styles to design the front-end style. Right-angled borders, solid borders, window transition animations and press-and-hold transition animations are all features of CWC.

`example: .cwc-btn {
      border-radius: 0px !important;
      border: 1px solid black;
      height: 36px;
      width: 297px;
      font-size: 14px;
      transition: background-color 0.3s, border-color 0.3s;
      background-color: transparent;
      color: black;
      display: flex;
      align-items: center;
      justify-content: center;
      box-sizing: border-box;
      margin-bottom: 5px;
    }
    .cwc-btn:hover {
      background-color: black;
      color: white;
    }`
    
`example:<iframe id="gameFrame" src="https://resource.caner.hk/get/game/dino/dino_with_title.html" height="200px" frameborder="0" scrolling="no" allowfullscreen class="cwc-game"></iframe>
        <button id="gameButton" class="cwc-btn">玩 Chrome Dino 消遣一下</button>`

__screenshot:__
![Screenshot_20240203-041737_Caner_Weather](https://github.com/iMallpa/CWC-Caner-Weather-Channel/assets/104821296/bea0e167-b817-49bb-8bec-9bc9726cbb32)


## Function:
- [x] Weather query and display
- [x] Location search suggestions
- [x] Google Maps and Map pin 📍
- [x] Weather data chart
- [x] Set units and save units
- [x] Cookies management
- [x] Diverse data display
- [x] Error handling function
- [ ] multi-language
- [ ] Recommendations provided by GPT3.5
- [ ] star city
- [ ] Personal information display
- [ ] Large screen adaptation
- [ ] Switch map service provider
- [ ] Dt and historical weather
- [ ] snackbar operation suggestions





