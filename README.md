# Caner Weather Channel (CWC)

Caner Weather Channel (CWC) is a comprehensive weather website and application developed by Caner HK. For more information and to access the service, visit [CWC](https://weather.caner.hk/).

>Please ensure you read the LICENSE document before using any release and pre-release files.

## CWC Overview

### Core Logic:

The core functionality of CWC involves several steps to fetch and display weather data:

1. **API Key and Functions Importation:**
   Begin by including the necessary PHP files for the API key and functions.
   ```php
   require './path/to/apikey.php';
   include './path/to/functions.php';
   ```

2. **Obtaining User Location:**
   Utilize [ipinfo.io](https://ipinfo.io/) to determine the user's IP address in the backend PHP code, and then use the [Google Maps Platform](https://mapsplatform.google.com/) to convert this IP into latitude and longitude coordinates.
   ```php
   function getLocationByIP() {
       $ip = $_SERVER['REMOTE_ADDR'];
       $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));
       return $details->city;
   }
   ```
   After the DOM is loaded, longitude and latitude are obtained through JavaScript location information. If permission is granted, the location information obtained through JavaScript will update the request.
   ```javascript
   var currentLocation = window.location.search;
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
   ```

3. **Setting Preferences via Cookies:**
   Confirm user preferences such as units and language by checking the JSON data stored in cookies.
   ```php
   if (isset($_POST['units'])) {
       $units = $_POST['units'];
       $cookieData = isset($_COOKIE['CWC-Profile']) ? json_decode($_COOKIE['CWC-Profile'], true) : array();
       $cookieData["units"] = $units;

       if (isset($_POST['setDefault'])) {
           $cookieExpiration = time() + (86400 * 90); // Setting cookie expiration
           $cookieData["Expiration"] = date('Y-m-d H:i:s', $cookieExpiration);
           $jsonSettings = json_encode($cookieData);
           setcookie('CWC-Profile', $jsonSettings, $cookieExpiration, "/");
       }
   } else {
       if (isset($_COOKIE['CWC-Profile'])) {
           $cookieData = json_decode($_COOKIE['CWC-Profile'], true);
           $units = isset($cookieData['units']) ? $cookieData['units'] : "metric";
       } else {
           $units = "metric";
       }
   }
   ```

4. **Building the Request URL:**
   Construct the URL to request weather data, using various parameters such as location and units.
   ```php
   $weatherApiUrl = "https://api.example.com/weather/3.0/get?lat=40.4573&lon=-0.3425&lang=en&apikey=123456789&units=imperial";
   ```

5. **Processing Weather Data:**
   After making the request, verify the received weather data and prepare for display, including error handling and translating weather conditions into user-friendly descriptions.

6. **Displaying Weather Data:**
   Use PHP within HTML to display the weather data dynamically, styled with CSS for an appealing presentation.

### HTML & CSS Design:

CWC adopts a flat and minimalist design aesthetic, featuring right-angled borders, solid lines, and smooth transition animations for a clean and modern user interface.

```css
.cwc-btn {
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
}
```
Interactive elements such as games are also integrated for a more engaging user experience.
```html
<iframe id="gameFrame" src="https://resource.caner.hk/get/game/dino/dino_with_title.html" height="200px" frameborder="0" scrolling="no" allowfullscreen class="cwc-game"></iframe>
<button id="gameButton" class="cwc-btn">Play Chrome Dino for fun</button>
```
Control the display and closing of Game Iframe and the text switching of buttons through JavaScript code
```javascript
document.getElementById('gameButton').addEventListener('click', function() {
    var gameFrame = document.getElementById('gameFrame');
    var gameButton = document.getElementById('gameButton');

    if (gameFrame.style.maxHeight === '0px') {
        gameFrame.style.maxHeight = '200px';
        setTimeout(function() {
            gameFrame.style.opacity = '1';
        }, 500);
        gameButton.textContent = '关闭 Chrome Dino 游戏';
    } else {
        gameFrame.style.opacity = '0';
        setTimeout(function() {
            gameFrame.style.maxHeight = '0px';
        }, 500);
        gameButton.textContent = '玩 Chrome Dino 消遣一下';
    }
});
```
## Technology Stack:

CWC (Caner Weather Channel) is a comprehensive weather information application designed to provide accurate weather forecasts and information to users. The project is specially optimized to run on low-memory devices, ensuring wide accessibility and compatibility.

### Frontend Design

- **No Framework Dependency**: The frontend of CWC is purely crafted using HTML tags and CSS styling, with no dependency on any frontend frameworks, ensuring good performance on low-RAM devices and excellent compatibility.

### Backend Implementation

- **Developed with PHP**: The backend logic is implemented in PHP, including functionalities such as acquiring geographical location, IP geolocation, setting request units, sending weather data requests, timezone conversion, and translating weather conditions into language descriptions.
- **Data Processing**: The backend handles data acquisition and aggregation from multiple sources, provides search suggestions, and implements the storage and retrieval of user settings.

### Integration of Technologies and Services

CWC integrates a variety of third-party products and services to enhance its functionality and user experience:

- **Google Maps Platforms**: Used for recognizing and converting geographical locations, as well as implementing map functionalities. [Google Maps Platforms](https://mapsplatform.google.com/)
- **Google Analysis**: Employed for analyzing website traffic and user behavior to optimize the user experience. [Google Analytics](https://analytics.google.com/)
- **Open Weather**: Provides real-time weather data and forecasts. [OpenWeather](https://openweathermap.org/)
- **The Weather Company** (temporarily discontinued): Previously offered high-quality weather forecasting data.
- **ipinfo**: Utilized for obtaining geographical location information through the user's IP address. [ipinfo.io](https://ipinfo.io/)
- **Chart.js**: Generates weather data charts for intuitive data visualization. [Chart.js](https://www.chartjs.org/)
- **Amap**: Offers map resources and services. [Amap](https://lbs.amap.com/)
- **Caner Resources**: Provides additional resources and data services. [r.Caner.hk](https://r.caner.hk/)

### Compatibility and Performance

CWC is specially optimized to ensure good performance and user experience on a wide range of devices, including those with low RAM. The project's design takes compatibility and accessibility into account, serving a diverse user base with varying levels of technology access and device capabilities.

Through this approach, CWC not only provides users with a feature-rich, easy-to-use weather query platform but also demonstrates how to effectively combine traditional techniques with modern services to create applications with high performance and compatibility in modern web development.


## Features:
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





