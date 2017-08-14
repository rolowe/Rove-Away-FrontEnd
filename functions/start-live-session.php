<?php
  include "../config/config.php";

  $url = 'http://partners.api.skyscanner.net/apiservices/pricing/v1.0/';

  $originplace = substr($_GET['originplace'], 0, 3);
  $destinationplace = substr($_GET['destinationplace'], 0, 3);
  $outbounddate = $_GET['outbounddate'];

  $data = array(
    'apiKey' => 'de995438234178656329029769192274',
    'country' => 'GB',
    'currency' => 'GBP',
    'locale' => 'en-GB',
    'originplace' => $originplace,
    'destinationplace' => $destinationplace,
    'outbounddate' => $outbounddate,
    'locationschema' => 'Iata',
    'adults' => 1
  );

  $httpdata = http_build_query($data);
  $ch = curl_init();
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $httpdata);
  curl_setopt($ch, CURLOPT_HEADER, 1);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Accept: application/json'));
  curl_setopt($ch, CURLOPT_VERBOSE, 1);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $response = curl_exec($ch);
  curl_close($ch);
  //print_r( $response );

  $headers = explode("\n", $response);
  foreach($headers as $header) {
      if (stripos($header, 'Location:') !== false) {
          $location_header = str_replace("Location:", "", $header);
          $session_key = str_replace("http://partners.api.skyscanner.net/apiservices/pricing/uk1/v1.0/", "", $location_header);
          $session_key = str_replace(' ', '', $session_key);

            if ( !empty($session_key) ) {
              session_start();
              $_SESSION['livesession'] = $session_key;
              //echo "Session Key: " . $_SESSION['livesession'];
              header("Location:/live-prices.php");
            }
          exit;
      }
  }
?>
