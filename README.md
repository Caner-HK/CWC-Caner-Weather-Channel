# CWC Branch - WeatherKit

This branch is dedicated to integrating the Apple Weather Kit version with CWC (hereafter referred to as AWK). For access to the main version of CWC, [click here](https://github.com/Caner-HK/CWC-Caner-Weather-Channel/tree/main).

>Please read the LICENSE document before using any release or pre-release files.

## CWC AWK Overview:

This version distinguishes itself from the main version by utilizing the **Apple Weather Kit Rest API** for weather data retrieval, whereas the main version employs **Open Weather**.

### Core Logic:

To use WeatherKit, you must have an Apple developer account and generate your JWT (JSON Web Token) according to Apple's developer documentation.

1. **Geolocation Conversion**: After configuring the Google Maps API and your JWT, enter the desired location on the page. The backend PHP code will convert this into latitude and longitude coordinates.

    ```php
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
    ```
2. **Request weather data**: Build the request URL from the obtained latitude and longitude.
   ```php
   $url = "https://weatherkit.apple.com/api/v1/weather/example/$latitude/$longitude?countryCode=example&timezone=example&dataSets=example";
   ```
3. **Request Data**: The script initializes a cURL session to send a HTTP request to the specified URL with an Authorization header. After executing the request, it closes the session and decodes the JSON response into a PHP array.

   ```php
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Bearer $JWT"));
   $response = curl_exec($ch);
   curl_close($ch);

   $weatherData = json_decode($response, true);
   ```
4. **Display weather data**: Iterate through data via php foreach.Display data via php echo.
   ```php
   <?php foreach ($weatherData['example']['example'] as $example): ?>
   #######
   <?php echo $day['example'] ?>
   #######
   <?php endforeach; ?>
   ```

## Features:

- [x] **Weather Query and Display**: Utilize WeatherKit for accurate weather information.
- [x] **Search Weather**: Seamlessly search for weather details using Apple's WeatherKit.

## License Information:

CWC operates under a proprietary license issued by Caner HK, specifically tailored for the CWC project, and does not employ open-source licenses such as the MIT License or Apache License 2.0. View the license here: [CWC License](https://github.com/iMallpa/CWC-Caner-Weather-Channel/blob/main/LICENSE).

Note that this license may impose certain restrictions on how you can modify and distribute the CWC source code.
