<?php

$curl = curl_init();

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
  $userIp = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
  $userIp = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
  $userIp = $_SERVER['REMOTE_ADDR'];
}

curl_setopt_array($curl, [
  CURLOPT_URL => "https://freeipapi.com/api/json/".$userIp,
  CURLOPT_RETURNTRANSFER => true
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

$parsedResponse = json_decode($response);
$latitude = $parsedResponse->latitude;
$longitude = $parsedResponse->longitude;

echo <<<EOT
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IP Checker</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="style.css">
    </head>
    <body  >
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <div class="container">
    <div class="grid-container">
      <div class="grid-item">
        <table>          
            <tr>
              <td><b>Your IP address</b></td>
              <td><b>213.134.185.183</b></td>
            </tr>
            <tr>
              <td>Latitude</td>
              <td>52.2296</td>
            </tr>
            <tr>
              <td>Longtitude</td>
              <td>21.0067</td>
            </tr>
            <tr>
              <td>Country</td>
              <td>Poland</td>
            </tr>
            <tr>
              <td>Region</td>
              <td>Mazovia</td>
            </tr>
            <tr>
              <td>City</td>
              <td>Warsaw</td>
            </tr>
            <tr>
              <td>Zip Code</td>
              <td>05-077</td>
            </tr>                        
            <tr>
              <td>Timezone</td>
              <td>+02:00</td>
            </tr>
        </table>
      </div>
      <div class="grid-item">
        <div id="map" style="width: 100%; height: 280px; outline-style: none; position: relative;" class="leaflet-container leaflet-touch leaflet-fade-anim leaflet-grab leaflet-touch-drag leaflet-touch-zoom"></div>
      </div>
    </div>
</div>
    
    <script>
      var map = L.map('map').setView([{ $latitude }, { $longitude }], 12);

      L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
      }).addTo(map);

      L.marker([{ $latitude }, { $longitude }]).addTo(map)
        .bindPopup('Your location')
        .openPopup();
    </script>
  </body>
</html>
EOT;