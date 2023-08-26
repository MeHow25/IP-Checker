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
    <title>Document</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
</head>
  <body>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <div id="map" style="width: 600px; height: 400px; position: relative; outline-style: none;" class="leaflet-container leaflet-touch leaflet-fade-anim leaflet-grab leaflet-touch-drag leaflet-touch-zoom"></div>
    <script>
var map = L.map('map').setView([{$latitude}, {$longitude}], 13);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

L.marker([{$latitude}, {$longitude}]).addTo(map)
    .bindPopup('Your location')
    .openPopup();
      </script>
  </body>
</html>
EOT;