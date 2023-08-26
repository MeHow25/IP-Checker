<?php

$curl = curl_init();

$userIp = $_SERVER['REMOTE_ADDR'];

curl_setopt_array($curl, [
  CURLOPT_URL => "https://freeipapi.com/api/json/".$userIp,
  CURLOPT_RETURNTRANSFER => true
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo '<pre>'.$response.'</pre>';
}
