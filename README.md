# CWC Research Branch - WeatherKit

Caner Weather Channel (CWC) is a comprehensive weather website and application developed by Caner HK. For more information and to access the service, visit [CWC](https://weather.caner.hk/).

>Please ensure you read the LICENSE document before using any release and pre-release files.

## CWC Overview:

### Core Logic:

The core functionality of CWC involves several steps to fetch and display weather data:

1. **API Key and Functions Importation:**
   Begin by including the necessary PHP files for the API key and functions.
   ```php
   require './path/to/example.php';
   include './path/to/example.php';
   ```

2. **Obtaining User Location:**
   Utilize [ipinfo.io](https://ipinfo.io/) to determine the user's IP address in the backend PHP code, and then use the [Google Maps Platform](https://mapsplatform.google.com/) to convert this IP into latitude and longitude coordinates.
   ```php
   function example() {
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
               enableHighAccuracy: example,
               timeout: example,
               maximumAge: example
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
       $cookieData = isset($_COOKIE['example']) ? json_decode($_COOKIE['example'], true) : array();
       $cookieData["units"] = $units;

       if (isset($_POST['setDefault'])) {
           $cookieExpiration = time() + (86400 * 90); // Setting cookie expiration
           $cookieData["example"] = date('Y-m-d H:i:s', $cookieExpiration);
           $jsonSettings = json_encode($cookieData);
           setcookie('example', $jsonSettings, $cookieExpiration, "/");
       }
   } else {
       if (isset($_COOKIE['example'])) {
           $cookieData = json_decode($_COOKIE['example'], true);
           $units = isset($cookieData['units']) ? $cookieData['units'] : "example";
       } else {
           $units = "example";
       }
   }
   ```

4. **Building the Request URL:**
   Construct the URL to request weather data, using various parameters such as location and units.
   ```php
   $weatherApiUrl = "https://api.example.com/weather/example/get?lat=40.4573&lon=-0.3425&lang=en&apikey=123456789&units=imperial";
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
```html
<div>
    <span class="cwc-text-small">example: </span><br><strong class="cwc-head-daily"><?php echo $example['example'] * 100; ?></strong><strong>%</strong><br>
    <?php if (isset($example['example'])): ?>
    <div><span class="cwc-subhead"><strong>example: <?php echo $example['example']; ?> mm</strong></span></div>
    <?php endif; ?>
    <span class="cwc-text-small">example: <strong><?php echo $example['example']; ?>% • <?php echo getDescription($example['example']); ?></strong></span><br>
    <span class="cwc-text-small">example: <strong><?php echo $example['example']; ?> hPa • <?php echo getDescription($example['example']); ?></strong></span><br>
</div>

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

### Frontend Design:

- **No Framework Dependency**: The frontend of CWC is purely crafted using HTML tags and CSS styling, with no dependency on any frontend frameworks, ensuring good performance on low-RAM devices and excellent compatibility.

### Backend Implementation:

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
- **AMap**: Offers map resources and services. [AMap](https://lbs.amap.com/)
- **Caner Resource**: Provides additional resources and data services. [Caner Resource](https://r.caner.hk/)

### Compatibility and Performance

CWC is specially optimized to ensure good performance and user experience on a wide range of devices, including those with low RAM. The project's design takes compatibility and accessibility into account, serving a diverse user base with varying levels of technology access and device capabilities.

Through this approach, CWC not only provides users with a feature-rich, easy-to-use weather query platform but also demonstrates how to effectively combine traditional techniques with modern services to create applications with high performance and compatibility in modern web development.


## Features:

- [x] **Weather Query and Display**
- [x] **Location Search Suggestions**
- [x] **Google Maps and Map Pin 📍**
- [x] **Weather Data Chart**
- [x] **Units Setting and Saving**
- [x] **Cookies Management**
- [x] **Diverse Data Display**
- [x] **Error Handling**

### Upcoming Features

- [ ] **Multi-language**
- [ ] **Recommendations by GPT-3.5**
- [ ] **Starred Cities**
- [ ] **Personal Information Display**
- [ ] **Large Screen Adaptation**
- [ ] **Map Service Provider Switch**
- [ ] **Dt (Unix Timestamp) Historical Weather**
- [ ] **Snackbar Suggestions**


## Usage and Guide:

CWC is continuously evolving, with new features and updates being introduced periodically. To help users navigate these changes and make the most out of the application, a comprehensive usage and feature guide is available. Please note that due to ongoing updates, the content of the guide may change over time.

For detailed instructions and the latest information on how to use CWC and its features, please visit the following link: [CWC Usage and Feature Guide](https://b23.tv/BBHX0DB).

Stay informed about the latest developments to enhance your experience with CWC.

## Changelog:

The current accessible version of CWC is Version 3.x.x . Upon the completion of this build, we will introduce a completely restructured new version (4.x
.x) of the application.

For those interested in exploring the archived historical versions of CWC, they are available on the CWC Archive page. Visit [CWC Archive](https://weather.caner.hk/archive) to access these versions.

Stay tuned for updates and improvements as we continue to develop and enhance the CWC experience.

## Developer Research

CWC offers source code specifically for developer research, which can be downloaded from the release section. 
>Note that the Developer Research source code differs from the actual CWC release page. It is designed for the purpose of developing features and researching improvements and does not include any API keys.

Download the source code from the [Release page](https://github.com/Caner-HK/CWC-Caner-Weather-Channel/releases/tag/Developer_Research).

## License Information:

CWC does not utilize any open-source licenses, such as the MIT License or Apache License 2.0. Instead, it operates under a proprietary license issued by Caner HK, specifically designed for the CWC project. You can view the license here: [CWC License](https://github.com/iMallpa/CWC-Caner-Weather-Channel/blob/main/LICENSE).

Please note that due to the stipulations of this license, there may be certain restrictions on how you can modify and distribute the CWC source code.




