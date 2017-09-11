<?php
  include "../config/config.php";

  if($_GET['search'] != "") {
    $searchParam = $_GET['search'];
  } else {
    $searchParam = "united%20kingdom";
  }

  $sUri = "http://partners.api.skyscanner.net/apiservices/autosuggest/v1.0/GB/GBP/en-GB?query=" .$searchParam. "&apiKey=" .$sk_api_key;

  // 3. Query
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $sUri);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/json']);
  $json = curl_exec($ch);
  curl_close($ch);
  // 4. attempt to parse
  if (($oResult = json_decode($json)) === null)
  {
      trigger_error("Something went wrong. Sorry.");
      exit(500);
  }

  //print_r($oResult->Places);
  foreach ($oResult->Places as $Airport) {

  ?>

    <option value="<?php echo $Airport->PlaceId; ?>"><?php echo $Airport->PlaceName; ?> (<?php echo $Airport->CountryName; ?>)</option>

  <?php } ?>
